<?php

namespace App\Http\Controllers\Customer;

use App\Models\Policy;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'policy')->first()->value;
        $description = Setting::where('name', 'description')->where('category', 'policy')->first()->value;
        $content = Policy::get()->first()->content;

        return view('pages.customers.policy.index', compact('title', 'description', 'content'));
    }
}
