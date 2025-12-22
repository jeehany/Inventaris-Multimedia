<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                            <input type="text" name="category_name" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                required placeholder="Contoh: Elektronik">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Kode (prefix)</label>
                            <input type="text" name="code" maxlength="10"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                placeholder="Contoh: LPT (akan dipakai sebagai prefix kode alat)">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                            <textarea name="description" rows="3" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                placeholder="Opsional: Deskripsi singkat kategori ini..."></textarea>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>