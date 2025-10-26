<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Organisasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('organizations.update', $organization->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <div>
                            <x-input-label for="name" :value="__('Nama Organisasi')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $organization->name)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $organization->description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="contact" :value="__('Kontak (Email/WA)')" />
                            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact', $organization->contact)" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Ganti Logo (Opsional)')" />
                            <input id="logo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400" type="file" name="logo" onchange="previewLogo()">

                             @if ($organization->logo)
                                <div class="mt-4">
                                    <label for="current_logo" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Logo Saat Ini:</label>
                                    <img id="logo-preview" src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}" class="h-20 w-20 rounded-md object-cover inline-block">

                                    <div class="mt-2 flex items-center">
                                         <input id="delete_logo" name="delete_logo" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-slate-800">
                                        <label for="delete_logo" class="ml-2 block text-sm text-gray-900 dark:text-slate-300">Hapus Logo Saat Ini</label>
                                    </div>
                                     </div>
                            @else
                                <img id="logo-preview" src="" alt="Logo preview" class="h-20 w-20 rounded-md mt-4 hidden object-cover">
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                             <a href="{{ route('organizations.index') }}" class="text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800 mr-4">
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

    <script>
        function previewLogo() {
            const logoInput = document.getElementById('logo');
            const logoPreview = document.getElementById('logo-preview');
            const deleteCheckbox = document.getElementById('delete_logo');

            // Jika user memilih file baru, pastikan checkbox hapus tidak tercentang
            if (logoInput.files && logoInput.files[0]) {
                 if (deleteCheckbox) {
                    deleteCheckbox.checked = false;
                 }
                const reader = new FileReader();
                reader.onload = function (e) {
                    logoPreview.src = e.target.result;
                    logoPreview.classList.remove('hidden');
                }
                reader.readAsDataURL(logoInput.files[0]);
            }
        }
    </script>
</x-app-layout>