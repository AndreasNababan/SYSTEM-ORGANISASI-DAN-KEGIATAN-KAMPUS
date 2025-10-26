<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Keanggotaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Tampilkan pesan sukses -->
                    @if (session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 dark:bg-green-800 dark:text-green-200 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filter untuk Admin -->
                    @if (Auth::user()->role == 'admin_kampus')
                        <form method="GET" action="{{ route('memberships.index') }}" class="mb-6">
                            <label for="organization_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tampilkan Pendaftar untuk:</label>
                            <select name="organization_id" id="organization_id" class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                                <option value="">-- Semua Organisasi --</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}" {{ $selectedOrgId == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endif

                    <!-- Tabel Pendaftar (Pending) -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Organisasi</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($pendingMemberships as $membership)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $membership->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $membership->organization->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <!-- Tombol Setujui -->
                                            <form action="{{ route('memberships.approve', $membership->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menyetujui anggota ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">Setujui</button>
                                            </form>
                                            <!-- Tombol Tolak -->
                                            <form action="{{ route('memberships.reject', $membership->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menolak anggota ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Belum ada pendaftar yang menunggu persetujuan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $pendingMemberships->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

