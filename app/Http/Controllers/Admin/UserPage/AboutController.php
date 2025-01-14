<?php

namespace App\Http\Controllers\Admin\UserPage;

use App\Models\About;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'about')->first()->value;
        
        return view('pages.admin.user-page.about.index', compact('title'));
    }

    public function changeHeader()
    {
        $title = Setting::where('name', 'title')->where('category', 'about')->first()->value;
        $description = Setting::where('name', 'description')->where('category', 'about')->first()->value;
        $images = Setting::where('name', 'images')->where('category', 'about')->first()->value;
        
        return view('pages.admin.user-page.about.change-header', compact('title', 'description', 'images'));
    }


    public function changeHeaderUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'image|mimes:jpeg,png,jpg,gif|max:10024',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari :max karakter.',

            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'images.image' => 'Gambar harus berupa gambar.',
            'images.mimes' => 'Gambar harus berupa JPEG, PNG, JPG, atau GIF.',
            'images.max' => 'Ukuran gambar tidak boleh lebih dari :max kilobytes.',
        ]);

        $title = Setting::where('name', 'title')->where('category', 'about')->first();
        $description = Setting::where('name', 'description')->where('category', 'about')->first();

        if ($request->hasFile('images')) {
            // Ambil data file lama dari database
            $images = Setting::where('name', 'images')->where('category', 'about')->first();
            
            // Jika file lama ada, hapus file lama
            if ($images && $images->value) {
                $oldImagePath = public_path('storage/about/' . $images->value);
                
                // Cek jika file lama ada di dalam penyimpanan
                if (file_exists($oldImagePath)) {
                    // Menghapus file lama
                    unlink($oldImagePath);
                }
            }
        
            // Ambil file baru dari request
            $image = $request->file('images');
            
            // Simpan file baru ke folder 'about' di penyimpanan public
            $imagePath = $image->store('about', 'public');
        
            // Perbarui title dan description di database
            $title->value = $validatedData['title'];
            $description->value = $validatedData['description'];
            $title->save();
            $description->save();
        
            // Simpan nama file baru di database
            $images->value = $image->hashName();
            $images->save();
        } else {
            $title->value = $validatedData['title'];
            $description->value = $validatedData['description'];
            $title->save();
            $description->save();
        }

        return redirect()->route('dashboard.about.index')->with('success', 'Berhasil mengubah header'); 
    }

    public function changeContent()
    {
        $content = About::get()->first()->content;
        return view('pages.admin.user-page.about.change-content', compact('content'));
    }

    public function changeContentUpdate(Request $request)
    {
        $validatedData = request()->validate([
            'content' => 'required',
        ], [
            'content.required' => 'Konten harus diisi.',
        ]);

        $about = About::get()->first();
        $about->content = $validatedData['content'];
        $about->save();

        return redirect()->route('dashboard.about.index')->with('success', 'Berhasil mengubah konten');
    }
}
