<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat Perawatan / Perbaikan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tampilkan Error Validasi jika ada --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Ups! Ada kesalahan:</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('maintenances.store') }}" method="POST">
                        @csrf

                        {{-- 1. Pilihan Alat --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Alat</label>
                            <select name="tool_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Alat --</option>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : '' }}>
                                        {{ $tool->tool_name }} ({{ $tool->tool_code }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Hanya alat berstatus Available yang muncul.</p>
                        </div>

                        {{-- 2. Pilihan Jenis Maintenance (INI YANG TADI HILANG) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Perbaikan / Perawatan</label>
                            <select name="maintenance_type_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('maintenance_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($types->isEmpty())
                                <p class="text-xs text-red-500 mt-1">
                                    *Data Jenis Maintenance kosong. Harap input data Master Jenis dulu.
                                </p>
                            @endif
                        </div>

                        {{-- 3. Tanggal Mulai --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        {{-- 4. Deskripsi Masalah --}}
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan / Keluhan</label>
                            <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: Oli bocor, layar mati, pembersihan rutin..." required>{{ old('note') }}</textarea>
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