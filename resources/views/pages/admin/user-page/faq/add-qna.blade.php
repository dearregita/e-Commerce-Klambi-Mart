@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | FAQ | Ubah Judul | E-Commerce')

@section('content')
<div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
  <div class="pb-5 border-b border-gray-200">
    <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola QnA FAQ</h3>
    <p class="max-w-4xl mt-3 text-sm text-gray-500">Halaman ini memungkinkan Anda untuk menambah QNA di halaman FAQ dengan mudah.</p>
  </div>
</div>
<div class="grid grid-cols-1 px-4 pb-12 mx-auto border-b sm:px-6 lg:px-8 gap-x-8 gap-y-10 border-gray-900/10 md:grid-cols-3 max-w-7xl">
  <div>
      <h2 class="text-base font-semibold leading-7 text-gray-900">Manajemen QnA FAQ</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">Tambah dan kelola Qna di halaman FAQ sesuai kebutuhan Anda melalui fitur yang tersedia di sini.</p>                
  </div>


  <form action="{{ route('dashboard.faq.store.qna') }}" method="POST">
      @csrf
      <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
          <div class="sm:col-span-6">
              <label for="question" class="block text-sm font-medium leading-6 text-gray-900">Pertanyaan</label>
              <div class="mt-2">
                  <input type="question" name="question" id="question" 
                      class="block w-full px-3 py-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6" 
                      placeholder="Pertanyaan Anda" value="{{ old('question') }}">
              </div>
              @error('question')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
              @enderror
          </div>
          
          <div class="sm:col-span-6">
              <label for="answer" class="block text-sm font-medium leading-6 text-gray-900">Jawaban</label>
              <div class="mt-2">
                  <input type="answer" name="answer" id="answer" 
                      class="block w-full px-3 py-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6" 
                      placeholder="Jawaban Pertanyaan Anda (tanpa diakhiri ./!/?)" value="{{ old('answer') }}">
              </div>
              @error('answer')
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