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
            <?php echo e(__('Transaksi Pengadaan')); ?>

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

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Siap Belanja</p>
                        <p class="text-2xl font-bold text-slate-800"><?php echo e($approvedTransactions); ?></p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>

                 
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Estimasi Total Biaya</p>
                        <p class="text-lg font-bold text-slate-800">Rp <?php echo e(number_format($totalPlanCost, 0, ',', '.')); ?></p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">
                    
                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Proses Transaksi Pengadaan</h3>
                        <p class="text-sm text-slate-500 mt-1">Selesaikan proses pengadaan dengan mengupload bukti pembayaran dan nota.</p>
                    </div>

                    
                    <div class="mb-8">
                        <form action="<?php echo e(url()->current()); ?>" method="GET" class="w-full md:w-fit flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            
                            <div class="relative w-full md:w-48 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                    placeholder="Cari Kode..." 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    onblur="this.form.submit()">
                            </div>

                            
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <?php
                                    $indoMonths = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                ?>
                                <select name="month" onchange="this.form.submit()" class="w-full md:w-32 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Bulan -</option>
                                    <?php $__currentLoopData = $indoMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e(request('month') == $key ? 'selected' : ''); ?>>
                                            <?php echo e($val); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            
                            <div class="w-full md:w-auto relative group">
                                <select name="year" onchange="this.form.submit()" class="w-full md:w-24 pl-3 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Thn -</option>
                                    <?php for($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                        <option value="<?php echo e($y); ?>" <?php echo e(request('year') == $y ? 'selected' : ''); ?>>
                                            <?php echo e($y); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            
                            <?php if(request('search') || request('month') || request('year')): ?>
                                <a href="<?php echo e(url()->current()); ?>" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>

                    
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode & Tanggal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Detail Aset</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Vendor</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Nominal (Disetujui)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800"><?php echo e($p->purchase_code); ?></div>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            <?php echo e(\Carbon\Carbon::parse($p->date)->format('d M Y')); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-indigo-700"><?php echo e($p->tool_name); ?></div>
                                        <div class="text-xs text-slate-500 mt-0.5"><?php echo e($p->category->category_name ?? '-'); ?></div>
                                        <?php if($p->specification): ?>
                                            <div class="mt-1 text-[10px] bg-amber-50 text-amber-700 border border-amber-200 px-1.5 py-0.5 rounded inline-block">
                                                <?php echo e($p->specification); ?>

                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-1 font-medium text-slate-600 text-xs">Qty: <?php echo e($p->quantity); ?> Unit</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <?php echo e($p->vendor->name); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-slate-400 text-xs">Est. Unit: Rp <?php echo e(number_format($p->unit_price, 0, ',', '.')); ?></div>
                                        <div class="font-bold text-slate-800">Rp <?php echo e(number_format($p->subtotal, 0, ',', '.')); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        
                                        
                                        <?php if(Auth::user()->role == 'head'): ?>
                                            
                                            <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">View Only</span>
                                        <?php else: ?>
                                            
                                            <button 
                                                onclick="openModal('<?php echo e($p->id); ?>', '<?php echo e(addslashes($p->tool_name)); ?>', '<?php echo e($p->unit_price); ?>')"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm hover:shadow-md transition duration-150 ease-in-out gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Proses
                                            </button>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                            <p class="text-base font-medium">Tidak ada transaksi yang perlu diproses.</p>
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

    
    <div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full ring-1 ring-black ring-opacity-5">
                
                <form id="evidenceForm" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">
                                    Selesaikan Transaksi
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 mb-4">
                                        Upload bukti pembayaran dan data akhir untuk: <span id="modalToolName" class="font-bold text-indigo-600"></span>
                                    </p>
                                    
                                    <input type="hidden" id="purchaseId" name="purchase_id">

                                    <div class="grid grid-cols-1 gap-5">
                                        
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1">Estimasi Budget (Rencana)</label>
                                            <input type="text" id="displayPlannedPrice" disabled 
                                                   class="block w-full bg-slate-50 border-slate-300 rounded-lg shadow-sm text-sm text-slate-500 cursor-not-allowed">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1">Harga Asli (Sesuai Nota)</label>
                                            <div class="relative rounded-lg shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-500 text-sm">Rp</span>
                                                </div>
                                                <input type="number" name="actual_unit_price" required
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 text-sm border-slate-300 rounded-lg" 
                                                       placeholder="0">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1">Merk / Brand Akhir</label>
                                            <input type="text" name="brand" required
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-slate-300 rounded-lg"
                                                   placeholder="Contoh: Canon, Honda (Sesuai Nota)">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1">Foto Nota / Bukti</label>
                                            <input type="file" name="proof_photo" required
                                                   class="block w-full text-sm text-slate-500
                                                          file:mr-4 file:py-2.5 file:px-4
                                                          file:rounded-full file:border-0
                                                          file:text-sm file:font-bold
                                                          file:bg-indigo-50 file:text-indigo-700
                                                          hover:file:bg-indigo-100 transition">
                                            <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Maks: 2MB.</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Simpan & Selesaikan
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id, name, plannedPrice) {
            // 1. Reset Form
            const form = document.getElementById('evidenceForm');
            form.reset();
            form.action = "/purchases/" + id + "/process"; // Sesuaikan route

            // 2. Isi Nama Barang
            document.getElementById('modalToolName').innerText = name;

            // 3. Isi Harga Rencana (Format Rupiah)
            const priceInput = document.getElementById('displayPlannedPrice');
            if(priceInput) {
                try {
                    priceInput.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(plannedPrice);
                } catch(e) {
                    priceInput.value = plannedPrice;
                }
            }

            // 4. Tampilkan Modal
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('uploadModal').classList.add('hidden');
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/purchases/transaction.blade.php ENDPATH**/ ?>