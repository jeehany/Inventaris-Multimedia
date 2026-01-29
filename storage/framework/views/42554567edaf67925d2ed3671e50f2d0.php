<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            <?php echo e(__('Daftar Aset')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <?php if(session('success')): ?>
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg" role="alert">
                    <div class="flex items-center gap-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </div>
                    <p class="text-sm mt-1"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>

            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Aset</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($totalTools); ?></p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>

                 
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Tersedia</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($availableTools); ?></p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Dipinjam</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($borrowedTools); ?></p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Maintenance</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($maintenanceTools); ?></p>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-full text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Aset</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola inventaris, cek status ketersediaan, dan kategori aset.</p>
                    </div>

                    
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        
                        <form id="filterForm" action="<?php echo e(route('tools.index')); ?>" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Nama / Kode..."
                                    onblur="this.form.submit()">
                            </div>

                            
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            
                            <div class="w-full md:w-auto relative group">
                                <select name="status" onchange="this.form.submit()" class="w-full md:w-40 pl-3 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Semua Status -</option>
                                    <option value="available" <?php echo e(request('status') == 'available' ? 'selected' : ''); ?>>Tersedia</option>
                                    <option value="borrowed" <?php echo e(request('status') == 'borrowed' ? 'selected' : ''); ?>>Dipinjam</option>
                                    <option value="maintenance" <?php echo e(request('status') == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                                    <option value="missing" <?php echo e(request('status') == 'missing' ? 'selected' : ''); ?>>Hilang/Rusak</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <select name="category_id" onchange="this.form.submit()" class="w-full md:w-48 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="all">- Semua Kategori -</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>>
                                            <?php echo e($cat->category_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            
                            <?php if(request('search') || request('status') || request('category_id')): ?>
                                <a href="<?php echo e(route('tools.index')); ?>" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            <?php endif; ?>
                        </form>

                        
                        <div class="flex gap-2 w-full md:w-auto">


                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->isHead()): ?>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-5 rounded-lg shadow-lg hover:shadow-emerald-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Export Laporan
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 border border-slate-100" style="display: none;">
                                            <a href="<?php echo e(route('tools.exportPdf', request()->query())); ?>" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                                📄 Laporan Aset (PDF)
                                            </a>
                                            <a href="<?php echo e(route('tools.exportExcel', request()->query())); ?>" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-green-600">
                                                📗 Laporan Aset (Excel)
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <a href="<?php echo e(route('tools.create')); ?>" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Aset
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode Aset</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Aset</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Kondisi</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                <?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500">
                                            <?php echo e($tools->firstItem() + $index); ?>

                                        </td>
                                        
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100">
                                                <?php echo e($tool->tool_code); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-slate-800"><?php echo e($tool->tool_name); ?></span>
                                                <span class="text-xs text-slate-500"><?php echo e($tool->brand ?? 'Tanpa Merk'); ?></span>
                                            </div>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                                <?php echo e($tool->category->category_name ?? '-'); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($tool->current_condition == 'Baik' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200'); ?>">
                                                <?php echo e($tool->current_condition); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <?php if($tool->availability_status == 'available'): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Tersedia</span>
                                            <?php elseif($tool->availability_status == 'borrowed'): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Dipinjam</span>
                                            <?php elseif($tool->availability_status == 'maintenance'): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">Maintenance</span>
                                            <?php else: ?> 
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200"><?php echo e(ucfirst($tool->availability_status)); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                
                                                
                                                <button type="button" onclick="document.getElementById('modal-detail-<?php echo e($tool->id); ?>').classList.remove('hidden')" 
                                                    class="text-sky-600 hover:text-sky-900 bg-sky-50 p-2 rounded-lg hover:bg-sky-100 transition" title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <?php if(auth()->guard()->check()): ?>
                                                    <?php if(!auth()->user()->isHead()): ?>
                                                        
                                                        <a href="<?php echo e(route('tools.edit', $tool->id)); ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                        
                                                        
                                                        <button type="button" 
                                                                onclick="openDeleteModal('<?php echo e($tool->id); ?>', '<?php echo e($tool->tool_name); ?>', '<?php echo e($tool->tool_code); ?>')" 
                                                                class="text-rose-600 hover:text-rose-900 bg-rose-50 p-2 rounded-lg hover:bg-rose-100 transition" title="Hapus / Musnahkan">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>

                                            
                                            <div id="modal-detail-<?php echo e($tool->id); ?>" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                
                                                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modal-detail-<?php echo e($tool->id); ?>').classList.add('hidden')"></div>
                                                
                                                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                                                    <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-slate-200">
                                                        
                                                        
                                                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                                                            <h3 class="text-lg font-bold text-slate-800" id="modal-title">
                                                                Detail Aset
                                                            </h3>
                                                            <button onclick="document.getElementById('modal-detail-<?php echo e($tool->id); ?>').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </div>

                                                        
                                                        <div class="px-6 py-6">
                                                            <div class="flex items-center gap-4 mb-6">
                                                                <div class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl">
                                                                    <?php echo e(substr($tool->tool_name, 0, 1)); ?>

                                                                </div>
                                                                <div>
                                                                    <div class="text-2xl font-bold text-slate-800"><?php echo e($tool->tool_name); ?></div>
                                                                    <div class="text-sm text-slate-500 font-mono"><?php echo e($tool->tool_code); ?></div>
                                                                </div>
                                                            </div>

                                                            <div class="space-y-4 text-sm">
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Merk / Tipe</span>
                                                                    <span class="col-span-2 text-slate-800 font-medium"><?php echo e($tool->brand ?? '-'); ?></span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Kategori</span>
                                                                    <span class="col-span-2 text-slate-800 font-medium"><?php echo e($tool->category->category_name ?? '-'); ?></span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Tahun Perolehan</span>
                                                                    <span class="col-span-2 text-slate-800 font-medium"><?php echo e($tool->purchase_date ? \Carbon\Carbon::parse($tool->purchase_date)->translatedFormat('d F Y') : '-'); ?></span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-3">
                                                                    <span class="font-semibold text-slate-500">Kondisi</span>
                                                                    <span class="col-span-2">
                                                                        <span class="px-2 py-1 rounded text-xs font-bold <?php echo e($tool->current_condition == 'Baik' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'); ?>">
                                                                            <?php echo e($tool->current_condition); ?>

                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="grid grid-cols-3 gap-4">
                                                                    <span class="font-semibold text-slate-500">Sumber</span>
                                                                    <span class="col-span-2 font-medium">
                                                                        <?php if($tool->purchase_item_id): ?>
                                                                            <span class="text-indigo-600 flex items-center gap-1">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                                                Pengadaan
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="text-slate-500">Input Manual / Hibah</span>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-slate-100">
                                                            <button type="button" onclick="document.getElementById('modal-detail-<?php echo e($tool->id); ?>').classList.add('hidden')" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:w-auto sm:text-sm transition">
                                                                Tutup
                                                            </button>
                                                            <?php if(auth()->user()->isAdmin()): ?>
                                                                <a href="<?php echo e(route('tools.edit', $tool->id)); ?>" class="mr-3 w-full inline-flex justify-center rounded-lg shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none sm:w-auto sm:text-sm transition">
                                                                    Edit Data
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                <p class="text-base font-medium">Belaum ada aset.</p>
                                                <p class="text-sm mt-1">Gunakan tombol Tambah Aset untuk memulai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="mt-8">
                        <?php echo e($tools->withQueryString()->links()); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
    
    
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full ring-1 ring-slate-200">
                <form id="deleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-100 rounded-full mb-4">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-center text-slate-800 mb-2">Hapus Aset?</h3>
                        <p class="text-sm text-center text-slate-500 mb-6">
                            Anda akan menghapus aset <strong id="delToolName" class="text-slate-800"></strong> (<span id="delToolCode" class="font-mono"></span>). <br>
                            Data akan dipindahkan ke <strong>Trash (Sampah)</strong>.
                        </p>

                        
                        <div class="bg-rose-50 p-4 rounded-xl border border-rose-100">
                            <label class="block text-sm font-bold text-rose-800 mb-2">Alasan Penghapusan:</label>
                            <select name="disposal_reason" required class="block w-full border-rose-300 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm bg-white text-slate-700">
                                <option value="" disabled selected>-- Pilih Alasan --</option>
                                <option value="Rusak Total">Rusak Total / Mati Total</option>
                                <option value="Hilang">Hilang</option>
                                <option value="Dijual">Dijual / Lelang</option>
                                <option value="Hibah">Dihibahkan</option>
                                <option value="Kadaluarsa">Kadaluarsa / Usang (Obsolete)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl shadow-lg bg-rose-600 px-4 py-2.5 text-base font-bold text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:w-auto sm:text-sm transition transform hover:-translate-y-0.5">
                            Ya, Hapus Aset
                        </button>
                        <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, name, code) {
            // Sesuaikan URL ini dengan route resource tools Anda
            document.getElementById('deleteForm').action = "/tools/" + id; 
            document.getElementById('delToolName').innerText = name;
            document.getElementById('delToolCode').innerText = code;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/tools/index.blade.php ENDPATH**/ ?>