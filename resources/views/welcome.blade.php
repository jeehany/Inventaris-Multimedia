<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris Multimedia - HM Company</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

    <!-- Navbar Minimalis -->
    <nav class="w-full py-6 px-6 lg:px-12 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <x-application-logo class="w-10 h-10 text-indigo-600 fill-current" />
            <span class="font-bold text-xl tracking-tight text-slate-900">HM Inventory</span>
        </div>
        @if (Route::has('login'))
            <div class="hidden sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Log in</a>
                @endauth
            </div>
        @endif
    </nav>

    <!-- Main Content Centered -->
    <main class="flex-grow flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto pb-20">
        
        <!-- Hero Title -->
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
            Kelola Aset Multimedia <br class="hidden sm:block" />
            <span class="text-indigo-600">Lebih Efisien & Terdata.</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-lg text-slate-600 max-w-2xl mb-10 leading-relaxed">
            Platform terintegrasi untuk pencatatan, peminjaman, dan pemeliharaan inventaris aset multimedia HM Company. Simpel, cepat, dan akurat.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg transition-all shadow-lg shadow-indigo-500/20">
                        Buka Dashboard
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg transition-all shadow-lg shadow-indigo-500/20">
                        Masuk Sekarang
                    </a>
                @endauth
            @endif
        </div>

    </main>

    <!-- Simple Footer -->
    <footer class="w-full py-6 text-center text-slate-400 text-sm bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <p>&copy; {{ date('Y') }} HM Company Multimedia. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
