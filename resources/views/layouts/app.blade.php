<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Balsamic Wireframe Theme (Global Scope) */
            body.wireframe-mode {
                font-family: 'Comic Sans MS', 'Chalkboard SE', 'Comic Neue', cursive, sans-serif !important;
                background-color: #ffffff !important;
                color: #222222 !important;
            }

            .wireframe-mode * {
                font-family: inherit !important;
                color: #222222 !important; /* Force all text to black */
                box-shadow: none !important;
                background-image: none !important; /* Disable gradients */
                backdrop-filter: none !important;
                /* Simulate rough hand-drawn borders */
                border-radius: 255px 15px 225px 15px/15px 225px 15px 255px !important;
            }

            .wireframe-mode .bg-white,
            .wireframe-mode .bg-slate-50,
            .wireframe-mode .bg-slate-100,
            .wireframe-mode .bg-slate-200,
            .wireframe-mode .bg-slate-700,
            .wireframe-mode .bg-slate-800,
            .wireframe-mode .bg-slate-900,
            .wireframe-mode .bg-indigo-600,
            .wireframe-mode .bg-indigo-700,
            .wireframe-mode .bg-indigo-50,
            .wireframe-mode .bg-indigo-100,
            .wireframe-mode .bg-rose-50,
            .wireframe-mode .bg-rose-500,
            .wireframe-mode .bg-emerald-50,
            .wireframe-mode .bg-emerald-500,
            .wireframe-mode input,
            .wireframe-mode select,
            .wireframe-mode textarea,
            .wireframe-mode button,
            .wireframe-mode table,
            .wireframe-mode th,
            .wireframe-mode td {
                background-color: #ffffff !important;
                border: 2px solid #222222 !important;
            }

            /* Force borders to hand-drawn black */
            .wireframe-mode .border,
            .wireframe-mode .border-b,
            .wireframe-mode .border-t,
            .wireframe-mode .border-l,
            .wireframe-mode .border-r,
            .wireframe-mode .border-slate-100,
            .wireframe-mode .border-slate-200,
            .wireframe-mode .border-slate-300,
            .wireframe-mode .border-slate-700,
            .wireframe-mode .border-indigo-100,
            .wireframe-mode .border-indigo-200,
            .wireframe-mode .border-indigo-500,
            .wireframe-mode .border-transparent {
                border-color: #222222 !important;
            }

            /* SVGs behave like sketch lines */
            .wireframe-mode svg path {
                stroke: #222222 !important;
            }
            .wireframe-mode .fill-current {
                fill: #222222 !important;
            }

            /* Remove regular hover effects and replace with a rough shade */
            .wireframe-mode *:hover {
                transform: none !important;
                filter: none !important;
            }
            .wireframe-mode button:hover,
            .wireframe-mode a:hover {
                background-color: #f0f0f0 !important;
            }
            
            /* Sidebar active link in wireframe */
            .wireframe-mode a[href].bg-indigo-600 {
                background-color: #e5e5e5 !important;
                border-width: 3px !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50 transition-colors duration-300"
          x-data="{ sidebarOpen: false, wireframeMode: localStorage.getItem('wireframeMode') === 'true' }" 
          x-init="$watch('wireframeMode', val => localStorage.setItem('wireframeMode', val))"
          :class="{ 'wireframe-mode': wireframeMode }">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col overflow-hidden relative">
                
                <!-- Top Header (Mobile Toggle & Profile) -->
                <header class="bg-white border-b border-slate-100 shadow-sm z-10">
                    <div class="flex items-center justify-between px-4 sm:px-6 py-4">
                        <div class="flex items-center gap-4">
                            <!-- Mobile Menu Toggle Button -->
                            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-indigo-600 focus:outline-none lg:hidden transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                            </button>
                            
                            <!-- Page Title -->
                            @isset($header)
                                <div class="hidden sm:block">
                                    {{ $header }}
                                </div>
                            @endisset
                        </div>

                        <!-- Actions / Toggles & User Profile -->
                        <div class="flex items-center gap-4">
                            
                            <!-- Toggle Balsamiq Wireframe Button -->
                            <button @click="wireframeMode = !wireframeMode" class="text-slate-400 hover:text-indigo-600 focus:outline-none transition-colors hidden sm:block" title="Toggle Wireframe Mode">
                                <!-- Pencil Icon (Normal Mode) -->
                                <svg x-show="!wireframeMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                <!-- Photo Icon (Wireframe Mode Active) -->
                                <svg x-show="wireframeMode" style="display: none;" class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </button>
                            <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center gap-3 text-sm font-medium text-slate-600 hover:text-indigo-600 focus:outline-none transition-colors">
                                        <div class="h-9 w-9 bg-indigo-100 border border-indigo-200 text-indigo-700 flex items-center justify-center rounded-full font-bold shadow-sm">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div class="hidden md:flex flex-col text-left">
                                            <span class="font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                                            <span class="text-[10px] text-slate-400 uppercase tracking-widest">{{ Auth::user()->role }}</span>
                                        </div>
                                        <svg class="fill-current h-4 w-4 text-slate-400 hidden sm:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Pengaturan Akun') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-rose-600 hover:text-rose-700 hover:bg-rose-50">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <!-- Page Content Body -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50">
                    {{ $slot }}
                </main>
                
            </div>
        </div>
        {{-- SIMULATED WHATSAPP NOTIFICATION TOAST --}}
        @if (session('wa_notif'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-slate-900 text-white rounded-xl shadow-2xl border border-indigo-500 overflow-hidden transition-all duration-300 transform" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">
                <div class="p-4 flex items-start gap-3">
                    <div class="p-2 bg-emerald-500 text-white rounded-lg animate-bounce">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.733-1.458L0 24zm6.292-4.148c1.691.997 3.324 1.542 5.673 1.543 5.485 0 9.946-4.428 9.95-9.87.002-2.636-1.02-5.115-2.88-6.978-1.859-1.862-4.331-2.888-6.965-2.89-5.492 0-9.953 4.431-9.957 9.873-.002 1.986.518 3.926 1.508 5.626L2.61 21.31l3.739-1.458zm10.745-6.289c-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.668.149-.198.297-.766.967-.94 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 font-mono">Notifikasi WA Gateway</span>
                            <button @click="show = false" class="text-slate-400 hover:text-white transition text-lg">&times;</button>
                        </div>
                        <p class="text-xs text-slate-300 font-semibold">Tujuan: {{ session('wa_notif')['to'] }}</p>
                        <p class="text-xs text-white mt-1 font-medium italic">"{{ session('wa_notif')['message'] }}"</p>
                    </div>
                </div>
            </div>
        @endif
    </body>
</html>
