<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        // Mengambil order dengan shipping_address yang tidak null
        $pendingOrders = Order::whereNotNull('shipping_address')->where('status', 'pending')->with(['user', 'items', 'payment'])->latest()->paginate(10);

        $orders = Order::whereNotNull('shipping_address')->where('status', '!=', 'pending')->with(['user', 'items', 'payment'])->latest()->paginate(10);

        $totalCustomer = Order::whereNotNull('shipping_address')->count();
        $totalCompleteOrders = Order::whereNotNull('shipping_address')->where('status', 'arrived');
        $totalIncome = 0;

        foreach ($totalCompleteOrders->get() as $order) {
            $totalIncome += $order->total_price;
        }

        $totalCompleteOrders = $totalCompleteOrders->count();

        // Mengembalikan tampilan dengan data order
        return view('pages.admin.order.index', compact('pendingOrders', 'orders', 'totalCustomer', 'totalCompleteOrders', 'totalIncome'));
    }

    public function manage($id) {
        $order = Order::where('id', $id)->with(['user', 'items', 'payment'])->first();

        return view('pages.admin.order.manage', compact('order'));
    }

    public function send(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tracking_number' => 'required|string',
        ], [
            'tracking_number.required' => 'Nomor Resi harus diisi.',
        ]);

        $order = Order::findOrFail($id);

        $order->status = 'delivered';
        $order->save();

        $payment = Payment::where('order_id', $order->id)->first();

        $payment->payment_status = 'paid';
        $payment->save();

        $products = $order->items;

        foreach ($products as $product) {
            $prd = Product::where('id', $product->product_id)->first();
            $prd->stock_quantity -= $product->quantity;
            $prd->save();
        }

        $shipping = new Shipping();
        $shipping->order_id = $order->id;
        $shipping->tracking_number = $validatedData['tracking_number'];
        $shipping->save();

        return redirect()->route('dashboard.orders.index')->with('success', 'Order berhasil dikirim.');
    }

    public function reject($id)
    {
        $order = Order::find($id);

        $order->status = "rejected";
        $order->save();

        return redirect()->route('dashboard.orders.index')->with('success', 'Order berhasil ditolak.');
    }

    public function generateReport()
    {
        // Mendapatkan tanggal awal dan akhir dari bulan ini
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Hitung total pelanggan tanpa alamat pengiriman (tidak valid)
        $totalCustomer = Order::whereNotNull('shipping_address')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Hitung jumlah pelanggan dengan status langganan aktif
        $totalCompleteOrders = Order::whereNotNull('shipping_address')
        ->where('status', 'arrived')
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->count();

        // Ambil pesanan yang diselesaikan tanpa alamat pengiriman bulan ini
        $totalOrders = Order::whereNotNull('shipping_address')
                                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->get();

        // Hitung total pendapatan
        $totalIncome = $totalOrders->sum('total_price');

        // Data untuk PDF
        $data = [
            'totalCustomer' => $totalCustomer,
            'totalCompleteOrders' => $totalCompleteOrders,
            'totalIncome' => $totalIncome,
            'orders' => $totalOrders,
            'month' => now()->format('F Y'),
        ];

        // Load view dengan data yang sudah diformat
        $pdf = PDF::loadView('layouts.orders-report', $data);

        // Stream file PDF
        return $pdf->stream("invoice-bulanan-" . now()->format('m-Y') . ".pdf");
    }

}
