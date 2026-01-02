<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Daftar Aset') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. PESAN SUKSES --}}
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg" role="alert">
                    <div class="flex items-center gap-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </div>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            {{-- 2. KONTAINER UTAMA --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    {{-- A. BAGIAN FILTER & SEARCH --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                        
                        {{-- Form Filter --}}
                        <form action="{{ route('tools.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
                            
                            {{-- Input Search --}}
                            <div class="relative w-full md:w-64">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                    placeholder="Cari Nama / Kode...">
                            </div>

                            {{-- Dropdown Status Ketersediaan --}}
                            <select name="status" class="w-full md:w-auto border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">- Semua Status -</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="missing" {{ request('status') == 'missing' ? 'selected' : '' }}>Hilang/Rusak</option>
                            </select>

                            {{-- Dropdown Kategori --}}
                            <select name="category_id" class="w-full md:w-auto border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="all">- Semua Kategori -</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Tombol Filter --}}
                            <button type="submit" class="w-full md:w-auto bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 text-sm font-medium transition shadow-md">
                                Filter
                            </button>

                            {{-- Tombol Reset --}}
                            @if(request('search') || request('status') || request('category_id'))
                                <a href="{{ route('tools.index') }}" class="w-full md:w-auto bg-white border border-slate-300 text-slate-600 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm transition font-medium text-center">
                                    Reset
                                </a>
                            @endif
                        </form>

                        {{-- Tombol Tambah & Trash --}}
                        <div class="flex gap-2 w-full md:w-auto">


                            @auth
                                @if(auth()->user()->isHead())
                                    <a href="{{ route('tools.exportExcel', request()->query()) }}" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-5 rounded-lg shadow-lg hover:shadow-emerald-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Export Laporan
                                    </a>
                                @else
                                    <a href="{{ route('tools.create') }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Aset
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    {{-- B. TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode Aset</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Aset</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Kondisi</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($tools as $index => $tool)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500">
                                            {{ $tools->firstItem() + $index }}
                                        </td>
                                        
                                        {{-- KODE --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100">
                                                {{ $tool->tool_code }}
                                            </span>
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-slate-800">{{ $tool->tool_name }}</span>
                                                <span class="text-xs text-slate-500">{{ $tool->brand ?? 'Tanpa Merk' }}</span>
                                            </div>
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                                {{ $tool->category->category_name ?? '-' }}
                                            </span>
                                        </td>

                                        {{-- KONDISI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tool->current_condition == 'Baik' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                                {{ $tool->current_condition }}
                                            </span>
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($tool->availability_status == 'available')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Tersedia</span>
                                            @elseif($tool->availability_status == 'borrowed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Dipinjam</span>
                                            @elseif($tool->availability_status == 'maintenance')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">Maintenance</span>
                                            @else 
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">{{ ucfirst($tool->availability_status) }}</span>
                                            @endif
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                
                                                {{-- 1. TOMBOL DETAIL --}}
                                                <button type="button" onclick="document.getElementById('modal-detail-{{ $tool->id }}').classList.remove('hidden')" 
                                                    class="text-sky-600 hover:text-sky-900 bg-sky-50 p-2 rounded-lg hover:bg-sky-100 transition" title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                @auth
                                                    @if(!auth()->user()->isHead())
                                                        {{-- Edit --}}
                                                        <a href="{{ route('tools.edit', $tool->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                        
                                                        {{-- Hapus (Soft Delete) --}}
                                                        <button type="button" 
                                                                onclick="openDeleteModal('{{ $tool->id }}', '{{ $tool->tool_name }}', '{{ $tool->tool_code }}')" 
                                                                class="text-rose-600 hover:text-rose-900 bg-rose-50 p-2 rounded-lg hover:bg-rose-100 transition" title="Hapus / Musnahkan">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    @endif
                                                @endauth
                                            </div>

                                            {{-- --- MODAL DETAIL (Inline) --- --}}
                                            <div id="modal-detail-{{ $tool->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                {{-- Backdrop Blur --}}
                                                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modal-detail-{{ $tool->id }}').classList.add('hidden')"></div>
                                                
                                                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                                                    <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-slate-200">
                                                        
                                                        {{-- Modal Header --}}
                                                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                                                            <h3 class="text-lg font-bold text-slate-800" id="modal-title">
                                                                Detail Aset
                                                            </h3>
                                                            <button onclick="document.getElementById('modal-detail-{{ $tool->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </div>

                                                        {{-- Modal Body --}}
                                                        <div class="px-6 py-6">
                                                            <div class="flex items-center gap-4 mb-6">
                                                                <div class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl">
                                                                    {{ substr($tool->tool_name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <div class="text-2xl font-bold text-slate-800">{{ $tool->tool_name }}</div>
                                                                    <div class="text-sm text-slate-500 font-mono">{{ $tool->tool_code }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="space-y-4 text-sm">
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Merk / Tipe</span>
                                                                    <span class="col-span-2 text-slate-800 font-medium">{{ $tool->brand ?? '-' }}</span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Kategori</span>
                                                                    <span class="col-span-2 text-slate-800 font-medium">{{ $tool->category->category_name ?? '-' }}</span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Tahun Perolehan</span>
                                                                    <span class="col-span-2 text-slate-800 font-medium">{{ $tool->purchase_date ? \Carbon\Carbon::parse($tool->purchase_date)->translatedFormat('d F Y') : '-' }}</span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Kondisi</span>
                                                                    <span class="col-span-2">
                                                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $tool->current_condition == 'Baik' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                                            {{ $tool->current_condition }}
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4">
                                                                    <span class="font-semibold text-slate-500">Sumber</span>
                                                                    <span class="col-span-2 font-medium">
                                                                        @if($tool->purchase_item_id)
                                                                            <span class="text-indigo-600 flex items-center gap-1">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                                                Pengadaan
                                                                            </span>
                                                                        @else
                                                                            <span class="text-slate-500">Input Manual / Hibah</span>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Modal Footer --}}
                                                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-slate-100">
                                                            <button type="button" onclick="document.getElementById('modal-detail-{{ $tool->id }}').classList.add('hidden')" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:w-auto sm:text-sm transition">
                                                                Tutup
                                                            </button>
                                                            @if(auth()->user()->isAdmin())
                                                                <a href="{{ route('tools.edit', $tool->id) }}" class="mr-3 w-full inline-flex justify-center rounded-lg shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none sm:w-auto sm:text-sm transition">
                                                                    Edit Data
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END MODAL --}}

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                <p class="text-base font-medium">Belaum ada aset.</p>
                                                <p class="text-sm mt-1">Gunakan tombol Tambah Aset untuk memulai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- C. PAGINATION --}}
                    <div class="mt-8">
                        {{ $tools->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    {{-- MODAL DELETE PREMIUM --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full ring-1 ring-slate-200">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-100 rounded-full mb-4">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-center text-slate-800 mb-2">Hapus Aset?</h3>
                        <p class="text-sm text-center text-slate-500 mb-6">
                            Anda akan menghapus aset <strong id="delToolName" class="text-slate-800"></strong> (<span id="delToolCode" class="font-mono"></span>). <br>
                            Data akan dipindahkan ke <strong>Trash (Sampah)</strong>.
                        </p>

                        {{-- DROPDOWN ALASAN --}}
                        <div class="bg-rose-50 p-4 rounded-xl border border-rose-100">
                            <label class="block text-sm font-bold text-rose-800 mb-2">Alasan Penghapusan:</label>
                            <select name="disposal_reason" required class="block w-full border-rose-300 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm bg-white text-slate-700">
                                <option value="" disabled selected>-- Pilih Alasan --</option>
                                <option value="Rusak Total">Rusak Total / Mati Total</option>
                                <option value="Hilang">Hilang</option>
                                <option value="Dijual">Dijual / Lelang</option>
                                <option value="Hibah">Dihibahkan</option>
                                <option value="Kadaluarsa">Kadaluarsa / Usang (Obsolete)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl shadow-lg bg-rose-600 px-4 py-2.5 text-base font-bold text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:w-auto sm:text-sm transition transform hover:-translate-y-0.5">
                            Ya, Hapus Aset
                        </button>
                        <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, name, code) {
            // Sesuaikan URL ini dengan route resource tools Anda
            document.getElementById('deleteForm').action = "/tools/" + id; 
            document.getElementById('delToolName').innerText = name;
            document.getElementById('delToolCode').innerText = code;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>