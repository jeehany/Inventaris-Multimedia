<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Alat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form Edit --}}
                    <form action="{{ route('tools.update', $tool->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- Nama Alat --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Alat</label>
                                <input type="text" name="tool_name" value="{{ old('tool_name', $tool->tool_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('tool_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            {{-- Kategori (Dropdown) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $tool->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Kondisi --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kondisi Alat</label>
                                <select name="condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik" {{ $tool->condition == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak" {{ $tool->condition == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                            </div>

                            {{-- Status Ketersediaan (Opsional jika ingin diubah manual) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Status</label>
                                <select name="availability_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available" {{ $tool->availability_status == 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="borrowed" {{ $tool->availability_status == 'borrowed' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                    <option value="maintenance" {{ $tool->availability_status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>

                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('tools.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>