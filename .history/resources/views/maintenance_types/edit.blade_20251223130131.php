<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proses Penyelesaian Perbaikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 shadow-sm">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Anda sedang memproses alat: <strong>{{ $maintenance->tool->tool_name }}</strong><br>
                            Masalah awal: "{{ $maintenance->note }}"
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form untuk Update / Selesaikan --}}
                    <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Bagian 1: Update Info Saja (Jika masih lanjut perbaikan) --}}
                        <div class="mb-6 border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Info Berjalan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-sm text-gray-700">Tanggal Mulai</label>
                                    <input type="date" name="start_date" value="{{ $maintenance->start_date }}" class="w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label class="block font-bold text-sm text-gray-700">Catatan Kerusakan</label>
                                    <input type="text" name="note" value="{{ $maintenance->note }}" class="w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                            <div class="mt-2 text-right">
                                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">Simpan Perubahan Info Saja</button>
                            </div>
                        </div>

                        {{-- Bagian 2: SELESAIKAN PERBAIKAN --}}
                        <div>
                            <h3 class="text-lg font-medium text-green-700 mb-4">✅ Selesaikan Perbaikan</h3>
                            <div class="bg-green-50 p-4 rounded-md border border-green-200">
                                
                                <div class="mb-4">
                                    <label class="block font-bold text-sm text-gray-700">Tanggal Selesai</label>
                                    <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                {{-- INI DIA INPUT BIAYANYA --}}
                                <div class="mb-4">
                                    <label class="block font-bold text-sm text-gray-700">Biaya Perbaikan (Rp)</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="cost" class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika gratis.</p>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="submit" name="complete_maintenance" value="1" class="px-6 py-2 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 shadow-md">
                                        Selesai & Masukkan Biaya
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>