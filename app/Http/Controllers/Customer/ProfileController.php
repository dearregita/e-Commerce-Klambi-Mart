<?php

namespace App\Http\Controllers\Customer;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.customers.profile.index');
    }

    public function profile_update(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'required|max:15',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus dalam format yang benar.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',
            
            'profile_picture.image' => 'Gambar harus berupa gambar.',
            'profile_picture.mimes' => 'Gambar harus berupa JPEG, PNG, JPG, atau GIF.',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_picture')) {
            // Ambil data file lama dari database
            $images = $user->profile_picture;
            
            // Jika file lama ada, hapus file lama
            if ($images) {
                $oldImagePath = public_path('storage/profile-pictures/' . $images);
                
                // Cek jika file lama ada di dalam penyimpanan
                if (file_exists($oldImagePath)) {
                    // Menghapus file lama
                    unlink($oldImagePath);
                }
            }
        
            // Ambil file baru dari request
            $image = $request->file('profile_picture');
            
            // Simpan file baru ke folder 'profile' di penyimpanan public
            $imagePath = $image->store('profile-pictures', 'public');
        
            // Simpan nama file baru di database
            $images = $image->hashName();

            // Perbarui title dan description di database
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'profile_picture' => $images
            ]);
        
        } else {
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }


    public function change_password(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'old-password' => 'required',
            'new-password' => 'required|min:8|confirmed',
            'new-password_confirmation' => 'required',
        ], [
            'old-password.required' => 'Kata sandi lama harus diisi.',
            'new-password.required' => 'Kata sandi baru harus diisi.',
            'new-password.min' => 'Kata sandi baru harus memiliki minimal :min karakter.',
            'new-password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'new-password_confirmation.required' => 'Konfirmasi kata sandi harus diisi.',
        ]);

        // Verifikasi kata sandi lama
        if (!Hash::check($request->input('old-password'), auth()->user()->password)) {
            return redirect()->back()->withErrors(['old-password' => 'Kata sandi lama tidak sesuai.']);
        }

        // Update kata sandi baru
        $user = auth()->user();
        $user->update([
            'password' => \Hash::make($validatedData['new-password']),
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
