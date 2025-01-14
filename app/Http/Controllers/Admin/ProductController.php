<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        
        return view('pages.admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('pages.admin.product.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer',
            'discount' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10024',
            'sizes' => 'nullable|array', // Pastikan 'sizes' adalah array
            'sizes.*' => 'in:XS,S,M,L,XL,XXL', // Validasi nilai yang diizinkan untuk checkbox ukuran    
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari :max karakter.',
            'description.required' => 'Deskripsi produk harus diisi.',
            'description.string' => 'Deskripsi produk harus berupa teks.',
            'price.required' => 'Harga produk harus diisi.',
            'price.numeric' => 'Harga produk harus berupa angka.',
            'category_id.required' => 'Kategori produk harus dipilih.',
            'category_id.exists' => 'Kategori produk tidak ditemukan.',
            'stock_quantity.required' => 'Stok produk harus diisi.',
            'stock_quantity.integer' => 'Stok produk harus berupa angka.',
            'discount.numeric' => 'Diskon produk harus berupa angka.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format file gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran file gambar tidak boleh lebih dari 10 MB.',
            'sizes.array' => 'Ukuran produk harus berupa array.',
            'sizes.*.in' => 'Ukuran yang dipilih tidak valid.',
        ]);

        if ($request->has('sizes')) {
            $validatedData['sizes'] = implode(',', $request->sizes);
        }

        // Proses upload file gambar jika ada
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $fileName, 'public');
            $validatedData['image'] = $fileName;
        }

        // Buat slug dari nama produk
        $validatedData['slug'] = Str::slug($validatedData['name']);

        $productSize = ProductSize::create([
                            'size' => $validatedData['sizes'],
                        ]);

        // Simpan data ke dalam database
        $product = Product::create([
            'product_sizes_id' => $productSize->id,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'discount' => $validatedData['discount'],
            'image' => $validatedData['image'],
            'slug' => $validatedData['slug'],
        ]);


        // Redirect dengan pesan sukses
        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $productSize = ProductSize::find($product->product_sizes_id);
        $sizes = explode(',', $productSize->size);

        return view('pages.admin.product.edit', compact('product', 'sizes'));
    }

    public function update(Request $request, $slug)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer',
            'discount' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10024',
            'sizes' => 'nullable|array', // Pastikan 'sizes' adalah array
            'sizes.*' => 'in:XS,S,M,L,XL,XXL', // Validasi nilai yang diizinkan untuk checkbox ukuran  
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari :max karakter.',
            'description.required' => 'Deskripsi produk harus diisi.',
            'description.string' => 'Deskripsi produk harus berupa teks.',
            'price.required' => 'Harga produk harus diisi.',
            'price.numeric' => 'Harga produk harus berupa angka.',
            'category_id.required' => 'Kategori produk harus dipilih.',
            'category_id.exists' => 'Kategori produk tidak ditemukan.',
            'stock_quantity.required' => 'Stok produk harus diisi.',
            'stock_quantity.integer' => 'Stok produk harus berupa angka.',
            'discount.required' => 'Diskon produk harus diisi.',
            'discount.numeric' => 'Diskon produk harus berupa angka.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format file gambar harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran file gambar tidak boleh lebih dari 10 MB.',
            'sizes.array' => 'Ukuran produk harus berupa array.',
            'sizes.*.in' => 'Ukuran yang dipilih tidak valid.',
        ]);

        // Temukan produk berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();

        if ($request->has('sizes')) {
            $validatedData['sizes'] = implode(',', $request->sizes);
        }

        $productSize = ProductSize::find($product->product_sizes_id)->update([
            'size' => $validatedData['sizes'],
        ]);

        // Update data produk
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->category_id = $validatedData['category_id'];
        $product->stock_quantity = $validatedData['stock_quantity'];
        $product->discount = $validatedData['discount'];

        // Perbarui file gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            // Simpan gambar baru
            $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $fileName, 'public');
            $product->image = $fileName;
        }

        // Simpan perubahan
        $product->save();

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Pastikan untuk mengecek apakah produk memiliki file gambar sebelum menghapus
        if ($product->image) {
            $imagePath = storage_path('app/public/products/' . $product->image);

            // Cek apakah file gambar benar-benar ada, lalu hapus
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Hapus data produk dari database
        $product->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil dihapus.');
    }

}
