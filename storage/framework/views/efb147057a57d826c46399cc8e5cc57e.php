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
            <?php echo e(__('Pengajuan Pengadaan Baru (Rencana Anggaran Belanja)')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php if($errors->any()): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pengisian form:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('purchases.store')); ?>" method="POST" id="rabForm">
                <?php echo csrf_field(); ?>
                
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Informasi Umum Pengajuan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Pengajuan <span class="text-red-500">*</span></label>
                                <input type="date" name="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>" class="w-full rounded-lg border-slate-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 p-2.5" required>
                                <p class="text-xs text-slate-500 mt-1">Tanggal pembuatan dokumen rencana anggaran.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Vendor / Supplier</label>
                                <select name="vendor_id" class="w-full rounded-lg border-slate-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                                    <option value="">-- Rekomendasi Bebas / Tentukan Sendiri Nanti --</option>
                                    <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vendor->id); ?>" <?php echo e(old('vendor_id') == $vendor->id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-xs text-slate-500 mt-1">Pilih jika sudah ada target suplier spesifik (opsional).</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Daftar Alat / Aset
                        </h3>
                        <button type="button" onclick="tambahBarisItem()" class="px-4 py-2 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-lg border border-indigo-200 hover:bg-indigo-100 transition shadow-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Item Baru
                        </button>
                    </div>

                    <div class="overflow-x-auto p-0">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-100 border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 min-w-[200px]">Kategori & Nama Alat <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-3 min-w-[250px]">Spesifikasi / Keterangan</th>
                                    <th class="px-4 py-3 w-24">Jml <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-3 w-48">Est. Harga Satuan <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-3 w-48 text-right">Subtotal</th>
                                    <th class="px-4 py-3 w-16 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="containerItems" class="divide-y divide-slate-100">
                                <!-- Baris Pertama (Default) -->
                                <tr class="item-row hover:bg-slate-50">
                                    <td class="px-4 py-3">
                                        <div class="space-y-2">
                                            <select name="items[0][category_id]" class="w-full text-sm rounded border-slate-300 p-2" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->category_name ?? $cat->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <input type="text" name="items[0][tool_name]" class="w-full text-sm rounded border-slate-300 p-2" placeholder="Nama Alat/Merek..." required>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <textarea name="items[0][specification]" rows="2" class="w-full text-sm rounded border-slate-300 p-2" placeholder="Detail panjang fokal, daya, port, dll..."></textarea>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="items[0][quantity]" value="1" min="1" class="item-qty w-full text-sm rounded border-slate-300 p-2 text-center" required oninput="hitungSubtotal(this)">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">Rp</span>
                                            <input type="number" name="items[0][unit_price]" value="0" min="0" class="item-price w-full text-sm rounded border-slate-300 pl-10 p-2" required oninput="hitungSubtotal(this)">
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="item-subtotal-text font-bold text-slate-700">Rp 0</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" onclick="hapusBarisItem(this)" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition" title="Hapus Item">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-indigo-50/50 border-t-2 border-slate-200">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right font-bold text-slate-700 uppercase tracking-wide">
                                        Grand Total Estimasi RAB :
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-xl font-black text-indigo-700" id="grandTotalDisplay">Rp 0</div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                
                <div class="flex justify-end gap-3 mb-10">
                    <a href="<?php echo e(route('purchases.request')); ?>" class="px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-300 hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Simpan & Ajukan RAB
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Template Category (Hidden) untuk di-clone ke js -->
    <div id="categoryOptions" class="hidden">
        <option value="">-- Pilih Kategori --</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->category_name ?? $cat->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <script>
        let itemIndex = 1;

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
        }

        function hitungSubtotal(element) {
            let row = element.closest('tr');
            let qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            let price = parseFloat(row.querySelector('.item-price').value) || 0;
            let subtotal = qty * price;
            
            row.querySelector('.item-subtotal-text').innerText = formatRupiah(subtotal);
            hitungGrandTotal();
        }

        function hitungGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('#containerItems tr').forEach(row => {
                let qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                let price = parseFloat(row.querySelector('.item-price').value) || 0;
                grandTotal += (qty * price);
            });
            document.getElementById('grandTotalDisplay').innerText = formatRupiah(grandTotal);
        }

        function tambahBarisItem() {
            const container = document.getElementById('containerItems');
            const categoryOptions = document.getElementById('categoryOptions').innerHTML;
            
            const tr = document.createElement('tr');
            tr.className = 'item-row hover:bg-slate-50 border-t border-slate-100';
            
            tr.innerHTML = `
                <td class="px-4 py-3">
                    <div class="space-y-2">
                        <select name="items[${itemIndex}][category_id]" class="w-full text-sm rounded border-slate-300 p-2" required>
                            ${categoryOptions}
                        </select>
                        <input type="text" name="items[${itemIndex}][tool_name]" class="w-full text-sm rounded border-slate-300 p-2" placeholder="Nama Alat/Merek..." required>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <textarea name="items[${itemIndex}][specification]" rows="2" class="w-full text-sm rounded border-slate-300 p-2" placeholder="Detail panjang fokal, daya, port, dll..."></textarea>
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" class="item-qty w-full text-sm rounded border-slate-300 p-2 text-center" required oninput="hitungSubtotal(this)">
                </td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">Rp</span>
                        <input type="number" name="items[${itemIndex}][unit_price]" value="0" min="0" class="item-price w-full text-sm rounded border-slate-300 pl-10 p-2" required oninput="hitungSubtotal(this)">
                    </div>
                </td>
                <td class="px-4 py-3 text-right">
                    <span class="item-subtotal-text font-bold text-slate-700">Rp 0</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button" onclick="hapusBarisItem(this)" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition" title="Hapus Item">
                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            `;
            
            container.appendChild(tr);
            itemIndex++;
        }

        function hapusBarisItem(button) {
            const container = document.getElementById('containerItems');
            if (container.children.length > 1) {
                button.closest('tr').remove();
                hitungGrandTotal();
            } else {
                alert('Minimal harus ada 1 item untuk pengajuan.');
            }
        }
        
        // Panggil untuk inisiasi
        hitungGrandTotal();
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