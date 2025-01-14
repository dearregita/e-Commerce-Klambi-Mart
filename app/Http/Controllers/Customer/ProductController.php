<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductSize;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(8);
        
        return view('pages.customers.product.index', compact('products'));
    }

    public function detail($slug)
    {
        $product = Product::with('category')->with('product_sizes')->where('slug', $slug)->firstOrFail();
        $sizes = explode(',', $product->product_sizes->size);
        
        return view('pages.customers.product.show.index', compact('product', 'sizes'));
    }
}
