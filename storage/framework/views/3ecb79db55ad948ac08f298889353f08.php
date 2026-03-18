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
            <?php echo e(__('Catat Pemeliharaan / Perbaikan Baru')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            
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
                    
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-xl font-bold text-slate-800">Form Perbaikan Aset</h3>
                        <p class="text-slate-500 mt-1 text-sm">Input data aset yang memerlukan pemeliharaan atau perbaikan.</p>
                    </div>

                    <form action="<?php echo e(route('maintenances.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        
                        <div class="mb-5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pindai QR / Barcode Aset Multimedia</label>
                            
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <input type="text" id="barcode_input" placeholder="Arahkan kursor kesini atau Pindai Kamera..." class="w-full md:w-1/2 border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm" autofocus>
                                <button type="button" id="btn_manual_add" class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition font-medium text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    Cari
                                </button>
                                <button type="button" id="btn_scan_camera" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Kamera
                                </button>
                            </div>

                            <!-- Container QR Scanner -->
                            <div id="qr-reader-container" class="hidden w-full md:w-1/2 mb-4 border-2 border-dashed border-indigo-200 rounded-xl overflow-hidden bg-white">
                                <div id="qr-reader" style="width: 100%;"></div>
                                <button type="button" id="btn_close_camera" class="w-full bg-rose-50 text-rose-600 py-2 font-semibold text-sm hover:bg-rose-100 transition border-t border-rose-100">
                                    Tutup Kamera
                                </button>
                            </div>

                            <p class="text-xs text-slate-500 mt-1" id="scan_status">Status: Standby untuk scan barcode/QR...</p>
                            
                            <!-- Tempat menyimpan Info Barang yang akan diservis -->
                            <div id="selected_tool_info" class="mt-4 hidden p-3 bg-indigo-50 rounded-lg border border-indigo-200 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white border border-indigo-100 rounded flex items-center justify-center text-indigo-500 font-bold shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>    
                                    </div>
                                    <div>
                                        <div id="selected_tool_name" class="font-bold text-slate-800 text-sm">Nama Alat</div>
                                        <div id="selected_tool_code" class="text-xs text-indigo-600 font-mono font-bold">CODE</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden input -->
                            <input type="hidden" name="tool_id" id="hidden_tool_id" required>
                        </div>

                        
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Perbaikan / Pemeliharaan</label>
                            <select name="maintenance_type_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 font-medium" required>
                                <option value="">-- Pilih Jenis --</option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" <?php echo e(old('maintenance_type_id') == $type->id ? 'selected' : ''); ?>>
                                        <?php echo e($type->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($types->isEmpty()): ?>
                                <p class="text-xs text-rose-500 mt-1 font-semibold">
                                    *Data Jenis Maintenance belum tersedia.
                                </p>
                            <?php endif; ?>
                        </div>

                        
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="<?php echo e(old('start_date', date('Y-m-d'))); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Keluhan</label>
                            <textarea name="note" rows="4" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400" placeholder="Jelaskan detail kerusakan atau pemeliharaan yang dibutuhkan..." required><?php echo e(old('note')); ?></textarea>
                        </div>

                        <div class="flex flex-row-reverse gap-3 border-t border-slate-100 pt-6">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                Simpan Data
                            </button>
                            <a href="<?php echo e(route('maintenances.index')); ?>" class="bg-white border border-slate-300 text-slate-700 px-6 py-2 rounded-lg font-semibold hover:bg-slate-50 transition">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const barcodeInput = document.getElementById('barcode_input');
        const btnManualAdd = document.getElementById('btn_manual_add');
        const btnScanCamera = document.getElementById('btn_scan_camera');
        const btnCloseCamera = document.getElementById('btn_close_camera');
        const qrContainer = document.getElementById('qr-reader-container');
        const scanStatus = document.getElementById('scan_status');
        
        const hiddenToolId = document.getElementById('hidden_tool_id');
        const selectedToolInfo = document.getElementById('selected_tool_info');
        const selectedToolName = document.getElementById('selected_tool_name');
        const selectedToolCode = document.getElementById('selected_tool_code');
        
        let html5QrcodeScanner = null;

        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                processBarcode(this.value.trim());
            }
        });

        btnManualAdd.addEventListener('click', function() {
            processBarcode(barcodeInput.value.trim());
        });

        // Toggle Camera Scanner
        btnScanCamera.addEventListener('click', function() {
            qrContainer.classList.remove('hidden');
            if(!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
                
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                showStatus('Kamera diaktifkan...', 'info');
            }
        });

        btnCloseCamera.addEventListener('click', function() {
            if(html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    html5QrcodeScanner = null;
                    qrContainer.classList.add('hidden');
                    showStatus('Kamera dimatikan.', 'info');
                    barcodeInput.focus();
                });
            }
        });

        function onScanSuccess(decodedText, decodedResult) {
            showStatus('QR Terbaca: ' + decodedText, 'success');
            processBarcode(decodedText);
            
            // Auto close camera in Maintenance Form because we only need 1 tool
            if(html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    html5QrcodeScanner = null;
                    qrContainer.classList.add('hidden');
                });
            }
        }

        function onScanFailure(error) {
            // keep scanning silently
        }

        function processBarcode(code) {
            if (!code) {
                showStatus('Kode tidak boleh kosong!', 'error');
                return;
            }

            barcodeInput.disabled = true;
            btnManualAdd.disabled = true;
            showStatus('Mencari data kerusakan alat dengan kode: ' + code + '...', 'info');

            fetch(`/get-tool-by-code?code=${encodeURIComponent(code)}`)
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        // Cek jika alat tidak sedang available/maintenance dsb sesuai rule jika perlu
                        // Saat ini API default mengembalikan tool jika valid
                        selectedToolInfo.classList.remove('hidden');
                        selectedToolName.textContent = res.data.tool_name + " (" + res.data.category_name + ")";
                        selectedToolCode.textContent = res.data.tool_code;
                        hiddenToolId.value = res.data.id;
                        
                        showStatus('Berhasil menemukan: ' + res.data.tool_name, 'success');
                        barcodeInput.value = '';
                    } else {
                        showStatus(res.message, 'error');
                        selectedToolInfo.classList.add('hidden');
                        hiddenToolId.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching tool:', error);
                    showStatus('Terjadi kesalahan jaringan.', 'error');
                })
                .finally(() => {
                    barcodeInput.disabled = false;
                    btnManualAdd.disabled = false;
                    barcodeInput.focus();
                });
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/maintenances/create.blade.php ENDPATH**/ ?>