<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Jenis Pemeliharaan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Gagal!
                    </p>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">
                    
                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Jenis Pemeliharaan</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola kategori dan tipe pemeliharaan aset.</p>
                    </div>

                    {{-- A. BAGIAN FILTER & SEARCH --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        {{-- Form Filter (MODERN TOOLBAR) --}}
                        <form action="{{ route('maintenance-types.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Input Search --}}
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Jenis / Deskripsi..."
                                    onblur="this.form.submit()">
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('search'))
                                <a href="{{ route('maintenance-types.index') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>
                        
                        {{-- Tombol Trigger Modal Tambah --}}
                        @auth
                            @if(!auth()->user()->isHead())
                                <button onclick="toggleModal('modal-create')" class="w-full md:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Jenis Baru
                                </button>
                            @endif
                        @endauth
                    </div>

                    {{-- B. TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Jenis</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Deskripsi</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($maintenanceTypes as $index => $type)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-slate-800">{{ $type->name }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-slate-600">{{ $type->description ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            @auth
                                                @if(!auth()->user()->isHead())
                                                    <div class="flex justify-center items-center space-x-3">
                                                        {{-- Tombol Edit --}}
                                                        <button onclick="toggleModal('modal-edit-{{ $type->id }}')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        
                                                        {{-- Tombol Hapus --}}
                                                        <button type="button" onclick="openDeleteModal('{{ route('maintenance-types.destroy', $type->id) }}', 'Hapus Jenis {{ $type->name }}?', 'Yakin ingin menghapus jenis pemeliharaan ini?')" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    {{-- MODAL EDIT (Inline per Item) --}}
                                                    <div id="modal-edit-{{ $type->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
                                                        <div class="flex items-center justify-center min-h-screen px-4 text-center">
                                                            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-edit-{{ $type->id }}')"></div>
                                                            <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                                                                <form action="{{ route('maintenance-types.update', $type->id) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <div class="bg-white px-6 py-6">
                                                                        <h3 class="text-lg font-bold text-slate-800 mb-4">Edit Jenis Pemeliharaan</h3>
                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Jenis</label>
                                                                            <input type="text" name="name" value="{{ $type->name }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                                                                            <textarea name="description" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ $type->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3">
                                                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-sm transition">Simpan Perubahan</button>
                                                                        <button type="button" onclick="toggleModal('modal-edit-{{ $type->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-medium transition">Batal</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End Modal Edit --}}

                                                @else
                                                    <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">View Only</span>
                                                @endif
                                            @endauth
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                <p class="text-base font-medium">Belum ada jenis pemeliharaan.</p>
                                                <p class="text-sm mt-1">Tambahkan jenis baru untuk memulai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- C. PAGINATION --}}
                    <div class="mt-8">
                        @if($maintenanceTypes instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $maintenanceTypes->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE --}}
    <div id="modal-create" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-create')"></div>
            <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                <form action="{{ route('maintenance-types.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 py-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Tambah Jenis Baru</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Jenis</label>
                            <input type="text" name="name" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Contoh: Service Rutin">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Keterangan singkat..."></textarea>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-sm transition">Simpan</button>
                        <button type="button" onclick="toggleModal('modal-create')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-medium transition">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                    // Add simple fade-in effect logic if needed/Tailwind handles via classes usually
                } else {
                    modal.classList.add('hidden');
                }
            }
        }
    </script>
    <x-modal-delete id="deleteModal" />
</x-app-layout>