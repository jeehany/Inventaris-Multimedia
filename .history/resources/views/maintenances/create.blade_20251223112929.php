<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lapor Perbaikan / Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('maintenances.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Pilih Alat</label>
                            <select name="tool_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                                <option value="">-- Pilih Alat yang Tersedia --</option>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}">
                                        {{ $tool->tool_name }} (Kode: {{ $tool->tool_code }}) - Kondisi: {{ $tool->status }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Hanya alat yang berstatus Available atau Broken yang muncul disini.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Keterangan Kerusakan / Masalah</label>
                            <textarea name="note" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" placeholder="Contoh: Kabel putus, Layar bergaris, Rutin checkup..." required></textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('maintenances.index') }}" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan & Mulai Perbaikan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>