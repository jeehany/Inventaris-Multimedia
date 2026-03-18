<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Monitoring Status Aset Real-Time') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER PANELS STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Assets -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Total Keseluruhan</p>
                        <h4 class="text-2xl font-bold text-slate-800">{{ $stats['total_tools'] }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
                <!-- Available -->
                <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-emerald-600 mb-1">Di Gudang / Tersedia</p>
                        <h4 class="text-2xl font-bold text-emerald-700">{{ $stats['available'] }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <!-- Borrowed -->
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-blue-600 mb-1">Sedang Dipinjam</p>
                        <h4 class="text-2xl font-bold text-blue-700">{{ $stats['borrowed'] }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
                <!-- Maintenance -->
                <div class="bg-white rounded-xl shadow-sm border border-amber-100 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-amber-600 mb-1">Perbaikan Berlangsung</p>
                        <h4 class="text-2xl font-bold text-amber-700">{{ $stats['maintenance'] }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
                <!-- Disposed -->
                <div class="bg-white rounded-xl shadow-sm border border-rose-100 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-medium text-rose-600 mb-1">Dihapus / Hilang</p>
                        <h4 class="text-2xl font-bold text-rose-700">{{ $stats['disposed'] }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                </div>
            </div>

            <!-- TABEL REAL-TIME PELACAKAN ASET -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
                <!-- Header Filter -->
                <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">Direktori Pelacakan Aset</h3>
                        <p class="text-sm text-slate-500">Cek lokasi detail aset secara menyeluruh dan real-time.</p>
                    </div>
                    
                    <form method="GET" action="{{ route('monitoring.index') }}" class="w-full md:w-auto flex items-center gap-2 relative">
                        <select name="status" class="w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm appearance-none bg-white">
                            <option value="">-- Semua Status Aset --</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia / Gudang</option>
                            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan</option>
                            <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Dihapus / Hilang</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition">Filter</button>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-widest">
                                <th class="px-6 py-4 font-semibold w-24">Kode Aset</th>
                                <th class="px-6 py-4 font-semibold">Manufaktur / Barang</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                                <th class="px-6 py-4 font-semibold">Tanggung Jawab (PIC)</th>
                                <th class="px-6 py-4 font-semibold text-right">Lokasi Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tools as $tool)
                                <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded border border-slate-200">{{ $tool->tool_code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($tool->photo)
                                                <img src="{{ Storage::url($tool->photo) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $tool->tool_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $tool->category ? $tool->category->category_name : 'Tanpa Kategori' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $toolDetails[$tool->id]['status_badge'] }}">
                                            {{ $toolDetails[$tool->id]['status_label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-slate-700">
                                            {{ $toolDetails[$tool->id]['pic'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm text-slate-600">
                                            {{ $toolDetails[$tool->id]['location'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <span class="text-lg">Tidak ada aset ditemukan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if($tools->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $tools->links() }}
                    </div>
                @endif
            </div>

            <!-- JADWAL MAINTENANCE AKTIF -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-amber-50/30 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Monitoring Jadwal Servis / Maintenance
                        </h3>
                        <p class="text-sm text-slate-500">Menampilkan daftar perbaikan perangkat berstatus aktif.</p>
                    </div>
                </div>
                <div class="p-6">
                    @if($maintenances->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($maintenances as $maintenance)
                                <div class="border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                                    <div class="absolute right-0 top-0 w-16 h-16 bg-amber-50 rounded-bl-full -mr-2 -mt-2 transition-transform group-hover:scale-110"></div>
                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-3">
                                            <span class="px-2 py-1 bg-amber-100 text-amber-800 text-[10px] font-bold uppercase rounded">{{ $maintenance->status == 'in_progress' ? 'SEDANG DISERVIS' : 'PENDING' }}</span>
                                            <span class="text-xs text-slate-400 font-medium">Beban: Mulai {{ \Carbon\Carbon::parse($maintenance->start_date)->format('d M y') }}</span>
                                        </div>
                                        <h4 class="font-bold text-slate-800 mb-1">{{ $maintenance->tool ? $maintenance->tool->tool_name : 'Unknown Tool' }}</h4>
                                        <p class="text-sm text-slate-600 border-l-2 border-amber-300 pl-2 mb-4 bg-slate-50 py-1 italic shadow-sm">{{ $maintenance->type ? $maintenance->type->name : 'Perawatan Umum' }}</p>
                                        
                                        <div class="text-xs text-slate-500 flex flex-col gap-1">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                <strong>Teknisi:</strong> {{ $maintenance->user ? $maintenance->user->name : '-' }}
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <strong>Catatan:</strong> {{ Str::limit($maintenance->note, 40) }}
                                            </div>
                                        </div>
                                        
                                        <!-- Cost Estimasi (Apabila diisi) -->
                                        @if($maintenance->cost > 0)
                                            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center text-sm font-bold text-slate-700">
                                                <span>Estimasi Biaya:</span>
                                                <span class="text-rose-600">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h4 class="font-bold text-slate-700 text-lg">Peralatan Normal</h4>
                            <p class="text-slate-500 text-sm mt-1">Saat ini tidak ada laporan kerusakan atau perbaikan aset yang sedang berlangsung.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
