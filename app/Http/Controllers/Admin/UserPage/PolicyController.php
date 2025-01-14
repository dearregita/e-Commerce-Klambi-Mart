<?php

namespace App\Http\Controllers\Admin\UserPage;

use App\Models\Policy;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'policy')->first()->value;
        
        return view('pages.admin.user-page.policy.index', compact('title'));
    }

    public function changeHeader()
    {
        $title = Setting::where('name', 'title')->where('category', 'policy')->first()->value;
        $description = Setting::where('name', 'description')->where('category', 'policy')->first()->value;
        
        return view('pages.admin.user-page.policy.change-header', compact('title', 'description'));
    }


    public function changeHeaderUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari :max karakter.',

            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $title = Setting::where('name', 'title')->where('category', 'policy')->first();
        $description = Setting::where('name', 'description')->where('category', 'policy')->first();

        $title->value = $validatedData['title'];
        $description->value = $validatedData['description'];
        $title->save();
        $description->save();

        return redirect()->route('dashboard.privacy.index')->with('success', 'Berhasil mengubah header'); 
    }

    public function changeContent()
    {
        $content = Policy::get()->first()->content;
        return view('pages.admin.user-page.policy.change-content', compact('content'));
    }

    public function changeContentUpdate(Request $request)
    {
        $validatedData = request()->validate([
            'content' => 'required',
        ], [
            'content.required' => 'Konten harus diisi.',
        ]);

        $policy = Policy::get()->first();
        $policy->content = $validatedData['content'];
        $policy->save();

        return redirect()->route('dashboard.privacy.index')->with('success', 'Berhasil mengubah konten');
    }
}
