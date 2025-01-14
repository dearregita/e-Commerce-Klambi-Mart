@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | Kebijakan Privasi | Ubah Header | E-Commerce')

@section('content')
<div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
  <div class="pb-5 border-b border-gray-200">
    <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola Header Kebijakan Privasi</h3>
    <p class="max-w-4xl mt-3 text-sm text-gray-500">Halaman ini memungkinkan Anda untuk mengatur dan memperbarui header Kebijakan Privasi dengan mudah.</p>
  </div>
</div>
<div class="grid grid-cols-1 px-4 pb-12 mx-auto border-b sm:px-6 lg:px-8 gap-x-8 gap-y-10 border-gray-900/10 md:grid-cols-3 max-w-7xl">
  <div>
      <h2 class="text-base font-semibold leading-7 text-gray-900">Manajemen Header Kebijakan Privasi</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">Atur dan kelola header Kebijakan Privasi sesuai kebutuhan Anda melalui fitur yang tersedia di sini.</p>                
  </div>


  <form action="{{ route('dashboard.privacy.update.header') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
          <div class="sm:col-span-6">
              <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Judul</label>
              <div class="mt-2">
                  <input type="text" name="title" id="title" 
                      class="block w-full px-3 py-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6" 
                      placeholder="Judul Halaman" value="{{ old('title', $title) }}">
              </div>
              @error('title')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
          </div>

          <div class="sm:col-span-6">
              <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi</label>
              <div class="mt-2">
                  <textarea rows="5" name="description" id="description" 
                      class="block w-full px-3 py-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6" 
                      placeholder="Deskripsi Halaman">{{ old('description', $description) }}</textarea>
              </div>
              @error('description')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
          </div>
          
          <div class="flex justify-end sm:col-span-6">
          <button type="submit" class="px-4 py-2 text-sm font-semibold text-white shadow-sm bg-slate-950 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-950">Simpan</button>
          </div>
      </div>
  </form>
</div>
@endsection