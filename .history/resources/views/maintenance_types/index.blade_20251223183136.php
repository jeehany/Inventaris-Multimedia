<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data: Jenis Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Bagian Atas: Judul Kecil & Tombol Tambah --}}
            <div class="flex justify-between items-center mb-6">
                <div class="text-gray-600">
                    Kelola kategori perbaikan alat di sini.
                </div>
                {{-- Tombol Tambah dengan Style Biru Modern --}}
                <a href="{{ route('maintenance-types.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    + Tambah Jenis Baru
                </a>
            </div>

            {{-- Container Tabel dengan Shadow halus & Sudut Melengkung --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Jenis
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($maintenanceTypes as $index => $type)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $type->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 line-clamp-2">
                                        {{ $type->description ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    
                                    {{-- Tombol Edit (Memicu Modal) --}}
                                    <button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit-type-{{ $type->id }}')"
                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md mr-2 transition-colors">
                                        Edit
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('maintenance-types.destroy', $type->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>

                                    {{-- ================= MODAL EDIT (POPUP) ================= --}}
                                    {{-- Ditaruh disini supaya variabel $type terbaca --}}
                                    <x-modal name="edit-type-{{ $type->id }}" focusable>
                                        <form method="post" action="{{ route('maintenance-types.update', $type->id) }}" class="p-6">
                                            @csrf
                                            @method('PUT')

                                            <div class="flex justify-between items-center border-b pb-3 mb-4">
                                                <h2 class="text-lg font-bold text-gray-900">
                                                    Edit Jenis Maintenance
                                                </h2>
                                                <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600">
                                                    ✕
                                                </button>
                                            </div>

                                            {{-- Input Nama --}}
                                            <div class="mb-4 text-left">
                                                <label class="block font-medium text-sm text-gray-700 mb-1">Nama Jenis</label>
                                                <input type="text" name="name" value="{{ $type->name }}" 
                                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                                       placeholder="Contoh: Service Rutin" required>
                                            </div>

                                            {{-- Input Deskripsi --}}
                                            <div class="mb-6 text-left">
                                                <label class="block font-medium text-sm text-gray-700 mb-1">Deskripsi / Keterangan</label>
                                                <textarea name="description" rows="3" 
                                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                          placeholder="Jelaskan detail jenis maintenance ini...">{{ $type->description }}</textarea>
                                            </div>

                                            <div class="flex justify-end gap-2 pt-2 border-t">
                                                <button type="button" x-on:click="$dispatch('close')" 
                                                        class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Batal
                                                </button>
                                                <button type="submit" 
                                                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal>
                                    {{-- ================= END MODAL ================= --}}

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada data jenis maintenance. Silakan tambah baru.
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