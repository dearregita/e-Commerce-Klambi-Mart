@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | Kontak Kami | E-Commerce')

@section('content')
<div class="bg-white">
  <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
<div class="pb-5 border-b border-gray-200">
  <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola Konten Kontak Kami</h3>
  <p class="max-w-4xl mt-3 text-sm text-gray-500">Tempat anda mengelola konten halaman Kontak Kami.</p>
</div>

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
      <a href="{{ route('dashboard.contact.edit.header') }}" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">Ubah Header</a>
    </div>
  </li>
  <li class="flex flex-col gap-2 py-5 sm:flex-row sm:items-center sm:justify-between gap-x-6">
    <div class="min-w-0">
      <div class="flex items-start gap-x-3">
        <p class="text-base font-semibold leading-6 text-gray-900">Alamat, Kontak, Email</p>
      </div>
    </div>
    <div class="flex items-center flex-none gap-x-4">
      <a href="{{ route('dashboard.contact.edit.data') }}" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">Ubah Data Toko</a>
    </div>
  </li>
</ul>

<div class="mx-auto mt-8 max-w-7xl">
      
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Data Pesan</h1>
        <p class="max-w-4xl mt-3 text-sm text-gray-500">Tempat anda mengelola pesan halaman Kontak Kami.</p>
      </div>
    </div>
    <div class="flow-root mt-8">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0 w-1/4">Nama</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-3/4">Jawaban</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0 w-auto">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @forelse ( $messages as $message )
              <tr>
                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-0">
                  {{ $message->first_name }} {{ $message->last_name }}
                </td>
                <td colspan="3" class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ $message->message }}
                </td>
                <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                  <a href="{{ route('dashboard.contact.show', $message->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                  <form action="{{ route('dashboard.contact.delete.message', $message->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
                <tr>
                  <td class="px-4 py-2 text-center text-gray-700 whitespace-nowrap">
                    Belum ada pesan saat ini
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>          
        </div>
        {{-- Pagination --}}
        <div class="flex justify-center px-4 py-2 border-t border-gray-200 rounded-b-lg">
          {{ $messages->links('vendor.pagination.custom', ['item' => $messages]) }}
        </div>
      </div>
    </div>
  </div>

    </div>
@endsection