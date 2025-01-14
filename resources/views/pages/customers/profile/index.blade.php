    @extends('layouts.app')

    @section('title', 'Profil | E-Commerce')

    @section('content')
    <div class="container max-w-screen-xl min-h-screen px-4 py-8 mx-auto sm:px-6 sm:py-12 lg:px-8">
    <div class="pt-12 space-y-12">
        <!-- Bagian Profil -->
        <div class="grid grid-cols-1 pb-12 border-b gap-x-8 gap-y-10 border-gray-900/10 md:grid-cols-3">
            <div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Profil</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Pastikan informasi profil Anda akurat dan sesuai. Beberapa informasi mungkin terlihat oleh orang lain, jadi berhati-hatilah saat membagikan detail pribadi.</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                    <div class="sm:col-span-6">
                        <div>
                            <label for="profile_picture" class="block text-sm font-medium leading-6 text-gray-900">Foto Profile</label>
                            <label for="profile_picture" class="mt-2 border {{ Auth::user()->profile_picture ? '' : 'p-2.5'}} hover:text-gray-500/75 rounded-full w-12 h-12 flex items-center justify-center cursor-pointer transition ">
                                @if (Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/profile-pictures/' . Auth::user()->profile_picture) }}" alt="" class="object-cover w-12 h-12 rounded-full">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"></path></svg>
                                @endif
                            </label>
                        </div>
                        <div class="mt-2">
                            <input type="file" name="profile_picture" id="profile_picture"
                                    class="hidden">
                        </div>
                        @error('profile_picture')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name"
                                    class="block w-full px-3 py-2 text-gray-900 border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6"
                                    placeholder="Nama Pengguna" value="{{ old('name', auth()->user()->name) }}">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email"
                                    class="block w-full px-3 py-2 text-gray-900 border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6"
                                    placeholder="customer@example.com" value="{{ old('email', auth()->user()->email) }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">No. Telepon</label>
                        <div class="mt-2">
                            <input type="text" name="phone" id="phone"
                                    class="block w-full px-3 py-2 text-gray-900 border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6"
                                    placeholder="08123456789" value="{{ old('phone', auth()->user()->phone) }}">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end sm:col-span-6">
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white shadow-sm bg-slate-950 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-950">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bagian Kata Sandi -->
        <div class="grid grid-cols-1 pb-12 border-b gap-x-8 gap-y-10 border-gray-900/10 md:grid-cols-3">
            <div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Perbarui Kata Sandi</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Pastikan kata sandi baru Anda aman dan sulit ditebak. Hindari menggunakan informasi pribadi yang mudah dikenali sebagai bagian dari kata sandi Anda.</p>
            </div>

            <form action="{{ route('profile.change_password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                    <div class="sm:col-span-6">
                        <label for="old-password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi Lama</label>
                        <div class="mt-2">
                            <input id="old-password" name="old-password" type="password"
                                    class="block w-full px-3 py-2 text-gray-900 border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6">
                        </div>
                        @error('old-password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="new-password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi Baru</label>
                        <div class="mt-2">
                            <input id="new-password" name="new-password" type="password"
                                    class="block w-full px-3 py-2 text-gray-900 border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6">
                        </div>
                        @error('new-password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="new-password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Kata Sandi Baru</label>
                        <div class="mt-2">
                            <input id="new-password_confirmation" name="new-password_confirmation" type="password"
                                    class="block w-full px-3 py-2 text-gray-900 border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-950 sm:text-sm sm:leading-6">
                        </div>
                        @error('new-password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end sm:col-span-6">
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white shadow-sm bg-slate-950 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-950">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    @endsection
