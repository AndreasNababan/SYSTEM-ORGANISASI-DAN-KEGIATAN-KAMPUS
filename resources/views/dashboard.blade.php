<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Pesan Selamat Datang -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        @if(Auth::user()->role == 'admin_kampus')
                            Anda login sebagai Admin Kampus. Anda memiliki akses penuh ke sistem.
                        @elseif(Auth::user()->role == 'ketua_organisasi')
                            Anda login sebagai Ketua Organisasi.
                        @else
                            Jelajahi kegiatan-kegiatan terbaru di kampus kita.
                        @endif
                    </p>
                </div>
            </div>

            <!-- ================== -->
            <!-- Tampilan Stat Admin Kampus -->
            <!-- ================== -->
            @if(Auth::user()->role == 'admin_kampus')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Stat Card Total Organisasi -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                        <div class="p-6 flex items-center space-x-4">
                            <!-- Ikon -->
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-indigo-500 dark:bg-indigo-600 rounded-full text-white">
                                <!-- Heroicon: building-office-2 -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M8.25 21V3.603M15.75 21V3.603m-7.5 0h7.5m-7.5 18h7.5M9 6.75h.008v.008H9V6.75Zm.75 3h.008v.008H9.75v-.008Zm-.75 3h.008v.008H9v-.008Zm.75 3h.008v.008H9.75v-.008Zm-.75 3h.008v.008H9v-.008Zm7.5-12h.008v.008H16.5V6.75Zm-.75 3h.008v.008H15.75v-.008Zm.75 3h.008v.008H16.5v-.008Zm-.75 3h.008v.008H15.75v-.008Zm.75 3h.008v.008H16.5v-.008Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-400">Total Organisasi</h3>
                                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['totalOrganizations'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card Total Kegiatan -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                        <div class="p-6 flex items-center space-x-4">
                            <!-- Ikon -->
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-blue-500 dark:bg-blue-600 rounded-full text-white">
                                <!-- Heroicon: calendar-days -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-400">Total Kegiatan</h3>
                                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['totalEvents'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- ================== -->
            <!-- Tampilan Ketua Organisasi -->
            <!-- ================== -->
            @elseif(Auth::user()->role == 'ketua_organisasi')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Organisasi Anda: <span class="text-indigo-600 dark:text-indigo-400">{{ $stats['organizationName'] ?? 'Belum ada' }}</span></h3>
                        <p class="mt-2 text-lg">Total Kegiatan Anda: <span class="font-bold">{{ $stats['totalEvents'] ?? 0 }}</span></p>
                        <!-- Nanti kita bisa tambahkan link ke manajemen anggota di sini -->
                    </div>
                </div>

            <!-- ================== -->
            <!-- Tampilan Mahasiswa (Hanya Welcome) -->
            <!-- ================== -->
            @else
                <!-- Sudah dihandle di pesan selamat datang di atas -->
            @endif


            <!-- ================== -->
            <!-- Daftar Kegiatan (Tampil untuk Semua Role) -->
            <!-- ================== -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Kegiatan Terdekat</h3>
                    
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($upcomingEvents as $event)
                            <div class="py-4 flex flex-col sm:flex-row justify-between sm:items-center space-y-2 sm:space-y-0">
                                <div class="flex items-center space-x-4">
                                    <!-- Tanggal -->
                                    <div class="flex-shrink-0 text-center bg-gray-100 dark:bg-gray-700 rounded-md p-2 w-16">
                                        <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</p>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-md font-semibold text-gray-900 dark:text-white">{{ $event->title }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Oleh: {{ $event->organization->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-500">
                                            Waktu: {{ \Carbon\Carbon::parse($event->date)->format('H:i') }} WIB
                                        </p> <!-- <-- INI YANG SAYA PERBAIKI -->
                                    </div>
                                </div>
                                <!-- Tombol (Contoh) -->
                                <a href="#" class="inline-flex justify-center sm:w-auto items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Lihat Detail
                                </a>
                            </div>
                        @empty
                            <div class="py-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-gray-400">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6.75h.008v.008H12v-.008Zm0 3h.008v.008H12v-.008Zm0 3h.008v.008H12v-.008Zm-3-3h.008v.008H9v-.008Zm0 3h.008v.008H9v-.008Zm-3-3h.008v.008H6v-.008Zm0 3h.008v.008H6v-.008Zm6-3h.008v.008H15v-.008Zm0 3h.008v.008H15v-.008Zm3-3h.008v.008H18v-.008Zm0 3h.008v.008H18v-.008Z" />
                                </svg>
                                <p class="mt-2">Belum ada kegiatan yang akan datang.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

