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
            <?php echo e(__('Buat Peminjaman Baru')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            
            <?php if($errors->any()): ?>
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Terdapat kesalahan pada input:
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-2xl font-bold text-slate-800">Form Transaksi Sirkulasi</h3>
                        <p class="text-slate-500 mt-1">Isi data lengkap untuk mencatat peminjaman aset multimedia.</p>
                    </div>

                    <form action="<?php echo e(route('borrowings.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                            <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Informasi Peminjam</h4>
                            <div class="max-w-xl">
                                <label for="borrower_id" class="block text-sm font-semibold text-slate-700 mb-2">Nama Anggota Tim</label>
                                <select name="borrower_id" id="borrower_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-medium" required>
                                    <option value="">-- Cari Nama Anggota --</option>
                                    <?php $__currentLoopData = $borrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($borrower->id); ?>" <?php echo e(old('borrower_id') == $borrower->id ? 'selected' : ''); ?>>
                                            <?php echo e($borrower->name); ?> (ID: <?php echo e($borrower->code); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                            <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Pilih Aset Multimedia</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div>
                                    <label for="category_filter" class="block text-sm font-semibold text-slate-700 mb-2">Filter Kategori</label>
                                    <select id="category_filter" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white text-slate-700">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pilih kategori untuk menampilkan daftar aset.
                                    </p>
                                </div>
    
                                
                                <div>
                                    <label for="tool_ids" class="block text-sm font-semibold text-slate-700 mb-2">Daftar Aset (Multi-Select)</label>
                                    <select name="tool_ids[]" id="tool_ids" multiple class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-40 bg-slate-100 cursor-not-allowed text-sm text-slate-600 font-mono" disabled required>
                                        <option value="" class="p-2">-- Menunggu Input Kategori --</option>
                                    </select>
                                    <div class="mt-2 text-xs text-indigo-600 bg-indigo-50 p-2 rounded border border-indigo-100 inline-block">
                                        <strong>Tips:</strong> Tahan tombol <kbd class="font-sans bg-white border border-slate-300 rounded px-1">CTRL</kbd> (Win) atau <kbd class="font-sans bg-white border border-slate-300 rounded px-1">CMD</kbd> (Mac) untuk memilih banyak aset.
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="borrow_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" id="borrow_date" value="<?php echo e(old('borrow_date', date('Y-m-d'))); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label for="planned_return_date" class="block text-sm font-semibold text-slate-700 mb-2">Rencana Kembali</label>
                                <input type="date" name="planned_return_date" id="planned_return_date" value="<?php echo e(old('planned_return_date')); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        
                        <div class="mb-10">
                            <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Keperluan (Opsional)</label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="3" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400" 
                                placeholder="Contoh: Digunakan untuk dokumentasi event tahunan..."
                            ><?php echo e(old('notes')); ?></textarea>
                        </div>

                        
                        <div class="flex items-center justify-end border-t border-slate-100 pt-6">
                            <a href="<?php echo e(route('borrowings.index')); ?>" class="text-slate-600 hover:text-slate-900 mr-6 font-semibold transition">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                                Proses Peminjaman
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    
    <script>
        document.getElementById('category_filter').addEventListener('change', function() {
            var categoryId = this.value;
            var toolSelect = document.getElementById('tool_ids');

            // 1. Reset Dropdown Alat
            toolSelect.innerHTML = '<option value="" class="p-2 text-slate-400">Memuat data...</option>';
            toolSelect.disabled = true;
            toolSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
            toolSelect.classList.remove('bg-white', 'text-slate-700');

            if (categoryId) {
                // 2. Fetch Data dari Server
                fetch('/get-tools/' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        // Kosongkan opsi
                        toolSelect.innerHTML = '';
                        
                        if (data.length === 0) {
                            toolSelect.innerHTML = '<option value="" class="p-2">Tidak ada aset tersedia / stok habis</option>';
                        } else {
                            // Loop data alat dan masukkan ke dropdown
                            data.forEach(tool => {
                                var option = document.createElement('option');
                                option.value = tool.id;
                                option.text = tool.tool_name + ' (Kode: ' + tool.tool_code + ')';
                                option.className = "p-2 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0";
                                toolSelect.appendChild(option);
                            });
                            
                            // Aktifkan Dropdown
                            toolSelect.disabled = false;
                            toolSelect.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
                            toolSelect.classList.add('bg-white', 'text-slate-700');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toolSelect.innerHTML = '<option value="" class="p-2 text-rose-500">Gagal memuat data</option>';
                    });
            } else {
                toolSelect.innerHTML = '<option value="" class="p-2">-- Pilih Kategori Dahulu --</option>';
            }
        });
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/borrowings/create.blade.php ENDPATH**/ ?>