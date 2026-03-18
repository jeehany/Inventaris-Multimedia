<!-- Sidebar Backdrop for Mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-slate-900 bg-opacity-50 transition-opacity lg:hidden" style="display: none;"></div>

<!-- Sidebar Layout -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-auto flex flex-col h-full shadow-2xl">
    
    <!-- Logo -->
    <div class="flex items-center justify-center mt-8 mb-4">
        <div class="flex items-center gap-3">
            <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-lg">
                {{-- <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo"> --}}
                <svg class="w-7 h-7 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m-8 7V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black text-white tracking-tight leading-none">InvenSys</span>
                <span class="text-[10px] uppercase tracking-widest text-indigo-400 font-bold">Multimedia</span>
            </div>
        </div>
    </div>
    
    <!-- User Role Badge -->
    <div class="px-6 mb-6">
        <div class="bg-slate-800/80 border border-slate-700/50 rounded-xl p-3 flex flex-col items-center justify-center text-center shadow-inner">
            <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Akses Saat Ini:</p>
            <p class="text-xs font-black text-emerald-400 uppercase tracking-widest">{{ Auth::user()->role }}</p>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="px-4 space-y-1 pb-10 flex-1">

        <!-- 1. Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="font-bold text-sm">Dashboard</span>
        </a>

        <!-- 2. Master Data -->
        @if(in_array(Auth::user()->role, ['admin', 'staff', 'kepala', 'head']))
        <div x-data="{ open: {{ request()->routeIs('categories.*', 'tools.*', 'vendors.*', 'users.*', 'borrowers.*') ? 'true' : 'false' }} }" class="pt-2">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition">
                <span>Master Data</span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="open" style="display: none;" class="space-y-1 mt-1 bg-slate-800/20 py-2 rounded-lg mx-2">
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    <span class="font-medium text-[13px]">Kategori Aset</span>
                </a>
                <a href="{{ route('tools.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tools.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('tools.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    <span class="font-medium text-[13px]">Data Aset Utama</span>
                </a>
                <a href="{{ route('vendors.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('vendors.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('vendors.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    <span class="font-medium text-[13px]">Data Vendor</span>
                </a>
                
                {{-- KHUSUS KEPALA --}}
                @if(Auth::user()->role == 'head' || Auth::user()->role == 'kepala')
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span class="font-medium text-[13px]">Akun Sistem Inti</span>
                </a>
                @endif
                
                <a href="{{ route('borrowers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('borrowers.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('borrowers.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="font-medium text-[13px]">Anggota Peminjam</span>
                </a>
            </div>
        </div>
        @endif

        <!-- 3. Transaksi -->
        @if(in_array(Auth::user()->role, ['admin', 'staff', 'kepala', 'head']))
        <div x-data="{ open: {{ request()->routeIs('purchases.*', 'borrowings.*', 'maintenances.*') ? 'true' : 'false' }} }" class="pt-2">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition">
                <span>Operasional Transaksi</span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="open" style="display: none;" class="space-y-1 mt-1 bg-slate-800/20 py-2 rounded-lg mx-2">
                <a href="{{ route('purchases.request') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('purchases.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('purchases.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="font-medium text-[13px]">Pengajuan Pengadaan</span>
                </a>
                <a href="{{ route('borrowings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('borrowings.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('borrowings.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    <span class="font-medium text-[13px]">Sirkulasi Peminjaman</span>
                </a>
                <a href="{{ route('maintenances.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('maintenances.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('maintenances.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span class="font-medium text-[13px]">Pemeliharaan Aset</span>
                </a>
            </div>
        </div>
        @endif

        <!-- 4. Monitoring & Report -->
        <div x-data="{ open: {{ request()->routeIs('monitoring.*', 'reports.*') ? 'true' : 'false' }} }" class="pt-2 pb-6">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition">
                <span>Tracking & Laporan</span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="open" style="display: none;" class="space-y-1 mt-1 bg-slate-800/20 py-2 rounded-lg mx-2">
                <a href="{{ route('monitoring.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('monitoring.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('monitoring.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                    <span class="font-medium text-[13px]">Monitoring Real-Time</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/50' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="h-4 w-4 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span class="font-medium text-[13px]">Pusat Analitik Laporan</span>
                </a>
            </div>
        </div>
    </nav>
</aside>