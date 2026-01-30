<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Data Vendor') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Eror!
                    </p>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">
                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Mitra / Vendor</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola data vendor penyedia aset multimedia.</p>
                    </div>

                    {{-- TOOLBAR: PENCARIAN & TOMBOL --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">


                    {{-- FORM PENCARIAN (MODERN TOOLBAR) --}}
                        <form action="{{ route('vendors.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            <div class="relative w-full md:w-96 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari Nama, Email, HP, atau Alamat..." 
                                       class="pl-10 border-none bg-transparent rounded-lg w-full text-sm py-2 placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                       onblur="this.form.submit()">
                            </div>
                            
                            @if(request('search'))
                                <a href="{{ route('vendors.index') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>
                        
                        {{-- TOMBOL TAMBAH --}}
                        @auth
                            @if(!auth()->user()->isHead())
                                <a href="{{ route('vendors.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Tambah Vendor
                                </a>
                            @endif
                        @endauth
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Vendor</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kontak (HP/Email)</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Alamat</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($vendors as $vendor)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800">{{ $vendor->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                        <div class="flex items-center gap-2 mb-1">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $vendor->phone }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <span class="text-indigo-600 truncate max-w-[150px]">{{ $vendor->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                        <div class="truncate max-w-xs" title="{{ $vendor->address }}">
                                            {{ $vendor->address ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @auth
                                            @if(!auth()->user()->isHead())
                                                <div class="flex justify-center items-center gap-3">
                                                    <a href="{{ route('vendors.edit', $vendor->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg hover:bg-indigo-100 transition" title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    
                                                    <button type="button" onclick="openDeleteModal('{{ route('vendors.destroy', $vendor->id) }}', 'Hapus Vendor {{ $vendor->name }}?', 'Yakin ingin menghapus vendor <strong>{{ $vendor->name }}</strong>? Data aset yang terkait akan kehilangan referensi vendor.')" class="text-rose-600 hover:text-rose-900 bg-rose-50 p-2 rounded-lg hover:bg-rose-100 transition" title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">
                                                    View Only
                                                </span>
                                            @endif
                                        @endauth
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <p class="text-base font-medium">Tidak ada data vendor ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION LINKS --}}
                    <div class="mt-8">
                        {{ $vendors->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <x-modal-delete id="deleteModal" />
</x-app-layout>