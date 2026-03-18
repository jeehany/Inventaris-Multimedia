
<div id="modal-edit-<?php echo e($tool->id); ?>" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-hidden="true" role="dialog">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="toggleModal('modal-edit-<?php echo e($tool->id); ?>')"></div>
        
        <!-- Modal Panel -->
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full">
            <form action="<?php echo e(route('tools.update', $tool->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Edit Data Aset: <?php echo e($tool->tool_name); ?></h3>
                        <button type="button" onclick="toggleModal('modal-edit-<?php echo e($tool->id); ?>')" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kode Aset (Readonly) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Aset</label>
                            <input type="text" value="<?php echo e($tool->tool_code); ?>" readonly disabled
                                class="w-full bg-slate-100 border-slate-300 rounded-lg shadow-sm text-slate-500 cursor-not-allowed">
                            <p class="text-[10px] text-slate-500 mt-1">* Kode aset tidak dapat diubah setelah di-generate.</p>
                        </div>

                        <!-- Kategori Aset -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Aset <span class="text-rose-500">*</span></label>
                            <select name="category_id" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e($tool->category_id == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->category_name); ?> (<?php echo e($category->code); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Nama Alat -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Alat <span class="text-rose-500">*</span></label>
                            <input type="text" name="tool_name" value="<?php echo e($tool->tool_name); ?>" required placeholder="Contoh: Kamera Canon EOS 5D"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>

                        <!-- Merk / Tipe -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Merk / Tipe <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="brand" value="<?php echo e($tool->brand); ?>" placeholder="Contoh: Canon EOS 5D Mark IV"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>

                        <!-- Tanggal Perolehan -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Perolehan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="date" name="purchase_date" value="<?php echo e($tool->purchase_date ? \Carbon\Carbon::parse($tool->purchase_date)->format('Y-m-d') : ''); ?>"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                        </div>

                        <!-- Kondisi Aset -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kondisi Aset Saat Ini <span class="text-rose-500">*</span></label>
                            <select name="current_condition" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                                <option value="Baik" <?php echo e($tool->current_condition == 'Baik' ? 'selected' : ''); ?>>Baik (Siap Pakai)</option>
                                <option value="Rusak Ringan" <?php echo e($tool->current_condition == 'Rusak Ringan' ? 'selected' : ''); ?>>Rusak Ringan (Perlu Servis Minor)</option>
                                <option value="Rusak Berat" <?php echo e($tool->current_condition == 'Rusak Berat' ? 'selected' : ''); ?>>Rusak Berat (Tidak Bisa Dipakai)</option>
                            </select>
                        </div>

                        <!-- Ketersediaan -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Ketersediaan (Availability) <span class="text-rose-500">*</span></label>
                            <select name="availability_status" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                                <option value="available" <?php echo e($tool->availability_status == 'available' ? 'selected' : ''); ?>>Tersedia (Bisa Dipinjam)</option>
                                <option value="borrowed" <?php echo e($tool->availability_status == 'borrowed' ? 'selected' : ''); ?>>Sedang Dipinjam</option>
                                <option value="maintenance" <?php echo e($tool->availability_status == 'maintenance' ? 'selected' : ''); ?>>Dalam Perbaikan (Maintenance)</option>
                                <option value="missing" <?php echo e($tool->availability_status == 'missing' ? 'selected' : ''); ?>>Hilang / Tidak Ditemukan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition">Simpan Perubahan</button>
                    <button type="button" onclick="toggleModal('modal-edit-<?php echo e($tool->id); ?>')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-semibold shadow-sm transition">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/tools/modal_edit.blade.php ENDPATH**/ ?>