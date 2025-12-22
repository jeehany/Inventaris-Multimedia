<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Alat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('tools.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kode Alat</label>
                            <input type="text" name="tool_code" class="border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: LPT-001">
                        </div>

                        <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Alat</label>
    <select name="category_id" class="border rounded w-full py-2 px-3 text-gray-700" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat</label>
                            <input type="text" name="tool_name" class="border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Laptop Asus">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Saat Ini</label>
                            <input type="text" name="current_condition" class="border rounded w-full py-2 px-3 text-gray-700" value="Baik">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select name="availability_status" class="border rounded w-full py-2 px-3 text-gray-700">
                                <option value="available">Tersedia</option>
                                <option value="borrowed">Sedang Dipinjam</option>
                                <option value="maintenance">Sedang Perbaikan</option>
                                <option value="lost">Hilang</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Data
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>