<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Edit Data Aset') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900">Perbarui Informasi Aset</h3>
                        <p class="text-sm text-slate-500">Edit detail aset multimedia. Harap berhati-hati saat mengubah status ketersediaan.</p>
                    </div>

                    <form action="{{ route('tools.update', $tool->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Kode Alat (Readonly) --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-500 mb-2">Kode Aset (Permanen)</label>
                                <input type="text" value="{{ $tool->tool_code }}" readonly 
                                    class="w-full border-slate-200 rounded-lg shadow-sm bg-slate-100 text-slate-500 font-mono cursor-not-allowed">
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-500 mb-2">Kategori</label>
                                <input type="text" value="{{ $tool->category->category_name }}" readonly 
                                    class="w-full border-slate-200 rounded-lg shadow-sm bg-slate-100 text-slate-500 cursor-not-allowed">
                            </div>

                            {{-- Nama Alat --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Aset</label>
                                <input type="text" name="tool_name" value="{{ old('tool_name', $tool->tool_name) }}" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-semibold" required>
                            </div>

                            {{-- Merk --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Merk / Tipe</label>
                                <input type="text" name="brand" value="{{ old('brand', $tool->brand) }}" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            {{-- Tgl Perolehan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Perolehan</label>
                                <input type="date" name="purchase_date" 
                                       value="{{ old('purchase_date', $tool->purchase_date ? date('Y-m-d', strtotime($tool->purchase_date)) : '') }}" 
                                       class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            {{-- Kondisi --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi Fisik</label>
                                <select name="current_condition" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik" {{ $tool->current_condition == 'Baik' ? 'selected' : '' }}>Baik (Normal)</option>
                                    <option value="Rusak" {{ $tool->current_condition == 'Rusak' ? 'selected' : '' }}>Rusak (Perlu Perbaikan)</option>
                                </select>
                            </div>

                            {{-- Status Ketersediaan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Ketersediaan</label>
                                <select name="availability_status" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available" {{ $tool->availability_status == 'available' ? 'selected' : '' }}>Tersedia (Ready)</option>
                                    <option value="borrowed" {{ $tool->availability_status == 'borrowed' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                    <option value="maintenance" {{ $tool->availability_status == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                    <option value="disposed" {{ $tool->availability_status == 'disposed' ? 'selected' : '' }}>Dihapuskan / Hilang</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('tools.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-500/30">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>