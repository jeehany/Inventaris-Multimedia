<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Alat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('tools.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- Nama Alat --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Alat</label>
                                <input type="text" name="tool_name" value="{{ old('tool_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Proyektor Epson X500" required>
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Kondisi --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kondisi Awal</label>
                                <select name="condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </div>

                            {{-- Jumlah (Jika ada kolom amount) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Jumlah Stok (Initial)</label>
                                <input type="number" name="amount" value="1" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('tools.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Batal</a>
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow-sm">
                                Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>