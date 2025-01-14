@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | Kebijakan Privasi | E-Commerce')

@section('content')
<div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
  <div class="pb-5 border-b border-gray-200">
    <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola Konten Kebijakan Privasi</h3>
    <p class="max-w-4xl mt-3 text-sm text-gray-500">Tempat anda mengelola konten halaman Kebijakan Privasi.</p>
  </div>
</div>

<ul role="list" class="max-w-6xl mx-auto divide-y divide-gray-100 max-lg:px-12">
  <li class="flex flex-col gap-2 py-5 sm:flex-row sm:items-center sm:justify-between gap-x-6">
    <div class="min-w-0">
      <div class="flex items-start gap-x-3">
        <p class="text-base font-semibold leading-6 text-gray-900">Judul, Deskripsi</p>
      </div>
      <div class="flex items-center mt-1 text-sm leading-5 text-gray-500 gap-x-2">
        <p class="whitespace-nowrap">
          {{ $title }}
        </p>
      </div>
    </div>
    <div class="flex items-center flex-none gap-x-4">
      <a href="{{ route('dashboard.privacy.edit.header') }}" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">Ubah Header</a>
    </div>
  </li>
  <li class="flex flex-col gap-2 py-5 sm:flex-row sm:items-center sm:justify-between gap-x-6">
    <div class="min-w-0">
      <div class="flex items-start gap-x-3">
        <p class="text-base font-semibold leading-6 text-gray-900">Konten Halaman</p>
      </div>
    </div>
    <div class="flex items-center flex-none gap-x-4">
      <a href="{{ route('dashboard.privacy.edit.content') }}" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">Ubah Konten</a>
    </div>
  </li>
</ul>
@endsection