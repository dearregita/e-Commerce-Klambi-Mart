@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | Kebijakan Privasi | Ubah Content | E-Commerce')

@section('content')
<div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
  <div class="pb-5 border-b border-gray-200">
    <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola Content Kebijakan Privasi</h3>
    <p class="max-w-4xl mt-3 text-sm text-gray-500">Halaman ini memungkinkan Anda untuk mengatur dan memperbarui content Kebijakan Privasi dengan mudah.</p>
  </div>
</div>
<div class="grid grid-cols-1 px-4 pb-12 mx-auto border-b sm:px-6 lg:px-8 gap-x-8 gap-y-10 border-gray-900/10 md:grid-cols-3 max-w-7xl">
  <div>
      <h2 class="text-base font-semibold leading-7 text-gray-900">Manajemen Content Kebijakan Privasi</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">Atur dan kelola content Kebijakan Privasi sesuai kebutuhan Anda melalui fitur yang tersedia di sini.</p>                
  </div>

  <form action="{{ route('dashboard.privacy.update.content') }}" method="POST" enctype="multipart/form-data" class="w-full md:col-span-2">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 gap-x-6 gap-y-8">
          <div class="col-span-full">
              <label for="content" class="block text-sm font-medium leading-6 text-gray-900">Isi Konten</label>
              <div class="mt-2">
                  <textarea rows="15" name="content" id="content" 
                      class="block w-full px-3 py-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6" 
                      placeholder="Deskripsi Halaman">{{ old('content', $content) }}</textarea>
              </div>
              @error('content')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
          </div>
          
          <div class="flex justify-end col-span-full">
              <button type="submit" class="px-4 py-2 text-sm font-semibold text-white shadow-sm bg-slate-950 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-950">Simpan</button>
          </div>
      </div>
  </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content', // Target textarea ID
        plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        menubar: false,
        height: 400,
        width: '100%' // Ensures editor uses full width
    });
</script>
@endsection
