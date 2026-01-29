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
            <?php echo e(__('Tambah Aset Baru (Manual)')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900">Formulir Input Aset</h3>
                        <p class="text-sm text-slate-500">Gunakan form ini untuk input aset manual atau hibah, bukan dari hasil pembelian sistem.</p>
                    </div>

                    <form action="<?php echo e(route('tools.store')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Aset</label>
                                <select id="category_select" name="category_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->category_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Aset (Otomatis)</label>
                                <input type="text" id="tool_code" name="tool_code" readonly 
                                    class="w-full border-slate-200 rounded-lg shadow-sm bg-slate-100 text-slate-500 font-mono cursor-not-allowed"
                                    placeholder="Pilih kategori dulu...">
                            </div>

                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Aset</label>
                                <input type="text" name="tool_name" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400" 
                                    placeholder="Contoh: Kamera DSLR Canon 5D" required>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Merk / Tipe</label>
                                <input type="text" name="brand" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400" 
                                    placeholder="Contoh: Tekiro, Sony, Canon">
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Perolehan</label>
                                <input type="date" name="purchase_date" 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi Fisik</label>
                                <select name="current_condition" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Ketersediaan Awal</label>
                                <select name="availability_status" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available">Tersedia (Ready to Use)</option>
                                    <option value="borrowed">Sedang Dipinjam</option>
                                    <option value="maintenance">Dalam Perbaikan</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                            <a href="<?php echo e(route('tools.index')); ?>" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-500/30">
                                Simpan Aset
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('category_select');
            const codeInput = document.getElementById('tool_code');

            async function fetchNext(catId) {
                if (!catId) { codeInput.value = ''; return; }
                try {
                    const res = await fetch(`/categories/${catId}/next-code`);
                    if (!res.ok) return;
                    const json = await res.json();
                    if (json.next) codeInput.value = json.next;
                    else codeInput.value = '';
                } catch (e) {
                    console.error('Fetch next code error', e);
                }
            }

            if (select) {
                select.addEventListener('change', function() { fetchNext(this.value); });
                if (select.value) fetchNext(select.value);
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/tools/create.blade.php ENDPATH**/ ?>