<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

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
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                            <?php if(isset($header)): ?>
                                <div class="hidden sm:block">
                                    <?php echo e($header); ?>

                                </div>
                            <?php endif; ?>
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
                            <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                                 <?php $__env->slot('trigger', null, []); ?> 
                                    <button class="flex items-center gap-3 text-sm font-medium text-slate-600 hover:text-indigo-600 focus:outline-none transition-colors">
                                        <div class="h-9 w-9 bg-indigo-100 border border-indigo-200 text-indigo-700 flex items-center justify-center rounded-full font-bold shadow-sm">
                                            <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                                        </div>
                                        <div class="hidden md:flex flex-col text-left">
                                            <span class="font-bold text-slate-800 leading-tight"><?php echo e(Auth::user()->name); ?></span>
                                            <span class="text-[10px] text-slate-400 uppercase tracking-widest"><?php echo e(Auth::user()->role); ?></span>
                                        </div>
                                        <svg class="fill-current h-4 w-4 text-slate-400 hidden sm:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                 <?php $__env->endSlot(); ?>

                                 <?php $__env->slot('content', null, []); ?> 
                                    <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                                        <?php echo e(__('Pengaturan Akun')); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();','class' => 'text-rose-600 hover:text-rose-700 hover:bg-rose-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();','class' => 'text-rose-600 hover:text-rose-700 hover:bg-rose-50']); ?>
                                            <?php echo e(__('Log Out')); ?>

                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                                    </form>
                                 <?php $__env->endSlot(); ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
                        </div>
                    </div>
                </header>

                <!-- Page Content Body -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50">
                    <?php echo e($slot); ?>

                </main>
                
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/layouts/app.blade.php ENDPATH**/ ?>