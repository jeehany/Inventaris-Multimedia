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
            <?php echo e(__('Proses Maintenance')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            
            <form action="<?php echo e(route('maintenances.update', $maintenance->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    
                    <div class="bg-white p-6 shadow-xl sm:rounded-xl border border-slate-200 h-fit">
                        <h3 class="font-bold text-lg mb-4 border-b border-slate-100 pb-2 text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Informasi
                        </h3>

                        
                        <div class="mb-5 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                            <label class="block text-xs font-bold text-indigo-500 uppercase tracking-wider mb-1">Aset Multimedia</label>
                            <div class="text-xl font-bold text-slate-800"><?php echo e($maintenance->tool->tool_name); ?></div>
                            <div class="text-xs text-slate-500 font-mono mt-0.5">Kode: <?php echo e($maintenance->tool->tool_code); ?></div>
                        </div>

                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Masuk</label>
                            <input type="date" name="start_date" value="<?php echo e($maintenance->start_date); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Perbaikan</label>
                            <select name="maintenance_type_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" <?php echo e($maintenance->maintenance_type_id == $type->id ? 'selected' : ''); ?>>
                                        <?php echo e($type->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tindakan Perbaikan</label>
                            <textarea name="action_taken" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder-slate-400" placeholder="Apa yang dilakukan teknisi..."><?php echo e($maintenance->action_taken); ?></textarea>
                        </div>

                        
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Catatan Kerusakan</label>
                            <textarea name="note" rows="2" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder-slate-400"><?php echo e($maintenance->note); ?></textarea>
                        </div>

                        
                        <?php if($maintenance->status != 'completed'): ?>
                            <div class="mt-4 text-right border-t border-slate-100 pt-4">
                                
                                <button type="submit" name="action" value="update_info" class="text-sm bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 shadow-md font-semibold transition">
                                    Simpan Perubahan Info
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="bg-white p-6 shadow-xl sm:rounded-xl border-2 <?php echo e($maintenance->status == 'completed' ? 'border-emerald-400' : 'border-slate-100'); ?> h-fit">
                        <h3 class="font-bold text-lg mb-4 border-b border-slate-100 pb-2 text-slate-800 flex items-center gap-2">
                             <svg class="w-5 h-5 <?php echo e($maintenance->status == 'completed' ? 'text-emerald-600' : 'text-slate-500'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <?php echo e($maintenance->status == 'completed' ? 'Detail Penyelesaian' : 'Selesaikan Perbaikan'); ?>

                        </h3>

                        <?php if($maintenance->status != 'completed'): ?>
                            
                            
                            <div class="bg-amber-50 p-4 rounded-lg mb-6 text-xs text-amber-800 border border-amber-200 shadow-sm">
                                <p class="font-bold mb-1">Info Status</p>
                                <p>Klik tombol di bawah untuk <strong>Menutup status perbaikan</strong> sekaligus menyimpan seluruh data. Stok aset akan otomatis tersedia kembali.</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Biaya Perbaikan (Rp)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                      <span class="text-slate-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="cost" value="<?php echo e($maintenance->cost > 0 ? $maintenance->cost : 0); ?>" min="0" class="w-full pl-10 border-slate-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                            </div>

                            <div class="mt-8">
                                
                                <button type="submit" name="action" value="complete" class="w-full bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-emerald-700 shadow-lg transform transition hover:scale-[1.02]">
                                    ✅ Selesai & Stok Kembali
                                </button>
                            </div>

                        <?php else: ?>
                            
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 gap-5 text-sm">
                                    <div class="border-b border-slate-100 pb-2">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Selesai</label>
                                        <div class="text-slate-900 font-medium text-lg mt-1"><?php echo e(\Carbon\Carbon::parse($maintenance->end_date)->format('d F Y')); ?></div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Total Biaya</label>
                                        <div class="text-emerald-600 font-bold text-2xl mt-1">Rp <?php echo e(number_format($maintenance->cost, 0, ',', '.')); ?></div>
                                    </div>
                                </div>
                                
                                <div class="bg-emerald-50 p-4 rounded-lg text-center text-emerald-800 font-bold border border-emerald-200 mt-6 flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Status: SELESAI</span>
                                </div>
                                <div class="text-center mt-6">
                                    <a href="<?php echo e(route('maintenances.index')); ?>" class="text-slate-500 text-sm hover:text-indigo-600 font-medium transition">Kembali ke daftar</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/maintenances/edit.blade.php ENDPATH**/ ?>