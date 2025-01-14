@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | Kontak Kami | Pesan | E-Commerce')

@section('content')
<div class="mx-auto my-12 max-w-7xl">
  <a href="{{ route('dashboard.contact.index') }}" class="px-4 py-2 text-sm duration-150 border rounded max-w-7xl hover:bg-slate-100">
    <- Kembali
  </a>
  <div class="px-4 mt-6 sm:px-0">
    <h3 class="px-4 font-semibold text-gray-900 text-base/7">Informasi Pesan</h3>
  </div>
  <div class="px-4 mt-6 border-t border-gray-100">
    <dl class="divide-y divide-gray-100">
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="font-medium text-gray-900 text-sm/6">Nama Lengkap</dt>
        <dd class="mt-1 text-gray-700 text-sm/6 sm:col-span-2 sm:mt-0">
          {{ $message->first_name }} {{ $message->last_name }}
        </dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="font-medium text-gray-900 text-sm/6">Alamat Email</dt>
        <dd class="mt-1 text-gray-700 text-sm/6 sm:col-span-2 sm:mt-0">
          {{ $message->email }}
        </dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="font-medium text-gray-900 text-sm/6">Nomor Telefon</dt>
        <dd class="mt-1 text-gray-700 text-sm/6 sm:col-span-2 sm:mt-0">
          {{ $message->phone }}
        </dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="font-medium text-gray-900 text-sm/6">Pesan</dt>
        <dd class="mt-1 text-gray-700 text-sm/6 sm:col-span-2 sm:mt-0">
          {{ $message->message }}
        </dd>
      </div>
    </dl>
  </div>
</div>
@endsection