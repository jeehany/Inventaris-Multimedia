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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Pengajuan Pembelian Baru')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Error Input:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('purchases.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-2">Formulir Pengajuan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                                    <input type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Supplier (Vendor)</label>
                                    <select name="vendor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">-- Pilih Vendor --</option>
                                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vendor->id); ?>" <?php echo e(old('vendor_id') == $vendor->id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Barang / Alat</label>
                                    <input type="text" name="tool_name" value="<?php echo e(old('tool_name')); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Bor Listrik Makita" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori Alat</label>
                                    <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id') == $cat->id ? 'selected' : ''); ?>>
                                                <?php echo e($cat->category_name ?? $cat->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Spesifikasi Detail</label>
                                <textarea name="specification" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Warna, Daya, Ukuran, dll..."><?php echo e(old('specification')); ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah (Qty)</label>
                                <input type="number" name="quantity" id="qty" value="<?php echo e(old('quantity', 1)); ?>" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required oninput="calculateTotal()">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estimasi Harga Satuan (Rp)</label>
                                <input type="number" name="unit_price" id="price" value="<?php echo e(old('unit_price')); ?>" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required oninput="calculateTotal()">
                            </div>

                            <div class="md:col-span-2 bg-gray-50 p-4 rounded text-right border">
                                <span class="text-gray-600 font-bold mr-2">ESTIMASI TOTAL:</span>
                                <span class="text-2xl font-bold text-blue-600" id="totalDisplay">Rp 0</span>
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="<?php echo e(route('purchases.request')); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700 shadow">AJUKAN PEMBELIAN</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateTotal() {
            const qty = parseFloat(document.getElementById('qty').value) || 0;
            const price = parseFloat(document.getElementById('price').value) || 0;
            const total = qty * price;
            document.getElementById('totalDisplay').innerText = "Rp " + total.toLocaleString('id-ID');
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/purchases/create.blade.php ENDPATH**/ ?>