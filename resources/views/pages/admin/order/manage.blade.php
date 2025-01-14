@extends('layouts.dashboard')

@section('title', 'Dashboard | Pesanan | E-Commerce')

@section('content')
<div class="max-w-screen-xl px-4 py-8 mx-auto sm:px-6 sm:py-12 lg:px-8">
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-semibold leading-7 text-gray-900">Detail Pesanan</h3>
        <p class="mt-1 text-sm text-gray-500">Informasi pelanggan dan detail pesanan.</p>
    </div>
    <div class="mt-6 border-t border-gray-100">
        <dl class="divide-y divide-gray-100">
            <!-- Nama Pelanggan -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-gray-900">Nama Pelanggan</dt>
                <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $order->user->name }}</dd>
            </div>

            <!-- Alamat Pelanggan -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-gray-900">Alamat Pelanggan</dt>
                <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $order->shipping_address }}
                </dd>
            </div>

            <!-- List Produk -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-gray-900">Produk yang Dibeli</dt>
                <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">
                    <ul role="list" class="space-y-2">
                        @foreach ($order->items as $item)
                        <li class="flex justify-between">
                            <div class="flex flex-col gap-2">
                                <div>
                                    <span class="text-base font-bold text-slate-900">
                                        {{ $item->product->name }}
                                    </span>
                                    <span class="text-sm font-medium text-slate-900">
                                        - {{ $item->size }}
                                    </span>
                                </div>
                                <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="object-cover w-12 h-12 rounded-lg">
                            </div>
                            <span>Rp{{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</span>
                        </li>
                        @endforeach
                        <li class="flex justify-between font-semibold">
                            <p>
                                Ongkir
                                @if($order->user->subscription_status == 1)
                                <span class="text-xs text-gray-400">(Sudah Dipotong Diskon Member)</span>
                                @endif
                            </p>
                            <span>Rp{{ number_format($order->postage, 0, ',', '.') }}</span>
                        </li>
                        <li class="flex justify-between font-semibold">
                            <p>
                                Total
                                @if($order->user->subscription_status == 1)
                                <span class="text-xs text-gray-400">(Sudah Dipotong Diskon Member)</span>
                                @endif
                            </p>
                            <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </dd>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-gray-900">Bukti Pembayaran</dt>
                <dd class="mt-1 text-sm text-indigo-600 sm:col-span-2 sm:mt-0">
                    <a href="{{ asset('storage/' . $order->payment->receipt_image) }}" class="hover:underline" download="">Lihat Bukti Pembayaran</a>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Form Input Nomor Resi -->
    <div class="mt-6">
        <form action="{{ route('dashboard.orders.send', $order->id) }}" method="POST">
            @csrf
            <div class="flex flex-col items-center gap-4 mb-4 lg:flex-row">
                <label for="tracking_number" class="block text-sm font-medium text-gray-900">Nomor Resi : </label>
                <input type="text" name="tracking_number" id="tracking_number" class="block w-full max-w-2xl px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if($errors->has('tracking_number'))
                    <span class="mt-2 text-sm text-red-600"> {{ $errors->first('tracking_number') }}</span>
                @endif
            </div>
            <div class="flex justify-end space-x-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Kirim No Resi
                </button>
            </div>
        </form>
    </div>
    <!-- Form Input Nomor Resi -->
    <div class="mt-6">
        <form action="{{ route('dashboard.orders.reject', $order->id) }}" method="POST">
            @csrf
            <div class="flex justify-end space-x-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Tolak Pemesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
