<x-app-layout>
    <x-slot name="header">
        <!-- Tambahkan text dark mode -->
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tambahkan bg dark mode -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Tambahkan text dark mode -->
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Khusus Admin: Pilih Organisasi -->
                        @if (Auth::user()->role == 'admin_kampus')
                            <div class="mb-4">
                                <x-input-label for="organization_id" :value="__('Penyelenggara')" />
                                <!-- Tambahkan style dark mode untuk select -->
                                <select id="organization_id" name="organization_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">-- Pilih Organisasi --</option>
                                    @foreach ($organizations as $org)
                                        <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                            {{ $org->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Judul -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Event')" />
                             <!-- Tambahkan style dark mode untuk input text -->
                             <!-- NOTE: Komponen x-text-input sudah otomatis mendapat style dark mode dari Breeze v1.9+ -->
                             <!-- Jika belum, tambahkan manual: dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 -->
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <!-- Tambahkan style dark mode untuk textarea -->
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <!-- Tanggal -->
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Tanggal & Waktu')" />
                            <!-- Tambahkan style dark mode untuk input datetime -->
                             <!-- NOTE: Komponen x-text-input sudah otomatis mendapat style dark mode dari Breeze v1.9+ -->
                            <x-text-input id="date" class="block mt-1 w-full" type="datetime-local" name="date" :value="old('date')" required />
                        </div>

                        <!-- Lokasi -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Lokasi')" />
                            <!-- Tambahkan style dark mode untuk input text -->
                             <!-- NOTE: Komponen x-text-input sudah otomatis mendapat style dark mode dari Breeze v1.9+ -->
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                        </div>

                        <!-- Poster -->
                        <div class="mt-4">
                            <x-input-label for="poster" :value="__('Poster')" />
                             <!-- Tambahkan style dark mode untuk input file DAN event onchange -->
                            <input id="poster" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="poster" onchange="previewPoster()">

                            <!-- Tambahkan placeholder untuk preview -->
                            <img id="poster-preview" src="" alt="Poster preview" class="w-full sm:w-1/2 md:w-1/3 rounded-md mt-4 hidden object-cover">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <!-- Tambahkan style dark mode untuk link Batal -->
                             <a href="{{ route('events.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
                                Batal
                            </a>

                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Tambahkan JavaScript di akhir, sebelum penutup layout -->
    <script>
        function previewPoster() {
            const posterInput = document.getElementById('poster');
            const posterPreview = document.getElementById('poster-preview');

            if (posterInput.files && posterInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    posterPreview.src = e.target.result;
                    posterPreview.classList.remove('hidden'); // Tampilkan gambar
                }

                reader.readAsDataURL(posterInput.files[0]);
            } else {
                posterPreview.src = "";
                posterPreview.classList.add('hidden'); // Sembunyikan jika tidak ada file
            }
        }
    </script>
</x-app-layout>