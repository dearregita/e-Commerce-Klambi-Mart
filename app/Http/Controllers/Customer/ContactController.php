<?php

namespace App\Http\Controllers\Customer;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'contact')->first()->value;
        $description = Setting::where('name', 'description')->where('category', 'contact')->first()->value;
        $contact = Contact::first();
        
        return view('pages.customers.contact.index', compact('title', 'description', 'contact'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'required|email',
            'phone-number' => 'required',
            'message' => 'required',
        ], [
            'first-name.required' => 'Nama depan harus diisi.',
            'last-name.required' => 'Nama belakang harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus dalam format yang benar.',
            'phone-number.required' => 'Nomor telepon harus diisi.',
            'message.required' => 'Pesan harus diisi.',
        ]);

        $contact = new ContactMessage();
        $contact->first_name = $validatedData['first-name'];
        $contact->last_name = $validatedData['last-name'];
        $contact->email = $validatedData['email'];
        $contact->phone = $validatedData['phone-number'];
        $contact->message = $validatedData['message'];
        $contact->save();

        return redirect()->route('contact.index')->with('success', 'Pesan berhasil dikirim.');
    }
}
