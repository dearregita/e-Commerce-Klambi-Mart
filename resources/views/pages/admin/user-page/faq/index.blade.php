@extends('layouts.dashboard')

@section('title', 'Dashboard | Konten Pengguna | FAQ | E-Commerce')

@section('content')
<div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
  <div class="pb-5 border-b border-gray-200">
    <h3 class="text-3xl font-bold leading-6 text-gray-900">Kelola Konten FAQ</h3>
    <p class="max-w-4xl mt-3 text-sm text-gray-500">Tempat anda mengelola konten halaman FAQ.</p>
  </div>
</div>

<ul role="list" class="max-w-6xl mx-auto divide-y divide-gray-100 max-lg:px-12">
  <li class="flex flex-col gap-2 py-5 sm:flex-row sm:items-center sm:justify-between gap-x-6">
    <div class="min-w-0">
      <div class="flex items-start gap-x-3">
        <p class="text-base font-semibold leading-6 text-gray-900">Judul</p>
      </div>
      <div class="flex items-center mt-1 text-sm leading-5 text-gray-500 gap-x-2">
        <p class="whitespace-nowrap">
          {{ $title }}
        </p>
      </div>
    </div>
    <div class="flex items-center flex-none gap-x-4">
      <a href="{{ route('dashboard.faq.edit.title') }}" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">Ubah Judul</a>
    </div>
  </li>
</ul>

<div class="mx-auto mt-8 max-w-7xl">
      
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">List QnA</h1>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <a href="{{ route('dashboard.faq.create.qna') }}" class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tambah QnA</a>
      </div>
    </div>
    <div class="flow-root mt-8">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0 w-1/4">Pertanyaan</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-3/4">Jawaban</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0 w-auto">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @forelse ( $faqs as $faq )
                <tr>
                  <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-0">
                    {{ $faq->question }}
                  </td>
                  <td colspan="3" class="px-3 py-4 overflow-hidden text-sm text-gray-500 whitespace-normal text-ellipsis line-clamp-2">
                    {{ $faq->answer }}
                  </td>                
                  <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                    <a href="{{ route('dashboard.faq.edit.qna', $faq->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form action="{{ route('dashboard.faq.delete.qna', $faq->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      
                      <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus QnA ini?')">Hapus</button>
                    </form>
                  </td>
                </tr>
              @empty
                
              @endforelse
            </tbody>
          </table>          
        </div>
      </div>
    </div>
  </div>

    </div>
@endsection