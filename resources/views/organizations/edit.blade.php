<x-app-layout>
    <x-slot name="header">
        <!-- Tambahkan text dark mode -->
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Organisasi') }}
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

                    <form method="POST" action="{{ route('organizations.update', $organization->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Method untuk Update -->

                        <!-- Nama -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Organisasi')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $organization->name)" required autofocus />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <!-- Tambahkan style dark mode untuk textarea -->
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $organization->description) }}</textarea>
                        </div>

                        <!-- Kontak -->
                        <div class="mt-4">
                            <x-input-label for="contact" :value="__('Kontak (Email/WA)')" />
                            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact', $organization->contact)" />
                        </div>

                        <!-- Logo -->
                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Ganti Logo (Opsional)')" />
                            <!-- Tambahkan style dark mode untuk input file DAN event onchange -->
                            <input id="logo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="logo" onchange="previewLogo()">
                        
                             <!-- Beri ID pada gambar yang sudah ada atau siapkan placeholder -->
                            @if ($organization->logo)
                                <img id="logo-preview" src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}" class="h-20 w-20 rounded-md mt-4 object-cover">
                            @else
                                <img id="logo-preview" src="" alt="Logo preview" class="h-20 w-20 rounded-md mt-4 hidden object-cover">
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                             <!-- Tambahkan style dark mode untuk link Batal -->
                            <a href="{{ route('organizations.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
                                Batal
                            </a>
                            
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan JavaScript di akhir, sebelum penutup layout -->
    <script>
        function previewLogo() {
            const logoInput = document.getElementById('logo');
            const logoPreview = document.getElementById('logo-preview');
            
            if (logoInput.files && logoInput.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    logoPreview.src = e.target.result;
                    logoPreview.classList.remove('hidden'); // Tampilkan gambar
                }
                
                reader.readAsDataURL(logoInput.files[0]);
            } else {
                // Jangan sembunyikan jika ini halaman edit dan sudah ada logo
                // logoPreview.src = ""; // Biarkan gambar lama jika tidak ada file baru
                // logoPreview.classList.add('hidden'); 
            }
        }
    </script>
</x-app-layout>

