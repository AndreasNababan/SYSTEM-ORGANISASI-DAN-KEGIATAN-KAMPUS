<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Method untuk Update -->

                        <!-- Khusus Admin: Pilih Organisasi -->
                        @if (Auth::user()->role == 'admin_kampus')
                            <div class="mb-4">
                                <x-input-label for="organization_id" :value="__('Penyelenggara')" />
                                <select id="organization_id" name="organization_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Pilih Organisasi --</option>
                                    @foreach ($organizations as $org)
                                        <option value="{{ $org->id }}" {{ old('organization_id', $event->organization_id) == $org->id ? 'selected' : '' }}>
                                            {{ $org->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Judul -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Kegiatan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- Tanggal -->
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Tanggal & Waktu')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="datetime-local" name="date" :value="old('date', $event->date)" required />
                        </div>

                        <!-- Lokasi -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Lokasi')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $event->location)" required />
                        </div>

                        <!-- (Tambahkan preview poster jika ada) -->
                        <div class="mt-4">
                            <x-input-label for="poster" :value="__('Ganti Poster (Opsional)')" />
                            <input id="poster" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="poster">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('events.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

