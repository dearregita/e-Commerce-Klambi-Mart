@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | Tentang Kami | Ubah Header | E-Commerce')

@section('content')
<div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
  <div class="pb-5 border-b border-gray-200">
    <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola Header Tentang Kami</h3>
    <p class="max-w-4xl mt-3 text-sm text-gray-500">Halaman ini memungkinkan Anda untuk mengatur dan memperbarui header Tentang Kami dengan mudah.</p>
  </div>
</div>
<div class="grid grid-cols-1 px-4 pb-12 mx-auto border-b sm:px-6 lg:px-8 gap-x-8 gap-y-10 border-gray-900/10 md:grid-cols-3 max-w-7xl">
  <div>
      <h2 class="text-base font-semibold leading-7 text-gray-900">Manajemen Header Tentang Kami</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">Atur dan kelola header Tentang Kami sesuai kebutuhan Anda melalui fitur yang tersedia di sini.</p>                
  </div>


  <form action="{{ route('dashboard.contact.update.data') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        
        <!-- Nama Jalan -->
        <div class="sm:col-span-6">
            <label for="street" class="block text-sm font-medium text-gray-900">Nama Jalan</label>
            <input type="text" name="street" id="street" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Nama Jalan" value="{{ old('street', explode(',', $address)[0] ?? '') }}">
            @error('street')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kota -->
        <div class="sm:col-span-6">
            <label for="city" class="block text-sm font-medium text-gray-900">Kota</label>
            <input type="text" name="city" id="city" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Kota" value="{{ old('city', explode(',', $address)[1] ?? '') }}">
            @error('city')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Provinsi -->
        <div class="sm:col-span-6">
            <label for="province" class="block text-sm font-medium text-gray-900">Provinsi</label>
            <input type="text" name="province" id="province" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Provinsi" value="{{ old('province', explode(',', $address)[2] ?? '') }}">
            @error('province')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kode Pos -->
        <div class="sm:col-span-6">
            <label for="postal_code" class="block text-sm font-medium text-gray-900">Kode Pos</label>
            <input type="text" name="postal_code" id="postal_code" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Kode Pos" value="{{ old('postal_code', explode(',', $address)[3] ?? '') }}">
            @error('postal_code')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="sm:col-span-6">
            <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
            <input type="email" name="email" id="email" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Email" value="{{ old('email', $email) }}">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kode Negara -->
        <div class="sm:col-span-6">
            <label for="country_code" class="block text-sm font-medium text-gray-900">Kode Negara</label>
            <input type="text" name="country_code" id="country_code" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Kode Negara" value="{{ old('country_code', ltrim($country_code, '+')) }}">
            @error('country_code')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor Telepon -->
        <div class="sm:col-span-6">
            <label for="phone_number" class="block text-sm font-medium text-gray-900">Nomor Telepon</label>
            <input type="tel" name="phone_number" id="phone_number" 
                class="block w-full px-3 py-2 mt-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-slate-950 sm:text-sm" 
                placeholder="Nomor Telepon" value="{{ old('phone_number', $phone_number) }}">
            @error('phone_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end sm:col-span-6">
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white rounded-md bg-slate-950 hover:bg-indigo-500">Simpan</button>
        </div>
    </div>
    </form>
</div>
@endsection