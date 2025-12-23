<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat Perawatan / Perbaikan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('maintenances.store') }}" method="POST">
                        @csrf

                        {{-- Pilihan Alat --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Alat</label>
                            <select name="tool_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Alat yang Rusak / Perlu Servis --</option>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}">{{ $tool->tool_name }} ({{ $tool->tool_code }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Hanya alat berstatus 'Available' atau 'Borrowed' yang muncul.</p>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai Perbaikan</label>
                            <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        {{-- Deskripsi Masalah --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan Kerusakan / Masalah</label>
                            <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: Mesin bunyi kasar, oli bocor, dll..." required></textarea>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('maintenances.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</a>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700">
                                Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>