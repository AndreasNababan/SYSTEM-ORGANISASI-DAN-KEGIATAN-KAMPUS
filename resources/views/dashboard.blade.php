<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">

                <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow-lg sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Selamat Datang Kembali, {{ Auth::user()->name }}!
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
                             @if(Auth::user()->role == 'admin_kampus')
                                Kelola semua organisasi dan event kampus dari sini.
                            @elseif(Auth::user()->role == 'ketua_organisasi')
                                Kelola event dan keanggotaan {{ $stats['organizationName'] ?? 'organisasi Anda' }}.
                            @else
                                Jelajahi organisasi dan event terbaru di kampus kita.
                            @endif
                        </p>
                    </div>
                </div>

                @if (in_array(Auth::user()->role, ['admin_kampus', 'ketua_organisasi']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if (Auth::user()->role == 'admin_kampus' && isset($stats['totalOrganizations']))
                            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg group hover:bg-slate-700 transition duration-150 ease-in-out">
                                <div class="p-6 flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                         <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M8.25 6h7.5M8.25 9h7.5M8.25 12h7.5M8.25 15h7.5M8.25 18h7.5" />
                                         </svg>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-slate-400 truncate group-hover:text-slate-300">Total Organisasi</dt>
                                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white">{{ $stats['totalOrganizations'] }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (isset($stats['totalEvents']))
                            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg group hover:bg-slate-700 transition duration-150 ease-in-out">
                                <div class="p-6 flex items-center">
                                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                         <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                         </svg>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-slate-400 truncate group-hover:text-slate-300">
                                            @if (Auth::user()->role == 'admin_kampus')
                                                Total Event
                                            @else
                                                Event Organisasi Anda (@if($stats['organizationName'] != 'Organisasi (Pending Approval)') {{ $stats['organizationName'] }} @else Pending @endif)
                                            @endif
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100 group-hover:text-white">{{ $stats['totalEvents'] }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if (Auth::user()->role == 'mahasiswa')
                    <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow-lg sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Organisasi Saya
                        </h3>
                        <div class="space-y-4">
                            @forelse ($myOrganizations as $membership)
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                                    <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                                        @if ($membership->organization->logo)
                                            <img src="{{ asset('storage/' . $membership->organization->logo) }}" alt="{{ $membership->organization->name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500 dark:bg-gray-600">
                                                <span class="font-medium text-white dark:text-gray-200">{{ substr($membership->organization->name, 0, 1) }}</span>
                                            </span>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $membership->organization->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-slate-400">Role: {{ ucwords($membership->role) }}</div>
                                        </div>
                                    </div>
                                    <div class="shrink-0">
                                        @if ($membership->status == 'approved')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                Disetujui
                                            </span>
                                        @elseif ($membership->status == 'pending')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                Menunggu Persetujuan
                                            </span>
                                        @else <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-slate-400 py-4">
                                    <p>Anda belum bergabung dengan organisasi manapun.</p>
                                    <a href="{{ route('organizations.browse') }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                        Cari Organisasi Sekarang
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow-lg sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Event Terdekat
                    </h3>
                    <div class="space-y-4">
                        @forelse ($upcomingEvents as $event)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-slate-700 rounded-lg transition duration-150 ease-in-out hover:bg-gray-100 dark:hover:bg-slate-600">
                                <div class="flex-shrink-0 flex flex-col items-center justify-center px-4 py-2 bg-indigo-100 dark:bg-indigo-900 rounded-md shadow-sm">
                                    <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                    <span class="text-sm font-medium text-indigo-500 dark:text-indigo-400">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-slate-400">
                                        oleh {{ $event->organization->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $event->location }}
                                    </p>
                                </div>
                                </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-slate-400 py-10">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada event yang akan datang</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Cek kembali nanti.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>