<?php

namespace App\Http\Controllers\Customer;

use App\Models\About;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'about')->first()->value;
        $description = Setting::where('name', 'description')->where('category', 'about')->first()->value;
        $image = Setting::where('name', 'images')->where('category', 'about')->first()->value;
        $content = About::get()->first()->content;
        
        return view('pages.customers.about.index', compact('title', 'description', 'image', 'content'));
    }
}
