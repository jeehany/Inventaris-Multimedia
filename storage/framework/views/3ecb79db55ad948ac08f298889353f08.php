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

    <style>
        /* Custom UI for HTML5-QRCode Scanner */
        #qr-reader {
            border: none !important;
            border-radius: 0.75rem;
            overflow: hidden;
            padding: 1rem;
        }
        #qr-reader__dashboard_section_csr span,
        #qr-reader__dashboard_section_csr div {
            font-family: inherit !important;
            color: #475569 !important;
            font-size: 0.875rem !important;
        }
        #qr-reader__dashboard_section_swaplink {
            text-decoration: none !important;
            color: #4f46e5 !important;
            font-weight: 600;
            font-size: 0.875rem;
            margin-top: 0.75rem;
            display: inline-block;
            transition: color 0.2s;
        }
        #qr-reader__dashboard_section_swaplink:hover {
            color: #3730a3 !important;
        }
        #qr-reader button {
            background-color: #f1f5f9 !important;
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            margin: 0.25rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        #qr-reader button:hover {
            background-color: #e2e8f0 !important;
        }
        #qr-reader__dashboard_section_csr input[type="file"] {
            display: block;
            width: 100%;
            font-size: 0.875rem;
            color: #475569;
            background-color: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 0.75rem;
            padding: 1.5rem 1rem;
            margin: 1rem 0;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.2s;
        }
        #qr-reader__dashboard_section_csr input[type="file"]:hover {
            border-color: #818cf8;
        }
        #qr-reader__dashboard_section_csr input[type="file"]::file-selector-button {
            background-color: #4f46e5;
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            margin-right: 1.5rem;
            transition: background-color 0.2s;
        }
        #qr-reader__dashboard_section_csr input[type="file"]::file-selector-button:hover {
            background-color: #4338ca;
        }
    </style>

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

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            
                            
                            <div class="lg:col-span-4 flex flex-col gap-6">
                                
                                
                                <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Detail Pemeliharaan</h4>
                                    
                                    <div class="mb-4">
                                        <label class="block text-xs font-semibold text-slate-700 mb-2">Jenis Perbaikan / Pemeliharaan <span class="text-rose-500">*</span></label>
                                        <select name="maintenance_type_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 font-medium text-sm" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->id); ?>" <?php echo e(old('maintenance_type_id') == $type->id ? 'selected' : ''); ?>>
                                                    <?php echo e($type->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if($types->isEmpty()): ?>
                                            <p class="text-xs text-rose-500 mt-1 font-semibold">
                                                *Data Jenis Maintenance kosong.
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-2">Tanggal Mulai <span class="text-rose-500">*</span></label>
                                        <input type="date" name="start_date" value="<?php echo e(old('start_date', date('Y-m-d'))); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                                    </div>
                                </div>

                                
                                <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Keterangan / Keluhan</h4>
                                    <textarea name="note" rows="5" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 text-sm" placeholder="Jelaskan detail kerusakan atau keluhan yang dialami aset..." required><?php echo e(old('note')); ?></textarea>
                                </div>
                            </div>

                            
                            <div class="lg:col-span-8 flex flex-col h-full bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                                
                                <div class="p-6 flex-1 flex flex-col">
                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-5 pb-2 border-b border-indigo-100">Aset Multimedia yang Diproses</h4>
                                    
                                    <label for="barcode_input" class="block text-xs font-semibold text-slate-700 mb-2">Pencarian Aset (Scan / Ketik ID Aset) <span class="text-rose-500">*</span></label>
                                    <div class="flex flex-col sm:flex-row gap-2 mb-3 items-start">
                                        <div class="flex-1 w-full relative">
                                            <input type="text" id="barcode_input" placeholder="Ketik kode aset atau Pindai Barcode..." class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm" autofocus>
                                        </div>
                                        <div class="flex gap-2 w-full sm:w-auto shrink-0">
                                            <button type="button" id="btn_manual_add" class="flex-1 sm:flex-none justify-center bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition font-medium text-sm flex items-center gap-1.5 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                Cari
                                            </button>
                                            <button type="button" id="btn_scan_camera" class="flex-1 sm:flex-none justify-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-1.5 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Kamera
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <p class="text-xs text-slate-500 font-semibold mt-1 mb-5" id="scan_status">Status: Menunggu identifikasi aset...</p>
                                    
                                    <!-- Tempat menyimpan Info Barang yang diservis -->
                                    <div id="selected_tool_info" class="hidden relative p-5 bg-white rounded-xl border-2 border-indigo-200 shadow-sm overflow-hidden group">
                                        <div class="absolute top-0 left-0 w-2 h-full bg-indigo-500"></div>
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold shadow-sm shrink-0">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>    
                                            </div>
                                            <div class="pt-1">
                                                <div id="selected_tool_name" class="font-bold text-slate-800 text-lg leading-tight mb-1">Nama Alat</div>
                                                <div id="selected_tool_code" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-bold bg-indigo-100 text-indigo-700">CODE</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Placeholder ketika barang belum dipilih -->
                                    <div id="empty_tool_info" class="flex-1 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-xl p-8 bg-slate-50/50">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                                        <p class="text-sm font-medium text-slate-400">Belum ada aset pemeliharaan yang diidentifikasi.</p>
                                    </div>
                                    
                                    <input type="hidden" name="tool_id" id="hidden_tool_id" required>
                                </div>
                                
                                
                                <div class="bg-slate-100 border-t border-slate-200 p-5 flex items-center justify-end gap-3 mt-auto">
                                    <a href="<?php echo e(route('maintenances.index')); ?>" class="text-slate-500 hover:text-slate-800 font-semibold px-4 py-2 transition text-sm">Kembali</a>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-indigo-500/30 transition duration-200 ease-in-out transform hover:-translate-y-0.5 whitespace-nowrap text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Proses Pemeliharaan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    
    <div id="modal-scanner-camera" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" id="bg-close-scanner"></div>
            
            <div class="inline-block w-full max-w-sm bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all relative z-[70]">
                <div class="bg-slate-800 px-4 py-3 border-b border-slate-700 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pemindai Aset Pemeliharaan
                    </h3>
                    <button type="button" id="btn_close_camera" class="text-slate-400 hover:text-rose-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="bg-black p-1 relative">
                    <div id="qr-reader" class="w-full overflow-hidden outline-none bg-black" style="min-height: 250px;"></div>
                    <!-- Overlay Notifikasi Sukses Scan -->
                    <div id="scan-success-overlay" class="absolute inset-0 bg-emerald-500/80 backdrop-blur-sm flex items-center justify-center text-white font-bold opacity-0 pointer-events-none transition-opacity duration-300 z-10">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span>Tangkapan Sukses!</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 px-4 py-3 text-center border-t border-slate-200">
                    <p class="text-xs text-slate-500 font-medium whitespace-normal">Arahkan kamera ke QRCode / Barcode aset yang rusak.</p>
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
        const bgCloseScanner = document.getElementById('bg-close-scanner');
        const scanSuccessOverlay = document.getElementById('scan-success-overlay');
        const scanStatus = document.getElementById('scan_status');
        
        const hiddenToolId = document.getElementById('hidden_tool_id');
        const selectedToolInfo = document.getElementById('selected_tool_info');
        const selectedToolName = document.getElementById('selected_tool_name');
        const selectedToolCode = document.getElementById('selected_tool_code');
        const emptyToolInfo = document.getElementById('empty_tool_info');
        
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

        function toggleModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.toggle('hidden');
            }
        }

        // Toggle Camera Scanner Modal
        btnScanCamera.addEventListener('click', function() {
            toggleModal('modal-scanner-camera');
            if(!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
                
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                showStatus('Kamera diaktifkan...', 'info');
            }
        });

        const closeCameraHelper = () => {
            if(html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    html5QrcodeScanner = null;
                    document.getElementById('modal-scanner-camera').classList.add('hidden');
                    showStatus('Kamera dimatikan.', 'info');
                    barcodeInput.focus();
                });
            } else {
                document.getElementById('modal-scanner-camera').classList.add('hidden');
            }
        };

        if (btnCloseCamera) btnCloseCamera.addEventListener('click', closeCameraHelper);
        if (bgCloseScanner) bgCloseScanner.addEventListener('click', closeCameraHelper);

        function onScanSuccess(decodedText, decodedResult) {
            // Tampilkan animasi pop/overlay
            scanSuccessOverlay.classList.remove('opacity-0');
            setTimeout(() => {
                scanSuccessOverlay.classList.add('opacity-0');
            }, 800);

            showStatus('QR Terbaca: ' + decodedText, 'success');
            processBarcode(decodedText);
            
            // Auto close camera in Maintenance Form because we only need 1 tool
            setTimeout(() => {
                closeCameraHelper();
            }, 600);
        }

        function onScanFailure(error) {
            // keep scanning silently
        }

        function showStatus(message, type) {
            scanStatus.textContent = 'Status: ' + message;
            scanStatus.className = 'text-xs mt-1 font-semibold transition-colors mb-5 ';
            if (type === 'error') scanStatus.classList.add('text-rose-500');
            else if (type === 'success') scanStatus.classList.add('text-emerald-500');
            else scanStatus.classList.add('text-indigo-500');
        }

        function processBarcode(code) {
            if (!code) {
                showStatus('Kode tidak boleh kosong!', 'error');
                return;
            }

            barcodeInput.disabled = true;
            btnManualAdd.disabled = true;
            showStatus('Mencari data aset dengan kode: ' + code + '...', 'info');

            fetch(`/get-tool-by-code?code=${encodeURIComponent(code)}`)
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        // Cek jika alat tidak sedang available/maintenance dsb sesuai rule jika perlu
                        selectedToolInfo.classList.remove('hidden');
                        if (emptyToolInfo) emptyToolInfo.classList.add('hidden');
                        
                        selectedToolName.textContent = res.data.tool_name + " (" + res.data.category_name + ")";
                        selectedToolCode.textContent = res.data.tool_code;
                        hiddenToolId.value = res.data.id;
                        
                        showStatus('Berhasil menemukan: ' + res.data.tool_name, 'success');
                        barcodeInput.value = '';
                    } else {
                        showStatus(res.message, 'error');
                        selectedToolInfo.classList.add('hidden');
                        if (emptyToolInfo) emptyToolInfo.classList.remove('hidden');
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
        
        // Prevent form submission if tool_id is empty
        document.querySelector('form').addEventListener('submit', function(e) {
            if(!hiddenToolId.value) {
                e.preventDefault();
                alert('Anda harus memilih aset yang akan diperbaiki terlebih dahulu!');
                barcodeInput.focus();
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/maintenances/create.blade.php ENDPATH**/ ?>