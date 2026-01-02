<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HM Inventory') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">

    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 p-6">
        
        {{-- Logo Area --}}
        <div class="mb-8 text-center">
            <a href="/" class="flex flex-col items-center gap-2">
                <div class="p-3 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-600/20">
                    <x-application-logo class="w-10 h-10 fill-current text-white" />
                </div>
                <span class="text-2xl font-bold text-slate-800 tracking-tight">HM Inventory</span>
            </a>
        </div>

        {{-- Login Card --}}
        <div class="w-full sm:max-w-md bg-white px-8 py-10 shadow-xl shadow-slate-200/50 sm:rounded-2xl border border-slate-100">
            
            <div class="mb-8 text-center">
                <h2 class="text-xl font-bold text-slate-800">Selamat Datang Kembali</h2>
                <p class="text-slate-500 text-sm mt-1">Masuk untuk mengelola inventaris.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all font-medium text-slate-800 placeholder-slate-400" 
                        placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all font-medium text-slate-800 placeholder-slate-400" 
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-slate-600 group-hover:text-indigo-600 transition-colors">{{ __('Ingat Saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        {{ __('Masuk') }}
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'HM Inventory') }}.
            </p>
        </div>

    </div>
</body>
</html>
