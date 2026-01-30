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
            <?php echo e(__('Kategori Aset')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            
            <?php if(session('success')): ?>
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">
                    
                    
                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Kategori</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola jenis dan grouping aset multimedia.</p>
                    </div>

                    
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        <form action="<?php echo e(route('categories.index')); ?>" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Kategori / Kode..."
                                    onblur="this.form.submit()">
                            </div>
                            
                            <?php if(request('search')): ?>
                                <a href="<?php echo e(route('categories.index')); ?>" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            <?php endif; ?>
                        </form>
                        
                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(!auth()->user()->isHead()): ?>
                                <button onclick="toggleModal('modal-create')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md text-sm transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Kategori
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-24">Prefix</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Kategori</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-center text-sm text-slate-500 font-medium">
                                            <?php echo e($categories->firstItem() + $index); ?>

                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 font-mono">
                                                <?php echo e($cat->code ?? '-'); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-slate-800"><?php echo e($cat->category_name); ?></span>
                                            <?php if($cat->description): ?>
                                                <p class="text-xs text-slate-500 mt-0.5"><?php echo e(Str::limit($cat->description, 50)); ?></p>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if(auth()->guard()->check()): ?>
                                                <?php if(!auth()->user()->isHead()): ?>
                                                    <div class="flex justify-center items-center space-x-2">
                                                        
                                                        <button onclick="toggleModal('modal-edit-<?php echo e($cat->id); ?>')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        
                                                        
                                                        <button onclick="openDeleteModal('<?php echo e(route('categories.destroy', $cat->id)); ?>', 'Hapus Kategori <?php echo e($cat->category_name); ?>?', 'Apakah Anda yakin ingin menghapus kategori ini? Aset yang terkait mungkin akan kehilangan referensi kategori.')" class="text-rose-600 hover:text-rose-900 bg-rose-50 p-2 rounded-lg hover:bg-rose-100 transition" title="Hapus">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </div>

                                                    
                                                    <?php echo $__env->make('categories.modal_edit', ['category' => $cat], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <?php else: ?>
                                                    <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">View Only</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-12 text-slate-400">
                                            <p class="text-base font-medium">Data kategori belum tersedia.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="mt-8">
                        <?php echo e($categories->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="modal-create" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="toggleModal('modal-create')"></div>
            <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full">
                <form action="<?php echo e(route('categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="bg-white px-6 pt-6 pb-6">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-lg font-bold text-slate-900">Tambah Kategori Baru</h3>
                            <button type="button" onclick="toggleModal('modal-create')" class="text-slate-400 hover:text-slate-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kategori</label>
                                <input type="text" name="category_name" required 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400" 
                                    placeholder="Contoh: Kamera & Lensa">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Prefix (Opsional)</label>
                                <input type="text" name="code" maxlength="10" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 uppercase font-mono" 
                                    placeholder="Contoh: CAM">
                                <p class="text-xs text-slate-500 mt-1">Digunakan untuk generate kode aset otomatis.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                                <textarea name="description" rows="2" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400"
                                    placeholder="Keterangan tambahan..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition">Simpan</button>
                        <button type="button" onclick="toggleModal('modal-create')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-semibold shadow-sm transition">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }
    </script>
    <?php if (isset($component)) { $__componentOriginal47243a3de3ed132c2f9157dc8e8a8bd7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal47243a3de3ed132c2f9157dc8e8a8bd7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal-delete','data' => ['id' => 'deleteModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'deleteModal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal47243a3de3ed132c2f9157dc8e8a8bd7)): ?>
<?php $attributes = $__attributesOriginal47243a3de3ed132c2f9157dc8e8a8bd7; ?>
<?php unset($__attributesOriginal47243a3de3ed132c2f9157dc8e8a8bd7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal47243a3de3ed132c2f9157dc8e8a8bd7)): ?>
<?php $component = $__componentOriginal47243a3de3ed132c2f9157dc8e8a8bd7; ?>
<?php unset($__componentOriginal47243a3de3ed132c2f9157dc8e8a8bd7); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/categories/index.blade.php ENDPATH**/ ?>