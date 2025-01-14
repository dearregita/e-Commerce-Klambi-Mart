<div class="pb-16 sm:pb-24">
  <div class="max-w-2xl px-4 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-12">
      <div class="lg:col-span-5 lg:col-start-8">
        <div class="flex justify-between">
          <h1 class="text-xl font-medium text-gray-900">
            {{ $product->name }}
          </h1>
          <p class="text-xl font-medium text-gray-900">
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
        <div class="flex justify-between px-2">
          <p class="text-base text-gray-900">
            Sisa Stok
          </p>
          <p class="text-lg font-semibold text-gray-900">
            {{ $product->stock_quantity }}
          </p>
        </div>
      </div>

      <!-- Image gallery -->
      <div class="lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
        <h2 class="sr-only">Foto Produk</h2>

        <div class="grid grid-cols-1 lg:gap-8">
          <img src="{{ asset('storage/products/'.$product->image) }}" alt="{{ $product->name }}" class="duration-150 lg:col-span-2 lg:row-span-2 hover:scale-105 brightness-75 hover:brightness-100">
        </div>
      </div>

      <div class="lg:col-span-5">
        <form action="{{ route('cart.store', $product->slug) }}" method="POST">
          @csrf
          <!-- Size picker -->
          <div class="mt-8">
              <div>
                <label class="text-base font-semibold text-gray-900">Ukuran</label>
                <fieldset class="mt-4">
                  <legend class="sr-only">Ukuran pakaian</legend>
                  <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                      @php
                          $sizes = array_map('trim', $sizes); // Membersihkan spasi tambahan di setiap ukuran
                      @endphp
              
                      @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sizeOption)
                          <div class="flex items-center">
                              @if (in_array($sizeOption, $sizes))
                                  <!-- Menampilkan ukuran yang tersedia -->
                                  <span class="block ml-3 text-sm font-medium leading-6 text-gray-900">
                                      {{ $sizeOption }}
                                  </span>
                              @else
                                  <!-- Menampilkan ukuran yang tidak tersedia dengan gaya berbeda -->
                                  <span class="block ml-3 text-sm font-medium leading-6 text-gray-400">
                                      {{ $sizeOption }} <br> (Tidak tersedia)
                                  </span>
                              @endif
                          </div>
                      @endforeach
                  </div>
              </fieldset>                                       
              </div>
            
          </div>

          @if ($product->stock_quantity >= 1)
            <!-- Dropdown ukuran di bawah harga -->
            <div class="my-4">
              <select id="size" name="size" class="block w-full px-3 py-2 pr-10 text-gray-900 border-0 rounded-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sizeOption)
                      <div class="flex items-center">
                          @if (in_array($sizeOption, $sizes))
                          <option value="{{ $sizeOption }}">
                            {{ $sizeOption }}
                          </option>
                          @else
                          <option value="{{ $sizeOption }}" disabled>
                            {{ $sizeOption }} <br> (Tidak tersedia)
                          </option>
                          @endif
                      </div>
                  @endforeach
              </select>
            </div>
            <button type="submit" class="flex items-center justify-center w-full px-8 py-3 mt-2 text-base font-medium border-2 text-slate-900 border-slate-900 hover:border-slate-700 focus:outline-none focus:ring-2 hover:bg-slate-100 focus:ring-indigo-500 focus:ring-offset-2">Tambah ke keranjang</button>

            <a href="{{ route('checkout.buy_now',  ['slug' => $product->slug]) }}" class="flex items-center justify-center w-full px-8 py-3 mt-8 text-base font-medium text-white border border-transparent bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Beli Sekarang</a>
                                        
          @endif
        </form>

        <!-- Product details -->
        <div class="mt-10">
          <h2 class="text-sm font-medium text-gray-900">Deskripsi Produk</h2>

          <div class="mt-4 prose-sm prose text-gray-500">
            <p>{{ $product->description }}.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  
</script>
