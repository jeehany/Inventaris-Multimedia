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
                            {{-- Kode Alat (unik) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kode Alat (Kode unik)</label>
                                <input type="text" id="tool_code" name="tool_code" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50" required>
                            </div>

                            {{-- Nama Alat --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Alat</label>
                                {{-- Kategori --}}
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Kategori</label>
                                    <select id="category_select" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" data-code="{{ $cat->code }}">{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="text" name="tool_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>


                            {{-- Kondisi (Sesuai database kamu: current_condition) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kondisi Fisik</label>
                                <select name="current_condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </div>

                            {{-- Status Ketersediaan (Ini yang kamu minta ada di create) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Status Ketersediaan</label>
                                <select name="availability_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available">Tersedia (Available)</option>
                                    <option value="borrowed">Sedang Dipinjam</option>
                                    <option value="maintenance">Dalam Perbaikan</option>
                                </select>
                            </div>

                            {{-- Jumlah --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Jumlah</label>
                                <input type="number" name="amount" value="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('tools.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('category_select');
            const codeInput = document.getElementById('tool_code');

            async function fetchNext(catId) {
                if (!catId) { codeInput.value = ''; return; }
                try {
                    const res = await fetch(`/categories/${catId}/next-code`);
                    if (!res.ok) return;
                    const json = await res.json();
                    if (json.next) codeInput.value = json.next;
                    else codeInput.value = '';
                } catch (e) {
                    console.error('Fetch next code error', e);
                }
            }

            if (select) {
                select.addEventListener('change', function() { fetchNext(this.value); });
                if (select.value) fetchNext(select.value);
            }
        });
    </script>
</x-app-layout>