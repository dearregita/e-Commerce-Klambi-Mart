<?php

namespace App\Http\Controllers\Admin\UserPage;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'contact')->first()->value;
        $messages = ContactMessage::latest()->paginate(6);
        
        return view('pages.admin.user-page.contact.index', compact('title', 'messages'));
    }

    public function changeHeader()
    {
        $title = Setting::where('name', 'title')->where('category', 'contact')->first()->value;
        $description = Setting::where('name', 'description')->where('category', 'contact')->first()->value;
        
        return view('pages.admin.user-page.contact.change-header', compact('title', 'description'));
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

        $title = Setting::where('name', 'title')->where('category', 'contact')->first();
        $description = Setting::where('name', 'description')->where('category', 'contact')->first();

        $title->value = $validatedData['title'];
        $description->value = $validatedData['description'];
        $title->save();
        $description->save();

        return redirect()->route('dashboard.contact.index')->with('success', 'Berhasil mengubah header'); 
    }

    public function changeData()
    {
        $address = Contact::first()->address;
        $email = Contact::first()->email;
        $country_code = Contact::first()->country_code;
        $phone_number = Contact::first()->phone_number;
        
        return view('pages.admin.user-page.contact.change-data', compact('address', 'email', 'country_code', 'phone_number'));
    }


    public function changeDataUpdate(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'email' => 'required|email',
            'country_code' => 'required|string|max:5',
            'phone_number' => 'required|string|max:15',
        ], [
            'street.required' => 'Alamat harus diisi.',
            'street.string' => 'Alamat harus berupa teks.',
            'street.max' => 'Alamat tidak boleh lebih dari :max karakter.',

            'city.required' => 'Kota harus diisi.',
            'city.string' => 'Kota harus berupa teks.',
            'city.max' => 'Kota tidak boleh lebih dari :max karakter.',

            'province.required' => 'Provinsi harus diisi.',
            'province.string' => 'Provinsi harus berupa teks.',
            'province.max' => 'Provinsi tidak boleh lebih dari :max karakter.',

            'postal_code.required' => 'Kode pos harus diisi.',
            'postal_code.string' => 'Kode pos harus berupa teks.',
            'postal_code.max' => 'Kode pos tidak boleh lebih dari :max karakter.',

            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus dalam format yang benar.',

            'country_code.required' => 'Kode negara harus diisi.',
            'country_code.string' => 'Kode negara harus berupa teks.',
            'country_code.max' => 'Kode negara tidak boleh lebih dari :max karakter.',

            'phone_number.required' => 'Nomor telepon harus diisi.',
            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',
        ]);

        // Gabungkan alamat menjadi satu string yang dipisahkan koma
        $address = $validatedData['street'] . ', ' . $validatedData['city'] . ', ' . $validatedData['province'] . ', ' . $validatedData['postal_code'];

        // Menambahkan tanda + pada country_code
        $countryCode = '+' . $validatedData['country_code'];

        // Menyimpan data ke dalam database atau ke model lain
        $contactData = Contact::find(1);
        $contactData->address = $address;
        $contactData->email = $validatedData['email'];
        $contactData->country_code = $countryCode;
        $contactData->phone_number = $validatedData['phone_number'];
        $contactData->save();

        return redirect()->route('dashboard.contact.index')->with('success', 'Data kontak berhasil diperbarui');
    }

    public function showMessage($id)
    {
        $message = ContactMessage::find($id);

        return view('pages.admin.user-page.contact.show.index', compact('message'));
    }

    public function deleteMessage($id)
    {
        $message = ContactMessage::find($id);

        $message->delete();

        return redirect()->route('dashboard.contact.index')->with('success', 'Berhasil menghapus pesan');
    }
}
