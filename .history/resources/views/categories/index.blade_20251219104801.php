<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori Alat') }}
        </h2>
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
                                <th class="border px-4 py-2 w-48 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2 font-bold text-indigo-700">{{ $category->category_name }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border px-4 py-4 text-center text-gray-500">
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