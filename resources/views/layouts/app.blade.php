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
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
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

                        <!-- User Profile Dropdown -->
                        <div class="flex items-center gap-4">
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
    </body>
</html>
