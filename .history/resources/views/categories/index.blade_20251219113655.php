<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Kategori Alat') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('categories.create') }}" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                            + Tambah Kategori Baru
                        </a>
                    </div>

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 w-16">No</th>
                                <th class="border px-4 py-2 text-left">Nama Kategori</th>
                                <th class="border px-4 py-2 text-left">Deskripsi</th>
                                <th class="border px-4 py-2 w-48 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr x-data="{ showModal: false }">
                                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2 font-bold text-indigo-700">{{ $category->category_name }}</td>
                                    <td class="border px-4 py-2 text-gray-600">{{ $category->description ?? '-' }}</td>
                                    
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center items-center gap-4">
                                            
                                            <button @click="showModal = true" class="text-blue-600 hover:underline font-semibold">
                                                Edit
                                            </button>

                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>

                                        <div x-show="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center" 
                                             style="display: none;">
                                            
                                            <div class="relative bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-4 text-left">
                                                
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-bold text-gray-900">Edit Kategori</h3>
                                                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700 font-bold text-xl">&times;</button>
                                                </div>

                                                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                                                        <input type="text" name="category_name" value="{{ $category->category_name }}" 
                                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                                        <textarea name="description" rows="3" 
                                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $category->description }}</textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-2 mt-6">
                                                        <button type="button" @click="showModal = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>