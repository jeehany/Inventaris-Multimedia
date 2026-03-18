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
            <?php echo e(__('Pengajuan Pengadaan')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <?php if(session('success')): ?>
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Gagal!
                    </p>
                    <p class="text-sm mt-1"><?php echo e(session('error')); ?></p>
                </div>
            <?php endif; ?>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($pendingRequests); ?></p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Ditolak</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($rejectedRequests); ?></p>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-full text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Pengajuan</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola status dan persetujuan pengadaan aset baru.</p>
                    </div>

                    
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        
                        <form id="filterForm" action="<?php echo e(route('purchases.request')); ?>" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Kode / Aset..."
                                    onblur="this.form.submit()">
                            </div>

                            
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            
                            <div class="w-full md:w-auto relative group">
                                <!-- Icon Filter (Optional Add-on for visual cue) -->
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                </div>

                                <select name="status" onchange="this.form.submit()" class="w-full md:w-48 pl-8 pr-10 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="all" class="font-bold">- Semua Status -</option>
                                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                                    <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Selesai</option> 
                                    <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            
                            <?php if(request('search') || (request('status') && request('status') !== 'all')): ?>
                                <a href="<?php echo e(route('purchases.request')); ?>" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            <?php endif; ?>
                        </form>



                        <?php if(auth()->guard()->check()): ?>
                            
                            <?php if(in_array(auth()->user()->role, ['kepala', 'head'])): ?>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="w-full md:w-auto inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-emerald-500/30 transition duration-150 ease-in-out text-sm gap-2 whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Export Laporan
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 border border-slate-100" style="display: none;">
                                        <a href="<?php echo e(route('purchases.request.exportPdf', request()->query())); ?>" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                            📄 Data Pengajuan (PDF)
                                        </a>
                                        <a href="<?php echo e(route('purchases.request.export', request()->query())); ?>" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-green-600">
                                            📗 Data Pengajuan (Excel)
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if(!in_array(auth()->user()->role, ['kepala', 'head'])): ?>
                                <a href="<?php echo e(route('purchases.create')); ?>" class="w-full md:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Ajukan Pengadaan
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode & Tanggal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Detail Aset</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Total (Rp)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                                            <?php echo e($purchases->firstItem() + $index); ?>

                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-slate-800"><?php echo e($purchase->purchase_code); ?></div>
                                            <div class="text-xs text-slate-500 mt-0.5">
                                                <?php echo e(\Carbon\Carbon::parse($purchase->date)->format('d M Y')); ?>

                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <?php if($purchase->items && $purchase->items->count() > 0): ?>
                                                <div class="font-bold text-indigo-700">
                                                    <?php echo e($purchase->items->first()->tool_name); ?>

                                                    <?php if($purchase->items->count() > 1): ?>
                                                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded ml-1">
                                                            +<?php echo e($purchase->items->count() - 1); ?> item lainnya
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="font-bold text-slate-500 italic">Multi-Item</div>
                                            <?php endif; ?>
                                            <div class="text-xs text-slate-500 mt-1 flex flex-col gap-0.5">
                                                <span><span class="font-medium text-slate-700">Vendor:</span> <?php echo e($purchase->vendor ? $purchase->vendor->name : '-'); ?></span>
                                                <span><span class="font-medium text-slate-700">Total Item:</span> <?php echo e($purchase->items ? $purchase->items->sum('quantity') : 0); ?> unit</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-slate-700">
                                            Rp <?php echo e(number_format($purchase->total_amount, 0, ',', '.')); ?>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <?php if($purchase->status == 'pending_head' || $purchase->status == 'pending'): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Menunggu Kepala
                                                </span>
                                            <?php elseif($purchase->status == 'approved_head'): ?>
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Disetujui Kep.
                                                    </span>
                                                    <span class="text-[10px] text-slate-500 italic block">Menunggu Bendahara</span>
                                                </div>
                                            <?php elseif($purchase->status == 'completed'): ?> 
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Selesai
                                                </span>
                                            <?php elseif(str_contains($purchase->status, 'rejected')): ?>
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Ditolak
                                                    </span>
                                                    <?php if($purchase->rejection_note): ?>
                                                        <div class="group relative">
                                                            <span class="text-[10px] text-rose-500 border-b border-dotted border-rose-400 cursor-help">Lihat Alasan</span>
                                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 p-2 bg-slate-800 text-white text-xs rounded shadow-lg w-48 text-center hidden group-hover:block z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                                                <?php echo e($purchase->rejection_note); ?>

                                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-slate-800"></div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">

                                                
                                                <button onclick="openDetailModal(<?php echo e($purchase); ?>)" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                                
                                                <?php if(auth()->user()->role == 'kepala' && str_starts_with($purchase->status, 'pending')): ?>
                                                    
                                                    <form action="<?php echo e(route('purchases.approve', $purchase->id)); ?>" method="POST" class="inline">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition" title="Setujui Pengajuan" onclick="return confirm('Setujui pengajuan ini dan teruskan ke Bendahara?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                        </button>
                                                    </form>
                                                    
                                                    <button type="button" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition inline" title="Tolak Pengajuan" onclick="rejectPurchase(<?php echo e($purchase->id); ?>, 'Alasan Penolakan Kepala:')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                    <form id="reject-form-<?php echo e($purchase->id); ?>" action="<?php echo e(route('purchases.reject', $purchase->id)); ?>" method="POST" class="hidden">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="note" id="note-<?php echo e($purchase->id); ?>">
                                                    </form>
                                                    
                                                <?php elseif(auth()->user()->role == 'bendahara' && $purchase->status == 'approved_head'): ?>
                                                    
                                                    <button onclick="openEvidenceModal(<?php echo e($purchase->id); ?>, <?php echo e($purchase->total_amount); ?>)" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" title="Proses Pencairan & Bukti Belanja">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </button>
                                                    
                                                    <button type="button" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition inline" title="Tolak Pencairan" onclick="rejectPurchase(<?php echo e($purchase->id); ?>, 'Alasan Penolakan (Misal: Tidak Ada Anggaran):')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                    <form id="reject-form-<?php echo e($purchase->id); ?>" action="<?php echo e(route('purchases.reject', $purchase->id)); ?>" method="POST" class="hidden">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="note" id="note-<?php echo e($purchase->id); ?>">
                                                    </form>

                                                <?php elseif(auth()->user()->role == 'staff' && str_starts_with($purchase->status, 'pending')): ?>
                                                    <button type="button" onclick="openDeleteModal('<?php echo e(route('purchases.destroy', $purchase->id)); ?>', 'Batalkan Pengajuan?', 'Yakin ingin membatalkan pengajuan ini? Data akan dihapus permanen.')" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Batalkan Pengajuan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-base font-medium">Belum ada pengajuan pengadaan.</p>
                                                <p class="text-xs mt-1">Silakan ajukan pengadaan aset baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        <?php echo e($purchases->withQueryString()->links()); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity blur-sm" aria-hidden="true" onclick="closeDetailModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                
                
                <div class="bg-slate-800 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white flex items-center gap-2" id="modal-title">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Detail Pengajuan
                    </h3>
                    <button type="button" onclick="closeDetailModal()" class="text-slate-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div id="modalContent" class="space-y-4">
                        
                    </div>
                </div>

                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button type="button" onclick="closeDetailModal()" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function rejectPurchase(id) {
            let reason = prompt("Masukkan alasan penolakan:");
            if (reason !== null && reason.trim() !== "") {
                document.getElementById('note-' + id).value = reason;
                document.getElementById('reject-form-' + id).submit();
            }
        }

        function openDetailModal(data) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('modalContent');
            
            // Format Rupiah
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });
            
            // Translate Status Multi-level
            let statusBadge = '';
            if(data.status === 'pending_head' || data.status === 'pending') statusBadge = '<span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold border border-amber-200">Menunggu Kepala</span>';
            else if(data.status === 'approved_head') statusBadge = '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold border border-blue-200">Disetujui Kep. (Tunggu Bendahara)</span>';
            else if(data.status === 'rejected_head') statusBadge = '<span class="px-2 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-bold border border-rose-200">Ditolak Kepala</span>';
            else if(data.status === 'rejected_bendahara') statusBadge = '<span class="px-2 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-bold border border-rose-200">Ditolak Bendahara</span>';
            else if(data.status === 'completed') statusBadge = '<span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold border border-emerald-200">Anggaran Cair / Dibeli</span>';

            // Tanggal
            const date = new Date(data.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            // Generate HTML for Items
            let itemsHtml = '';
            if (data.items && data.items.length > 0) {
                itemsHtml = `
                    <div class="col-span-2 mt-4">
                        <table class="w-full text-sm text-left border border-slate-200 rounded">
                            <thead class="bg-slate-50 text-slate-600 text-xs uppercase border-b border-slate-200">
                                <tr>
                                    <th class="px-3 py-2">Nm Aset & Kategori</th>
                                    <th class="px-3 py-2">Qty</th>
                                    <th class="px-3 py-2 text-right">Hrg. Satuan</th>
                                    <th class="px-3 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                `;
                data.items.forEach(item => {
                    itemsHtml += `
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-2">
                                <span class="font-bold text-indigo-700 block">${item.tool_name}</span>
                                <span class="text-[10px] text-slate-500 block">${item.category ? item.category.category_name : '-'}</span>
                                <span class="text-[10px] text-slate-400 block">${item.specification || ''}</span>
                            </td>
                            <td class="px-3 py-2">${item.quantity}</td>
                            <td class="px-3 py-2 text-right">${formatter.format(item.unit_price)}</td>
                            <td class="px-3 py-2 text-right font-medium">${formatter.format(item.subtotal)}</td>
                        </tr>
                    `;
                });
                itemsHtml += `
                            </tbody>
                        </table>
                    </div>
                `;
            }

            // HTML Structure (Grid 2 Kolom)
            content.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2 border-b border-slate-100 pb-2 mb-2">
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Info Transaksi (Total: ${formatter.format(data.total_amount)})</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500">Kode Pengajuan</p>
                        <p class="font-bold text-slate-800">${data.purchase_code}</p>
                    </div>
                     <div>
                        <p class="text-xs text-slate-500">Tanggal</p>
                        <p class="font-bold text-slate-800">${date}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Pemohon (User)</p>
                        <p class="font-bold text-slate-800">${data.user ? data.user.name : '-'}</p>
                    </div>
                     <div>
                        <p class="text-xs text-slate-500">Status</p>
                        <div class="mt-1">${statusBadge}</div>
                    </div>

                    ${itemsHtml}

                    <div class="col-span-2 bg-indigo-50 p-3 rounded-lg border border-indigo-100 mt-2">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-bold text-indigo-900">Grand Total RAB</p>
                            <p class="text-lg font-bold text-indigo-700">${formatter.format(data.total_amount)}</p>
                        </div>
                    </div>

                    ${(data.status.includes('rejected')) && data.rejection_note ? `
                        <div class="col-span-2 bg-rose-50 p-3 rounded-lg border border-rose-100 mt-2">
                            <p class="text-xs font-bold text-rose-800 uppercase mb-1">Alasan Penolakan</p>
                            <p class="text-sm text-rose-700 italic">"${data.rejection_note}"</p>
                        </div>
                    ` : ''}
                </div>
            `;

            modal.classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
        function openEvidenceModal(id, currentTotal) {
            document.getElementById('evidenceModal').classList.remove('hidden');
            document.getElementById('evidenceForm').action = `/purchases/${id}/evidence`;
            if (currentTotal) {
                document.getElementById('realPriceInput').value = currentTotal;
            }
        }

        function closeEvidenceModal() {
            document.getElementById('evidenceModal').classList.add('hidden');
        }
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

    <!-- MODAL PENCAIRAN BENDAHARA -->
    <div id="evidenceModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEvidenceModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">
                                Proses Pencairan & Bukti Belanja
                            </h3>
                            <div class="mt-4">
                                <form id="evidenceForm" method="POST" action="" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Dana Dicairkan/Realisasi (Rp) <span class="text-rose-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-slate-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="number" name="real_price" id="realPriceInput" class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md" required>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-1">Masukkan total uang yang direalisasikan.</p>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Merek Barang (Jika ada) <span class="text-rose-500">*</span></label>
                                        <input type="text" name="brand" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md p-2" placeholder="Contoh: Sony / Canon / Multimerek" required value="Multimerek">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Upload Bukti Nota/Struk <span class="text-rose-500">*</span></label>
                                        <input type="file" name="proof_photo" accept="image/*" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md py-1" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-200">
                    <button type="submit" form="evidenceForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Selesai & Simpan
                    </button>
                    <button type="button" onclick="closeEvidenceModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/purchases/requests.blade.php ENDPATH**/ ?>