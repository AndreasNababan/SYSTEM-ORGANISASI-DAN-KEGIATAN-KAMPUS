<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Event Kampus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Pesan Sukses/Info -->
            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('info'))
                <div class="mb-4 p-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-900 dark:text-blue-300" role="alert">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Kontainer Utama -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($events as $event)
                            <!-- Card untuk setiap event -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden flex flex-col justify-between">
                                <div>
                                    <!-- Poster Event -->
                                    <img class="h-48 w-full object-cover" src="{{ $event->poster ? asset('storage/' . $event->poster) : 'https://placehold.co/600x400/6366f1/FFF?text=Event' }}" alt="Poster {{ $event->title }}">

                                    <div class="p-5">
                                        <!-- Tanggal Event -->
                                        <p class="text-sm text-indigo-500 dark:text-indigo-400 font-semibold">
                                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB
                                        </p>
                                        <!-- Judul Event -->
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-1 truncate">
                                            {{ $event->title }}
                                        </h3>
                                        <!-- Penyelenggara -->
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Oleh: {{ $event->organization->name }}
                                        </p>
                                        <!-- Lokasi -->
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Lokasi: {{ $event->location }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Bagian Tombol Aksi -->
                                <div class="p-5 bg-gray-100 dark:bg-gray-700/50">
                                    @if (in_array($event->id, $registeredEventIds))
                                        <!-- Jika sudah terdaftar -->
                                        <button class="w-full text-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest" disabled>
                                            Sudah Terdaftar
                                        </button>
                                    @else
                                        <!-- Jika belum terdaftar -->
                                        <form action="{{ route('events.register', $event->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                Daftar Event Ini
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <!-- Jika tidak ada event -->
                            <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Belum ada event</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Silakan cek kembali nanti.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $events->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>