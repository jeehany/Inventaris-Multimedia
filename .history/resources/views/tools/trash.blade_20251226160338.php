<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventaris Tak Terpakai (Sampah)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-sm text-gray-500">
                            Daftar alat yang sudah dihapus/diafkir.
                        </div>
                        <a href="{{ route('tools.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            &larr; Kembali ke Daftar Aktif
                        </a>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full table-auto text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase font-medium">
                                <tr>
                                    <th class="px-4 py-3">Kode</th>
                                    <th class="px-4 py-3">Nama Alat</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Tgl Dihapus</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </a>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($tools as $tool)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-mono">{{ $tool->tool_code }}</td>
                                        <td class="px-4 py-3 font-bold">{{ $tool->tool_name }}</td>
                                        <td class="px-4 py-3">{{ $tool->category->category_name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-red-600">
                                            {{ $tool->deleted_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <form action="{{ route('tools.restore', $tool->id) }}" method="POST" onsubmit="return confirm('Kembalikan alat ini ke daftar aktif?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-green-100 text-green-700 px-3 py-1 rounded-md hover:bg-green-200 text-xs font-bold">
                                                    Pulihkan (Restore)
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-400">
                                            Tidak ada data sampah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tools->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>