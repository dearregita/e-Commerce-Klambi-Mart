<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->user()->id)->with('product')->get();
        $total = $carts->sum('product.price * quantity');
        return view('pages.customers.cart.index', compact('carts', 'total'));
    }

    public function store($slug, Request $request)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Cek apakah cart sudah ada untuk produk dan user tertentu
        $cart = Cart::where('product_id', $product->id)
                    ->where('user_id', auth()->user()->id)
                    ->first();

        if ($cart && $cart->size == $request->size) {
            // Jika sudah ada, tambahkan quantity
            $cart->quantity += 1;
            $cart->save();
        } else {
            // Jika belum ada, buat cart baru
            $cart = new Cart();
            $cart->product_id = $product->id;
            $cart->user_id = auth()->user()->id;
            $cart->size = $request->size;
            $cart->quantity = 1;
            $cart->save();
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function add($id)
    {
        // Temukan data keranjang berdasarkan ID
        $cart = Cart::findOrFail($id);
    
        // Ambil produk terkait dari keranjang
        $product = Product::findOrFail($cart->product_id);
    
        // Hitung total jumlah produk dalam keranjang untuk produk yang sama
        $totalQuantity = Cart::where('product_id', $cart->product_id)->sum('quantity');
    
        // Periksa apakah jumlah total + 1 melebihi stok produk
        if ($totalQuantity + 1 > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        }
    
        // Tambahkan jumlah produk di keranjang
        $cart->quantity += 1;
        $cart->save();
    
        return redirect()->back()->with('success', 'Jumlah produk berhasil ditambahkan.');
    }    

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->quantity <= 1) {
            return redirect()->back()->with('error', 'Produk tidak bisa dikurangi lagi. Minimum jumlah adalah 1.');
        }

        $cart->quantity -= 1;
        $cart->save();

        return redirect()->back()->with('success', 'Jumlah produk berhasil dikurangi.');
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
