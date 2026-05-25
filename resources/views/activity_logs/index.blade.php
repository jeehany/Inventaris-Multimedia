<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Audit Trail - Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER CARD --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Log Aktivitas Sistem</h3>
                        <p class="text-sm text-slate-500 mt-1">Riwayat lengkap aktivitas pengguna untuk audit internal dan keamanan aset.</p>
                    </div>

                    {{-- FILTER TOOLBAR --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        <form id="filterForm" action="{{ route('activity-logs.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Search --}}
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari User / Log..."
                                    onblur="this.form.submit()">
                            </div>

                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Dropdown Action Type --}}
                            <div class="w-full md:w-auto relative group">
                                <select name="action_type" onchange="this.form.submit()" class="w-full md:w-48 pl-3 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="all">- Semua Jenis Aksi -</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action_type') == $action ? 'selected' : '' }}>
                                            {{ $action }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Reset --}}
                            @if(request('search') || (request('action_type') && request('action_type') !== 'all'))
                                <a href="{{ route('activity-logs.index') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>

                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Pengguna (User)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Keterangan Aktivitas</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">IP Address</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Waktu Kejadian</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($logs as $index => $log)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        {{-- NO --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                                            {{ $logs->firstItem() + $index }}
                                        </td>

                                        {{-- USER --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold border border-slate-200 text-xs">
                                                    {{ $log->user ? substr($log->user->name, 0, 1) : 'S' }}
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-bold text-slate-800">{{ $log->user ? $log->user->name : 'System' }}</div>
                                                    <div class="text-xs text-slate-400 capitalize">{{ $log->user ? $log->user->role : 'Automated' }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- ACTION BADGE --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $actionClass = 'bg-slate-100 text-slate-800 border-slate-200';
                                                $actionLower = strtolower($log->action);
                                                if (str_contains($actionLower, 'create') || str_contains($actionLower, 'tambah')) {
                                                    $actionClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                                } elseif (str_contains($actionLower, 'edit') || str_contains($actionLower, 'update')) {
                                                    $actionClass = 'bg-amber-100 text-amber-800 border-amber-200';
                                                } elseif (str_contains($actionLower, 'delete') || str_contains($actionLower, 'hapus')) {
                                                    $actionClass = 'bg-rose-100 text-rose-800 border-rose-200';
                                                } elseif (str_contains($actionLower, 'verify') || str_contains($actionLower, 'verifikasi')) {
                                                    $actionClass = 'bg-blue-100 text-blue-800 border-blue-200';
                                                } elseif (str_contains($actionLower, 'approve') || str_contains($actionLower, 'setuju')) {
                                                    $actionClass = 'bg-teal-100 text-teal-800 border-teal-200';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $actionClass }}">
                                                {{ $log->action }}
                                            </span>
                                        </td>

                                        {{-- DESCRIPTION --}}
                                        <td class="px-6 py-4 text-sm text-slate-700 font-medium">
                                            {!! e($log->description) !!}
                                        </td>

                                        {{-- IP ADDRESS --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-mono text-slate-500">
                                            {{ $log->ip_address ?? '-' }}
                                        </td>

                                        {{-- TIME --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                <p class="text-base font-medium">Belum ada log aktivitas tercatat.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-8">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
