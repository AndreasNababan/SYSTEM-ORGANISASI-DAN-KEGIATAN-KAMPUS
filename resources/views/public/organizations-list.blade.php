<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cari Organisasi') }}
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

            <!-- Grid Organisasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($organizations as $org)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <!-- Logo -->
                        <img class="h-48 w-full object-cover" 
                             src="{{ $org->logo ? asset('storage/' . $org->logo) : 'https://placehold.co/600x400/374151/FFFFFF?text=Logo' }}" 
                             alt="Logo {{ $org->name }}">
                        
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex-grow">
                            <h3 class="font-semibold text-lg mb-2">{{ $org->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::limit($org->description, 100) }}
                            </p>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="p-6 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                            
                            @if (in_array($org->id, $joinedOrganizationIds))
                                <!-- Jika sudah terdaftar (pending atau approved) -->
                                <span class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest opacity-50">
                                    Sudah Terdaftar
                                </span>
                            @else
                                <!-- Form Tombol Gabung -->
                                <form method="POST" action="{{ route('organizations.join', $org->id) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Gabung
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-400 col-span-3 text-center">Belum ada organisasi yang terdaftar.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $organizations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

