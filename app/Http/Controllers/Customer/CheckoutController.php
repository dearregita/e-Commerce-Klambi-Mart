<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use App\Models\Subscription;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->user()->id)->with('product')->get();
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total_price = 0;
        foreach ($carts as $cart) {
            $price_after_discount = ($cart->product->price - ($cart->product->price * $cart->product->discount / 100));
            $total_price += $price_after_discount * $cart->quantity;
        }

        return view('pages.customers.checkout.index', compact('carts', 'total_price'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'alamat' => 'required|string',
            'detail-alamat' => 'nullable|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode-pos' => 'required|integer',
            'bukti-pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10024',
        ], [
            'alamat.required' => 'Alamat harus diisi.',
            'detail-alamat.string' => 'Detail alamat harus berupa teks.',
            'kota.required' => 'Kota harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kode-pos.required' => 'Kode pos harus diisi.',
            'bukti-pembayaran.required' => 'Bukti pembayaran harus diupload.',
            'bukti-pembayaran.file' => 'Bukti pembayaran harus berupa file.',
            'bukti-pembayaran.mimes' => 'Bukti pembayaran harus berupa file JPEG, PNG, JPG, atau PDF.',
            'bukti-pembayaran.max' => 'Bukti pembayaran tidak boleh lebih dari 10 MB.',
        ]);

        $validatedData['alamat'] = implode(', ', array_filter([
            $validatedData['alamat'],
            $request->input('detail-alamat'),
            $validatedData['kota'],
            $validatedData['provinsi'],
            $validatedData['kode-pos'],
        ]));

        if ($request->hasFile('bukti-pembayaran')) {
            $file = $request->file('bukti-pembayaran');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');
            $validatedData['bukti_pembayaran'] = str_replace('public/', '', $filePath);
        }

        $carts = Cart::where('user_id', auth()->user()->id)->with('product')->get();

        $total_price = 0;
        foreach ($carts as $cart) {
            $price_after_discount = ($cart->product->price - ($cart->product->price * $cart->product->discount / 100));
            $total_price += $price_after_discount * $cart->quantity;
        }

        $discounts = ['basic' => 5, 'premium' => 15, 'eksklusif' => 20];
        $paket = Subscription::where('user_id', auth()->user()->id)->value('subscriptions_type');
        $discount = $discounts[$paket] ?? 0;

        $postage = auth()->user()->subscription_status > 0 ? 0 : 20000;

        $orders = new Order();
        $orders->user_id = auth()->user()->id;
        $orders->total_price = $total_price - ($total_price * $discount / 100) + $postage;
        $orders->shipping_address = $validatedData['alamat'];
        $orders->postage = $postage;
        $orders->status = 'pending';
        $orders->save();

        foreach ($carts as $cart) {
            $order_items = new OrderItem();
            $order_items->order_id = $orders->id;
            $order_items->product_id = $cart->product->id;
            $order_items->quantity = $cart->quantity;
            $order_items->price = (($cart->product->price - ($cart->product->price * $cart->product->discount / 100))) - ($cart->product->price * $discount / 100);
            $order_items->size = $cart->size;
            $order_items->total = $order_items->price * $order_items->quantity;
            $order_items->save();
        }

        $payment = new Payment();
        $payment->order_id = $orders->id;
        $payment->receipt_image = $validatedData['bukti_pembayaran'];
        $payment->payment_status = 'pending';
        $payment->transactions_date = now();
        $payment->save();

        Cart::where('user_id', auth()->user()->id)->delete();

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikirimkan.');
    }
    
    public function buy_now($slug, Request $request)
    {
        // Cari produk berdasarkan slug dan size
        $product = Product::where('slug', $slug)->first();
        $size = ProductSize::find($product->product_sizes_id);
        $sizes = explode(',', $size->size);
    
        // Jika produk tidak ditemukan, tampilkan halaman 404
        if (!$product) {
            abort(404, 'Produk tidak ditemukan.');
        }
    
        // Tampilkan halaman checkout
        return view('pages.customers.checkout.buy-now', compact('product', 'sizes'));
    }
    

    public function buy_now_store(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'alamat' => 'required|string',
            'detail-alamat' => 'nullable|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode-pos' => 'required|integer',
            'bukti-pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10024',
            'size' => 'required|in:XS,S,M,L,XL,XXL',
        ], [
            'alamat.required' => 'Alamat harus diisi.',
            'detail-alamat.string' => 'Detail alamat harus berupa teks.',
            'kota.required' => 'Kota harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kode-pos.required' => 'Kode pos harus diisi.',
            'kode-pos.integer' => 'Kode pos harus berupa angka.',
            'bukti-pembayaran.required' => 'Bukti pembayaran harus diupload.',
            'bukti-pembayaran.file' => 'Bukti pembayaran harus berupa file.',
            'bukti-pembayaran.mimes' => 'Bukti pembayaran harus berupa file JPEG, PNG, JPG, atau PDF.',
            'bukti-pembayaran.max' => 'Bukti pembayaran tidak boleh lebih dari 10 MB.',
            'size.required' => 'Size harus diisi.',
            'size.in' => 'Size harus salah satu dari: XS, S, M, L, XL, XXL.',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();

        $validatedData['alamat'] = implode(', ', array_filter([
            $validatedData['alamat'],
            $request->input('detail-alamat'),
            $validatedData['kota'],
            $validatedData['provinsi'],
            $validatedData['kode-pos'],
        ]));

        $discounts = ['basic' => 5, 'premium' => 15, 'eksklusif' => 20];
        $paket = Subscription::where('user_id', auth()->user()->id)->value('subscriptions_type');
        $discount = $discounts[$paket] ?? 0;

        if ($request->hasFile('bukti-pembayaran')) {
            $file = $request->file('bukti-pembayaran');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');
            $validatedData['bukti_pembayaran'] = str_replace('public/', '', $filePath);
        }

        $totalPrice = $product->price - ($product->price * $product->discount / 100) - ($product->price * $discount / 100);

        $postage = auth()->user()->subscription_status > 0 ? 0 : 20000;
        

        $orders = new Order();
        $orders->user_id = auth()->user()->id;
        $orders->total_price = $totalPrice + $postage;
        $orders->postage = $postage;
        $orders->shipping_address = $validatedData['alamat'];
        $orders->status = 'pending';
        $orders->save();
        
        $order_items = new OrderItem();
        $order_items->order_id = $orders->id;
        $order_items->product_id = $product->id;
        $order_items->quantity = 1;
        $order_items->size = $validatedData['size'];
        $order_items->price = $totalPrice;
        $order_items->total = $order_items->price * $order_items->quantity;
        $order_items->save();
        
        $payment = new Payment();
        $payment->order_id = $orders->id;
        $payment->receipt_image = $validatedData['bukti_pembayaran'];
        $payment->payment_status = 'pending';
        $payment->transactions_date = now();
        $payment->save();

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikirimkan.');
    }
}
