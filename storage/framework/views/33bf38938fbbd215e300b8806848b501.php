<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris Multimedia - HM Company</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="antialiased bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

    <!-- Navbar Minimalis -->
    <nav class="w-full py-6 px-6 lg:px-12 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-10 h-10 text-indigo-600 fill-current']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-10 h-10 text-indigo-600 fill-current']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
            <span class="font-bold text-xl tracking-tight text-slate-900">HM Inventory</span>
        </div>
        <?php if(Route::has('login')): ?>
            <div class="hidden sm:block">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Log in</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
            Platform terintegrasi untuk pencatatan, peminjaman, dan perawatan inventaris peralatan HM Company. Simpel, cepat, dan akurat.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <?php if(Route::has('login')): ?>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg transition-all shadow-lg shadow-indigo-500/20">
                        Buka Dashboard
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg transition-all shadow-lg shadow-indigo-500/20">
                        Masuk Sekarang
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </main>

    <!-- Simple Footer -->
    <footer class="w-full py-6 text-center text-slate-400 text-sm bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <p>&copy; <?php echo e(date('Y')); ?> HM Company Multimedia. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/welcome.blade.php ENDPATH**/ ?>