<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 p-8 shadow-xl mb-8">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-emerald-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-2">
                            Selamat Datang, <span class="text-indigo-400">{{ Auth::user()->name }}</span>! 👋
                        </h3>
                        <p class="text-slate-300 max-w-xl">
                            @if(auth()->user()->isHead())
                                Berikut adalah ringkasan aktivitas peminjaman dan performa inventaris bulan ini.
                            @else
                                Panel operasional untuk mengelola aset, peminjaman, dan data pengguna secara efisien.
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/10">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></div>
                        <span class="text-sm font-medium text-white">{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @if(auth()->user()->isHead())
                    <!-- Head Stats -->
                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Peminjaman Bulan Ini</div>
                            <div class="text-3xl font-bold text-slate-800">{{ $data['monthly_borrowings'] }}</div>
                            <div class="text-xs text-indigo-500 font-medium mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                <span>Transaksi</span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Sedang Dipinjam</div>
                            <div class="text-3xl font-bold text-slate-800">{{ $data['active_borrowings'] }}</div>
                            <div class="text-xs text-amber-600 font-medium mt-2 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Aset diluar</span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Terlambat Kembali</div>
                            <div class="text-3xl font-bold text-red-600">{{ $data['overdue_items'] }}</div>
                            <div class="text-xs text-red-500 font-medium mt-2">Perlu ditindaklanjuti</div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl p-6 shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-1 transition-all duration-300 text-white relative overflow-hidden">
                        <div class="absolute right-0 bottom-0 opacity-10 transform scale-150 translate-x-4 translate-y-4">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="relative h-full flex flex-col justify-between">
                            <div>
                                <div class="text-indigo-200 text-sm font-medium uppercase tracking-wider mb-1">Laporan Lengkap</div>
                                <div class="text-2xl font-bold">Analisis Data</div>
                            </div>
                            <a href="#" class="inline-flex items-center gap-2 text-sm font-medium hover:text-indigo-200 transition-colors mt-4">
                                Buka Laporan <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Admin Stats -->
                     <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Total Aset</div>
                            <div class="text-3xl font-bold text-slate-800">{{ $data['total_tools'] }}</div>
                            <div class="text-xs text-indigo-500 font-medium mt-2">Item terdaftar</div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                         <div class="absolute right-0 top-0 w-24 h-24 bg-slate-100 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Total Pengguna</div>
                            <div class="text-3xl font-bold text-slate-800">{{ $data['total_users'] }}</div>
                            <div class="text-xs text-slate-500 font-medium mt-2">Anggota aktif</div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                         <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Sedang Dipinjam</div>
                            <div class="text-3xl font-bold text-slate-800">{{ $data['active_borrowings'] }}</div>
                             <div class="text-xs text-amber-600 font-medium mt-2 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Aset diluar</span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                         <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Kembali Hari Ini</div>
                            <div class="text-3xl font-bold text-emerald-600">{{ $data['returned_today'] }}</div>
                            <div class="text-xs text-emerald-500 font-medium mt-2">Transaksi selesai</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Activity Feed (Left 2/3) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                                <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>
                                Aktivitas Terbaru
                            </h4>
                            <a href="{{ route('borrowings.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:underline">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Peminjam</th>
                                        <th class="px-6 py-4 font-semibold">Barang</th>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($data['recent_activities'] as $activity)
                                        <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 text-white flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm">
                                                        {{ substr($activity->borrower->name, 0, 1) }}
                                                    </div>
                                                    <div class="font-medium text-slate-900">{{ $activity->borrower->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                @if($activity->items->count() > 0)
                                                    {{ $activity->items->first()->tool->name }}
                                                    @if($activity->items->count() > 1)
                                                        <span class="text-xs text-slate-400 ml-1">(+{{ $activity->items->count() - 1 }} lainnya)</span>
                                                    @endif
                                                @else
                                                    <span class="text-slate-400 italic">No Data</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ \Carbon\Carbon::parse($activity->borrow_date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($activity->borrowing_status == 'active')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                        Sedang Dipinjam
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                        Dikembalikan
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    <p>Belum ada aktivitas tercatat.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Sidebar (Right 1/3) -->
                <div class="space-y-6">
                    <!-- Quick Menu Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                        <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Menu Cepat
                        </h4>
                        <div class="space-y-3">
                            @if(auth()->user()->isHead())
                                <button class="w-full group flex items-center p-3 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-all duration-200 text-left">
                                    <div class="p-2 bg-white rounded-md shadow-sm text-indigo-600 mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700 text-sm">Cetak Laporan</div>
                                        <div class="text-xs text-slate-500">Unduh PDF/Excel</div>
                                    </div>
                                </button>
                            @else
                                <a href="{{ route('borrowings.create') }}" class="w-full group flex items-center p-3 rounded-lg bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition-all duration-200 text-left">
                                    <div class="p-2 bg-indigo-500 rounded-md shadow-md text-white mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-indigo-900 text-sm">Peminjaman Baru</div>
                                        <div class="text-xs text-indigo-600">Input transaksi cepat</div>
                                    </div>
                                </a>

                                <a href="{{ route('tools.index') }}" class="w-full group flex items-center p-3 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-all duration-200 text-left">
                                    <div class="p-2 bg-white rounded-md shadow-sm text-slate-600 mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700 text-sm">Data Aset</div>
                                        <div class="text-xs text-slate-500">Manajemen inventaris</div>
                                    </div>
                                </a>

                                <a href="{{ route('users.create') }}" class="w-full group flex items-center p-3 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-all duration-200 text-left">
                                    <div class="p-2 bg-white rounded-md shadow-sm text-slate-600 mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700 text-sm">Tambah Pengguna</div>
                                        <div class="text-xs text-slate-500">Registrasi member</div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- System Info / Widget -->
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h4 class="font-bold text-lg mb-2">Inventory System</h4>
                            <p class="text-slate-400 text-xs mb-4">Version 1.0.0 • Premium Build</p>
                            <div class="flex items-center gap-2 text-xs text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                System Operational
                            </div>
                        </div>
                         <!-- Decorative Circles -->
                        <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
                        <div class="absolute bottom-0 left-0 -ml-6 -mb-6 w-24 h-24 rounded-full bg-indigo-500/20 blur-xl"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>