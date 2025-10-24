<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Judul Halaman -->
        <title>SI Organisasi Kampus</title>

        <!-- Fonts (Bawaan Breeze) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts (Bawaan Breeze, untuk load Tailwind) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        
        <!-- Latar belakang dark-mode yang konsisten -->
        <div class="relative min-h-screen flex flex-col items-center justify-center bg-gray-900 text-white selection:bg-indigo-500 selection:text-white">
            
            <!-- Link Login/Register di pojok kanan atas -->
            @if (Route::has('login'))
                <div class="absolute top-0 right-0 p-6 text-end z-10">
                    @auth
                        <!-- Jika sudah login, tampilkan link Dashboard -->
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Dashboard</a>
                    @else
                        <!-- Jika belum login, tampilkan link Log in & Register -->
                        <a href="{{ route('login') }}" class="font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Konten Hero di Tengah Halaman -->
            <div class="flex flex-col items-center justify-center text-center max-w-2xl mx-auto p-6">
                
                <!-- Logo Aplikasi Anda -->
                <div class="mb-6">
                    <!-- Kita panggil komponen logo yang sudah Anda ubah -->
                    <!-- Ukurannya kita perbesar dengan w-24 h-24 -->
                    <x-application-logo class="w-24 h-24 text-white" />
                </div>

                <!-- Judul Utama -->
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    Sistem Informasi Organisasi Kampus
                </h1>

                <!-- Subjudul/Deskripsi -->
                <p class="text-lg text-gray-400 mb-8">
                    Kelola semua organisasi dan kegiatan kampus Anda di satu tempat terpusat.
                </p>

                <!-- Tombol Aksi (Call to Action) -->
                <div>
                    @auth
                        <!-- Jika sudah login -->
                        <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <!-- Jika belum login -->
                        <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150">
                            Masuk Sekarang
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </body>
</html>
