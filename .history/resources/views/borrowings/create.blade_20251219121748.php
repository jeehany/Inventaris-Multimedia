<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Ada kesalahan!</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Nama Peminjam</label>
                                <select name="borrower_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">-- Cari Peminjam --</option>
                                    @foreach($borrowers as $borrower)
                                        <option value="{{ $borrower->id }}">
                                            {{ $borrower->name }} ({{ $borrower->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Rencana Tanggal Kembali</label>
                                <input type="date" name="planned_return_date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-300">

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2 text-lg">Pilih Alat yang Dipinjam</label>
                            <p class="text-sm text-gray-500 mb-4">*Hanya alat yang statusnya "Available" yang muncul disini.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto border p-4 rounded bg-gray-50">
                                @forelse($tools as $tool)
                                    <div class="flex items-center p-2 border rounded bg-white hover:bg-indigo-50 transition">
                                        <input type="checkbox" name="tool_ids[]" value="{{ $tool->id }}" id="tool_{{ $tool->id }}" class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                        <label for="tool_{{ $tool->id }}" class="ml-3 w-full cursor-pointer">
                                            <span class="block font-semibold text-gray-800">{{ $tool->tool_name }}</span>
                                            <span class="block text-xs text-gray-500">{{ $tool->tool_code }} | Kondisi: {{ $tool->current_condition }}</span>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col-span-3 text-center text-red-500 py-4">
                                        Tidak ada alat yang tersedia saat ini.
                                    </div>
                                @endforelse
                            </div>
                            @error('tool_ids')
                                <p class="text-red-500 text-sm mt-1">Harap pilih minimal satu alat.</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('borrowings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                                Proses Peminjaman
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>