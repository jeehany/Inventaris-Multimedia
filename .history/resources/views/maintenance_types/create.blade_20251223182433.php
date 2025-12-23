<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jenis Maintenance Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form untuk membuat JENIS maintenance baru --}}
                    {{-- Bukan untuk memilih jenis --}}
                    
                    <form action="{{ route('maintenance-types.store') }}" method="POST">
                        @csrf
                        
                        {{-- Input Nama Jenis --}}
                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Nama Jenis Perawatan</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required placeholder="Contoh: Service Rutin, Perbaikan Berat, Kalibrasi">
                        </div>

                        {{-- Input Deskripsi --}}
                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" placeholder="Keterangan singkat tentang jenis ini..."></textarea>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('maintenance-types.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow">Simpan Jenis Baru</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>