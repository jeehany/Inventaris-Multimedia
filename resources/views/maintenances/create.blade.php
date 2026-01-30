<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Catat Pemerliharaan / Perbaikan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Terdapat kesalahan pada input:
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-xl font-bold text-slate-800">Form Perbaikan Aset</h3>
                        <p class="text-slate-500 mt-1 text-sm">Input data aset yang memerlukan pemerliharaan atau perbaikan.</p>
                    </div>

                    <form action="{{ route('maintenances.store') }}" method="POST">
                        @csrf

                        {{-- 1. Pilihan Alat --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Aset Multimedia</label>
                            <select name="tool_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 font-medium" required>
                                <option value="">-- Cari Aset --</option>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : '' }}>
                                        {{ $tool->tool_name }} ({{ $tool->tool_code }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Aset yang sedang dipinjam tidak akan muncul di sini.
                            </p>
                        </div>

                        {{-- 2. Pilihan Jenis Maintenance --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Perbaikan / Pemerliharaan</label>
                            <select name="maintenance_type_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 font-medium" required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('maintenance_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($types->isEmpty())
                                <p class="text-xs text-rose-500 mt-1 font-semibold">
                                    *Data Jenis Maintenance belum tersedia.
                                </p>
                            @endif
                        </div>

                        {{-- 3. Tanggal Mulai --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        {{-- 4. Deskripsi Masalah --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Keluhan</label>
                            <textarea name="note" rows="4" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400" placeholder="Jelaskan detail kerusakan atau pemerliharaan yang dibutuhkan..." required>{{ old('note') }}</textarea>
                        </div>

                        <div class="flex flex-row-reverse gap-3 border-t border-slate-100 pt-6">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                Simpan Data
                            </button>
                            <a href="{{ route('maintenances.index') }}" class="bg-white border border-slate-300 text-slate-700 px-6 py-2 rounded-lg font-semibold hover:bg-slate-50 transition">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>