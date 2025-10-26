<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Organisasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('organizations.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Tambah Organisasi
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tabel Organisasi -->
                     <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Logo</th>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">Kontak</th>
                                    <th scope="col" class="py-3 px-6"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($organizations as $org)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">
                                            @if ($org->logo)
                                                <img src="{{ asset('storage/' . $org->logo) }}" alt="{{ $org->name }}" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <span class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs">No Logo</span>
                                            @endif
                                        </td>
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $org->name }}</th>
                                        <td class="py-4 px-6">{{ $org->contact ?? '-' }}</td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                             <!-- ==== TAMBAHAN BARU (LANGKAH 4) ==== -->
                                            <a href="{{ route('organizations.members', $org->id) }}" class="font-medium text-green-600 dark:text-green-500 hover:underline mr-3">Anggota</a>
                                            <!-- =============================== -->
                                            <a href="{{ route('organizations.edit', $org->id) }}" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline mr-3">Edit</a>
                                            <form action="{{ route('organizations.destroy', $org->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus organisasi ini? Semua data terkait (event, anggota) akan ikut terhapus!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="4" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">Belum ada data organisasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $organizations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>