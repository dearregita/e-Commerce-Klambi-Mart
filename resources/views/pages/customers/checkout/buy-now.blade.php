@extends('layouts.app')

@section('title', 'Pembayaran | E-Commerce')

@section('content')
<div class="pt-12 bg-white">
  <!-- Background color split screen for large screens -->
  <div class="fixed top-0 left-0 hidden w-1/2 h-full bg-white lg:block" aria-hidden="true"></div>
  <div class="fixed top-0 right-0 hidden w-1/2 h-full bg-gray-100 lg:block" aria-hidden="true"></div>

  <main class="relative grid grid-cols-1 mx-auto max-w-7xl gap-x-16 lg:grid-cols-2 lg:px-8 xl:gap-x-48">
    <h1 class="sr-only">Informasi Pesanan</h1>

    <section aria-labelledby="summary-heading" class="px-4 pt-16 pb-10 bg-gray-50 sm:px-6 lg:col-start-2 lg:row-start-1 lg:bg-transparent lg:px-0 lg:pb-16">
      <div class="max-w-lg mx-auto lg:max-w-none">
        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Pesanan</h2>

        <ul role="list" class="text-sm font-medium text-gray-900 divide-y divide-gray-200">
          <li class="flex items-start py-6 space-x-4">
            <img src="{{ asset('./storage/products/' .$product->image) }}" alt="Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps." class="flex-none object-cover object-center w-20 h-20 rounded-md">
            
            <div class="flex-auto space-y-1">
              <h3>{{ $product->name }}</h3>
            </div>
            
            <div class="flex-none text-right">
              <p class="text-base font-medium">
                @if ($product->discount > 0)
                  Rp{{ number_format($product->price - ($product->price * $product->discount / 100), 0, ',', '.') }}
                  <span class="text-gray-400 line-through">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                  </span>
                @else
                  Rp{{ number_format($product->price, 0, ',', '.') }}
                @endif
              </p>
            </div>
          </li>
        </ul>        

        <dl class="hidden pt-6 space-y-6 text-sm font-medium text-gray-900 border-t border-gray-200 lg:block">
          <div class="flex items-center justify-between">
            <dt class="text-gray-600">Total</dt>
            <dd>
              @if ($product->discount > 0)
                Rp{{ number_format($product->price - ($product->price * $product->discount / 100), 0, ',', '.') }}
              @else
                Rp{{ number_format($product->price, 0, ',', '.') }}
              @endif
            </dd>
          </div>
          <div class="flex items-center justify-between">
            <dt class="text-gray-600">Ongkir</dt>
            <dd>
              Rp{{ number_format(
                Auth::user()->subscription_status > 0 
                ? 0
                : 20000,
                0, ',', '.'
            ) }}
            </dd>
          </div>

          @if(Auth::user()->subscription_status > 0)
            @php
              $paket = App\Models\Subscription::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->first();
              
              $discount = 0;

              if($paket->subscriptions_type == 'basic') {
                $discount = 5;
              } elseif($paket->subscriptions_type == 'premium') {
                $discount = 15;
              } elseif($paket->subscriptions_type == 'eksklusif') {
                $discount = 20;
              }

            @endphp
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Diskon Member</dt>
              <dd>
                {{ number_format($discount, 0, ',', '.') }}%
              </dd>
            </div>
          @endif

          <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <dt class="text-base">Total Pembayaran</dt>
            <dd class="text-base">
              Rp{{ number_format(
                  Auth::user()->subscription_status > 0 
                  ? ($product->price - ($product->price * $product->discount / 100)) * (1 - $discount / 100)
                  : ($product->price - ($product->price * $product->discount / 100) + 20000),
                  0, ',', '.'
              ) }}
            </dd>
          </div>
        </dl>
      </div>
    </section>

    <form action="{{ route('checkout.buy_now_store', $product->slug) }}" method="POST" enctype="multipart/form-data" class="px-4 pt-16 pb-36 sm:px-6 lg:col-start-1 lg:row-start-1 lg:px-0 lg:pb-16">
      @csrf
      <div class="max-w-lg mx-auto lg:max-w-none">
        <section aria-labelledby="contact-info-heading">
          <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900">Informasi Pesanan</h2>
    
          <div class="mt-6">
            <label for="email-address" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
              <input type="email" id="email-address" name="email-address" autocomplete="email" class="block w-full h-12 px-4 bg-gray-100 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm"
              value="{{ auth()->user()->email }}"
              disabled>
            </div>
          </div>

          <div class="mt-6">
            <label for="size" class="block text-sm font-medium text-gray-700">Ukuran</label>
            <div class="mt-1">
                <!-- Dropdown ukuran di bawah harga -->
                @php
                    $sizes = array_map('trim', $sizes); // Membersihkan spasi tambahan di setiap ukuran
                @endphp
                <select id="size" name="size" class="block w-full h-12 px-4 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm">
                  @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sizeOption)
                  @if (in_array($sizeOption, $sizes))
                      <!-- Menampilkan ukuran yang tersedia -->
                      <option>{{ $sizeOption }}</option>
                  @else
                      <!-- Menampilkan ukuran yang tidak tersedia dengan gaya berbeda -->
                      <option disabled>
                          {{ $sizeOption }} (Tidak tersedia)
                      </option>
                  @endif
                  @endforeach
              </select>
            </div>
          </div>
        </section>

            
        <section aria-labelledby="shipping-heading" class="mt-10">
          <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Informasi Pengiriman</h2>
        
          <div class="grid grid-cols-1 mt-6 gap-x-4 gap-y-6 sm:grid-cols-3">
        
            <div class="sm:col-span-3"> 
              <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
              <div class="mt-1">
                <textarea id="alamat" name="alamat" autocomplete="street-address" class="block w-full h-24 px-4 py-2 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm">{{ old('alamat') }}</textarea>
              </div>
              @if ($errors->has('alamat'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('alamat') }}</p>
              @endif
            </div>
        
            <div class="sm:col-span-3">
              <label for="detail-alamat" class="block text-sm font-medium text-gray-700">Detail Alamat (Opsional)</label>
              <div class="mt-1">
                <input type="text" id="detail-alamat" name="detail-alamat" class="block w-full h-12 px-4 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm" value="{{ old('detail-alamat') }}">
              </div>
            </div>            
        
            <div>
              <label for="kota" class="block text-sm font-medium text-gray-700">Kota</label>
              <div class="mt-1">
                <input type="text" id="kota" name="kota" autocomplete="address-level2" class="block w-full h-12 px-4 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm" value="{{ old('kota') }}">
              </div>
              @if ($errors->has('kota'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('kota') }}</p>
              @endif
            </div>
        
            <div>
              <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
              <div class="mt-1">
                <input type="text" id="provinsi" name="provinsi" autocomplete="address-level1" class="block w-full h-12 px-4 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm" value="{{ old('provinsi') }}">
              </div>
              @if ($errors->has('provinsi'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('provinsi') }}</p>
              @endif
            </div>
        
            <div>
              <label for="kode-pos" class="block text-sm font-medium text-gray-700">Kode Pos</label>
              <div class="mt-1">
                <input type="text" id="kode-pos" name="kode-pos" autocomplete="postal-code" class="block w-full h-12 px-4 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm" value="{{ old('kode-pos') }}">
              </div>
              @if ($errors->has('kode-pos'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('kode-pos') }}</p>
              @endif
            </div>
          </div>
        </section>        
    
        <section aria-labelledby="payment-heading" class="mt-10">
          <h2 id="payment-heading" class="text-lg font-medium text-gray-900">Detail Pembayaran</h2>
    
          <div class="grid grid-cols-3 mt-6 gap-x-4 gap-y-6 sm:grid-cols-4">
            <div class="col-span-3 sm:col-span-4">
              <img src="{{ asset('storage/qr/code.png') }}" alt="" class="mx-auto">
            </div>
    
            <div class="col-span-3 sm:col-span-4">
              <label for="bukti-pembayaran" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
              <div class="mt-1">
                <input type="file" id="bukti-pembayaran" name="bukti-pembayaran" autocomplete="cc-number" class="block w-full px-4 py-2 border border-gray-400 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm" value="{{ old('alamat') }}">
              </div>
              @if ($errors->has('bukti-pembayaran'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('bukti-pembayaran') }}</p>
              @endif
            </div>
        </section>

        <div class="pt-6 mt-10 border-t border-gray-200 sm:flex sm:items-center sm:justify-between">
          <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:order-last sm:ml-6 sm:w-auto">Bayar</button>
          <p class="mt-4 text-sm text-center text-gray-500 sm:mt-0 sm:text-left">Lakukan pembayaran </p>
        </div>
      </div>
    </form>
    
    
  </main>
</div>
@endsection
