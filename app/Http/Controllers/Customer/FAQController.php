<?php

namespace App\Http\Controllers\Customer;

use App\Models\FAQ;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'faq')->first()->value;
        $faqs = FAQ::all();
        
        return view('pages.customers.faq.index', compact('title', 'faqs'));
    }
}
