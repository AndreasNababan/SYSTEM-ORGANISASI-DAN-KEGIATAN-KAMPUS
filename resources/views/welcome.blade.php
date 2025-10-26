<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark"> <!-- Paksa dark mode -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Judul Halaman (Ambil dari .env) -->
        <title>{{ config('app.name', 'SI Organisasi Kampus') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <!-- Gunakan font Inter untuk tampilan yang lebih modern -->
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles (Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Style custom untuk background pattern -->
        <style>
            body {
                /* Background utama */
                background-color: #0f172a; /* slate-900 */
                 /* Pola SVG halus sebagai background */
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%231e293b' fill-opacity='0.4'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-200">

        <!-- Container Utama -->
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-indigo-500 selection:text-white px-4">

            <!-- Link Login/Register di pojok kanan atas -->
            @if (Route::has('login'))
                <div class="absolute top-0 right-0 p-6 text-end z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-medium text-indigo-400 hover:text-indigo-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 transition duration-150 ease-in-out">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:text-indigo-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 transition duration-150 ease-in-out">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ms-4 font-medium text-indigo-400 hover:text-indigo-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 transition duration-150 ease-in-out">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Konten Hero di Tengah Halaman -->
            <div class="flex flex-col items-center justify-center text-center max-w-3xl mx-auto p-6 mt-16 sm:mt-0">

                <!-- Logo Aplikasi Anda (panggil komponen) -->
                <div class="mb-8">
                     <!-- Ukuran disesuaikan, gunakan komponen -->
                    <x-application-logo class="w-24 h-24 text-white drop-shadow-lg" />
                </div>

                <!-- Judul Utama -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500 mb-5 pb-1">
                    SI Organisasi Kampus
                </h1>

                <!-- Subjudul/Deskripsi -->
                <p class="text-lg sm:text-xl text-slate-400 mb-10 max-w-xl leading-relaxed">
                    Platform digital terintegrasi untuk manajemen organisasi kemahasiswaan, pengelolaan event kampus, dan administrasi keanggotaan secara efisien dan transparan.
                </p>

                <!-- Tombol Aksi (Call to Action) -->
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-full font-semibold text-base text-white uppercase tracking-widest hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition ease-in-out duration-150 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-full font-semibold text-base text-white uppercase tracking-widest hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition ease-in-out duration-150 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd" />
                              <path fill-rule="evenodd" d="M6 10a.75.75 0 01.75-.75h9.546l-1.048-.943a.75.75 0 111.004-1.114l2.5 2.25a.75.75 0 010 1.114l-2.5 2.25a.75.75 0 11-1.004-1.114l1.048-.943H6.75A.75.75 0 016 10z" clip-rule="evenodd" />
                            </svg>
                            Masuk Sekarang
                        </a>
                    @endauth
                </div>
            </div>

             <!-- Footer Profesional -->
             <footer class="absolute bottom-0 left-0 right-0 p-6 text-center text-sm text-slate-500">
               DI Kembangkan Dengan Cinta &copy; {{ date('Y') }} {{ config('app.name', 'SIOK') }}.
            </footer>

        </div>
    </body>
</html>