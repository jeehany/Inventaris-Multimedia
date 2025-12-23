<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jenis Maintenance (Master Data)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Tambah (Jika Mas punya fitur create modal juga, sesuaikan) --}}
            <div class="mb-4 flex justify-end">
                <a href="{{ route('maintenance-types.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    + Tambah Jenis Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($maintenanceTypes as $index => $type)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $type->name }}</td>
                                <td class="px-6 py-4">{{ $type->description ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    
                                    {{-- TOMBOL EDIT (Memicu Modal menggunakan AlpineJS 'x-data') --}}
                                    <button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit-type-{{ $type->id }}')"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Edit
                                    </button>

                                    <form action="{{ route('maintenance-types.destroy', $type->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- ================= MODAL EDIT (POPUP) ================= --}}
                            {{-- Kita taruh modal di dalam loop supaya ID-nya unik per baris --}}
                            <x-modal name="edit-type-{{ $type->id }}" focusable>
                                <form method="post" action="{{ route('maintenance-types.update', $type->id) }}" class="p-6">
                                    @csrf
                                    @method('PUT')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Edit Jenis Maintenance
                                    </h2>

                                    {{-- Input Nama --}}
                                    <div class="mt-6">
                                        <label class="block font-medium text-sm text-gray-700">Nama Jenis</label>
                                        <input type="text" name="name" value="{{ $type->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>

                                    {{-- Input Deskripsi (INI YANG TADI HILANG) --}}
                                    <div class="mt-4">
                                        <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                                        <textarea name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3">{{ $type->description }}</textarea>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button type="button" x-on:click="$dispatch('close')" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">
                                            Batal
                                        </button>
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                            {{-- ================= END MODAL ================= --}}

                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>