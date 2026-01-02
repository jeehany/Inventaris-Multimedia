<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistem Inventaris Multimedia HM Company">
        <title>HM Company - Multimedia Inventory</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-900 font-sans text-slate-100 selection:bg-indigo-500 selection:text-white">
        
        <div class="relative min-h-screen flex flex-col justify-center overflow-hidden">
            
            <!-- Background Elements -->
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-10"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-900/80 to-indigo-900/80"></div>

            <!-- Content Container -->
            <div class="relative max-w-7xl mx-auto w-full px-6 lg:px-8">
                <main class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Column: Branding -->
                    <div class="flex flex-col justify-center text-center lg:text-left space-y-8">
                        <div>
                            <span class="inline-block py-1 px-3 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-sm font-semibold tracking-wide mb-4">
                                V2.0 PREMIUM SYSTEM
                            </span>
                            <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-white leading-[1.1]">
                                Inventaris <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">
                                    Multimedia
                                </span>
                            </h1>
                            <p class="mt-6 text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                                Kelola aset digital dan peralatan multimedia HM Company dengan platform yang terintegrasi, modern, dan efisien.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" 
                                       class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2 group">
                                        <span>Dashboard</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="px-8 py-4 bg-white text-slate-900 hover:bg-slate-50 font-bold rounded-xl transition-all shadow-lg flex items-center justify-center gap-2 ring-1 ring-slate-200">
                                        <span>Masuk Sistem</span>
                                    </a>
                                @endauth
                            @endif
                        </div>

                        <!-- Stats / Features -->
                        <div class="pt-8 grid grid-cols-2 sm:grid-cols-3 gap-6 border-t border-slate-700/50">
                            <div>
                                <div class="text-2xl font-bold text-white">100%</div>
                                <div class="text-sm text-slate-400">Digital Tracking</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">24/7</div>
                                <div class="text-sm text-slate-400">Akses Sistem</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">Realtime</div>
                                <div class="text-sm text-slate-400">Status Aset</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Visual/Illustration -->
                    <div class="hidden lg:flex justify-center relative">
                        <!-- Abstract Card Stack Effect -->
                        <div class="relative w-full max-w-md aspect-square">
                            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-3xl rotate-6 opacity-30 blur-2xl animate-pulse"></div>
                            <div class="absolute inset-0 bg-slate-800 rounded-2xl border border-slate-700 shadow-2xl p-6 flex flex-col gap-4 transform transition hover:-translate-y-2 duration-500">
                                <!-- Mock Interface -->
                                <div class="flex items-center justify-between border-b border-slate-700 pb-4">
                                    <div class="flex gap-2">
                                        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    </div>
                                    <div class="text-xs text-slate-500 font-mono">HM-SYSTEM-V2</div>
                                </div>
                                <div class="space-y-3">
                                    <div class="h-8 bg-slate-700/50 rounded w-1/3"></div>
                                    <div class="h-32 bg-slate-700/30 rounded w-full"></div>
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="h-20 bg-indigo-500/10 border border-indigo-500/20 rounded"></div>
                                        <div class="h-20 bg-slate-700/30 rounded"></div>
                                        <div class="h-20 bg-slate-700/30 rounded"></div>
                                    </div>
                                </div>
                                <div class="mt-auto flex justify-between items-center text-sm text-slate-400">
                                    <span>System Active</span>
                                    <span class="text-emerald-400 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        Online
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </main>

                <footer class="absolute bottom-6 w-full text-center text-slate-500 text-sm">
                    &copy; {{ date('Y') }} HM Company Multimedia. All rights reserved.
                </footer>
            </div>
        </div>
    </body>
</html>
