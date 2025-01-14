<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use PDF;

class SubscriptionController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::where('shipping_address', NULL)->where('status', 'pending')->with(['user', 'payment'])->latest()->paginate(10);

        $totalCustomer = Order::where('shipping_address', NULL)->count();
        $totalSubscriptionActive = User::where('subscription_status', 1)->count();
        $totalCompleteOrders = Order::where('shipping_address', NULL)->where('status', 'completed');
        $totalIncome = 0;

        foreach ($totalCompleteOrders->get() as $order) {
            $totalIncome += $order->total_price;
        }
        
        return view('pages.admin.subscription.index', compact('pendingOrders', 'totalCustomer', 'totalSubscriptionActive', 'totalIncome'));
    }

    public function approve(String $id)
    {
        $order = Order::find($id);

        $order->status = "completed";
        $order->save();

        $payment = Payment::where('order_id', $order->id)->first();

        $payment->payment_status = "paid";
        $payment->save();

        $user = User::find($order->user_id);

        $user->subscription_status = 1;
        $user->save();

        $type = NULL;

        if ($order->total_price == 199000) {
            $type = 'basic';
        } else if ($order->total_price == 299000) {
            $type = 'premium';
        } else if ($order->total_price == 499000) {
            $type = 'eksklusif';
        }

        $subscription = new Subscription();
        $subscription->user_id = $order->user_id;
        $subscription->subscriptions_type = $type;
        $subscription->status = "active";
        $subscription->start_date = now();
        $subscription->end_date = $subscription->start_date->addDays(30);
        $subscription->save();

        return redirect()->route('dashboard.subscriptions.index')->with('success', 'Langganan pengguna berhasil disetujui.');
    }

    public function reject(String $id)
    {
        $order = Order::find($id);

        $order->status = "rejected";
        $order->save();

        $payment = Payment::where('order_id', $order->id)->first();

        $payment->payment_status = "failed";
        $payment->save();
        
        return redirect()->route('dashboard.subscriptions.index')->with('success', 'Langganan pengguna berhasil ditolak.');
    }

    public function generateReport()
    {
        // Mendapatkan tanggal awal dan akhir dari bulan ini
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Hitung total pelanggan tanpa alamat pengiriman (tidak valid)
        $totalCustomer = Order::whereNull('shipping_address')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Hitung jumlah pelanggan dengan status langganan aktif
        $totalSubscriptionActive = User::where('subscription_status', 1)->count();

        // Ambil pesanan yang diselesaikan tanpa alamat pengiriman bulan ini
        $totalCompleteOrders = Order::whereNull('shipping_address')
                                    ->where('status', 'completed')
                                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->get();

        // Hitung total pendapatan
        $totalIncome = $totalCompleteOrders->sum('total_price');

        // Data untuk PDF
        $data = [
            'totalCustomer' => $totalCustomer,
            'totalSubscriptionActive' => $totalSubscriptionActive,
            'totalIncome' => $totalIncome,
            'orders' => $totalCompleteOrders,
            'month' => now()->format('F Y'),
        ];

        // Load view dengan data yang sudah diformat
        $pdf = PDF::loadView('layouts.subscription-report', $data);

        // Stream file PDF
        return $pdf->stream("invoice-bulanan-" . now()->format('m-Y') . ".pdf");
    }

}
