<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Peminjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('borrowers.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                            + Tambah Peminjam
                        </a>
                    </div>

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">Foto</th>
                                <th class="border px-4 py-2">NIS/NIP</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Telepon</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrowers as $borrower)
                                <tr x-data="{ showModal: false }">
                                    <td class="border px-4 py-2 text-center">
                                        @if($borrower->photo)
                                            <img src="{{ asset('storage/' . $borrower->photo) }}" alt="Foto" class="w-12 h-12 rounded-full object-cover mx-auto">
                                        @else
                                            <span class="text-gray-400 text-xs">No Photo</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 font-mono text-blue-600">{{ $borrower->code }}</td>
                                    <td class="border px-4 py-2 font-bold">{{ $borrower->name }}</td>
                                    <td class="border px-4 py-2">{{ $borrower->phone ?? '-' }}</td>
                                    
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center items-center gap-4">
                                            <button @click="showModal = true" class="text-blue-600 hover:underline font-semibold">Edit</button>

                                            <form action="{{ route('borrowers.destroy', $borrower->id) }}" method="POST" onsubmit="return confirm('Hapus data {{ $borrower->name }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                                            </form>
                                        </div>

                                        <div x-show="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center" style="display: none;">
                                            <div class="relative bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-4 text-left">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-bold">Edit Peminjam</h3>
                                                    <button @click="showModal = false" class="text-gray-500 font-bold text-xl">&times;</button>
                                                </div>

                                                <form action="{{ route('borrowers.update', $borrower->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <div class="mb-4">
                                                        <label class="block text-sm font-bold mb-2">NIS/NIP</label>
                                                        <input type="text" name="code" value="{{ $borrower->code }}" class="border rounded w-full py-2 px-3">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-sm font-bold mb-2">Nama</label>
                                                        <input type="text" name="name" value="{{ $borrower->name }}" class="border rounded w-full py-2 px-3">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-sm font-bold mb-2">Telepon</label>
                                                        <input type="text" name="phone" value="{{ $borrower->phone }}" class="border rounded w-full py-2 px-3">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-sm font-bold mb-2">Ganti Foto (Opsional)</label>
                                                        <input type="file" name="photo" class="text-sm border rounded w-full py-2 px-3">
                                                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
                                                    </div>

                                                    <div class="flex justify-end gap-2 mt-6">
                                                        <button type="button" @click="showModal = false" class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</button>
                                                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada data peminjam.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>