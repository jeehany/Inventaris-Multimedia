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
                            <div class="flex justify-between items-center mb-4 border-b border-indigo-100 pb-2">
                                <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider">Pindai / Cari Aset (QR Code)</h4>
                            </div>
                            
                            
                            <div class="mb-4">
                                <label for="barcode_input" class="block text-sm font-semibold text-slate-700 mb-2">Kode Aset / Pindai QR Code</label>
                                <div class="flex gap-2 mb-3 flex-wrap">
                                    <input type="text" id="barcode_input" placeholder="Ketik kode aset atau Pindai QR..." class="w-full md:w-1/2 border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm" autofocus>
                                    <button type="button" id="btn_manual_add" class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition font-medium text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah
                                    </button>
                                    <button type="button" id="btn_scan_camera" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Gunakan Kamera
                                    </button>
                                </div>

                                <!-- Container QR Scanner -->
                                <div id="qr-reader-container" class="hidden w-full md:w-1/2 mb-4 border border-indigo-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                    <div id="qr-reader" style="width: 100%;"></div>
                                    <button type="button" id="btn_close_camera" class="w-full bg-rose-50 text-rose-600 py-3 font-bold text-sm hover:bg-rose-100 transition border-t border-rose-100 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tutup Scanner Kamera
                                    </button>
                                </div>

                                <p class="text-xs text-slate-500 mt-1" id="scan_status">Status: Standby untuk pemindaian QR...</p>
                            </div>

                            
                            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-100">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Kode Aset</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Nama Aset</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Kategori</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100" id="scanned_tools_body">
                                        <tr id="empty_row">
                                            <td colspan="4" class="px-4 py-8 text-center text-slate-400 text-sm">
                                                Belum ada aset yang di-scan atau ditambahkan.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            
                            <div id="hidden_tool_inputs"></div>
                        </div>

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="borrow_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" id="borrow_date" value="<?php echo e(old('borrow_date', date('Y-m-d'))); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label for="return_date" class="block text-sm font-semibold text-slate-700 mb-2">Rencana Kembali</label>
                                <input type="date" name="return_date" id="return_date" value="<?php echo e(old('return_date')); ?>" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
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

    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const barcodeInput = document.getElementById('barcode_input');
        const btnManualAdd = document.getElementById('btn_manual_add');
        const btnScanCamera = document.getElementById('btn_scan_camera');
        const btnCloseCamera = document.getElementById('btn_close_camera');
        const qrContainer = document.getElementById('qr-reader-container');
        const scanStatus = document.getElementById('scan_status');
        const tableBody = document.getElementById('scanned_tools_body');
        const emptyRow = document.getElementById('empty_row');
        const hiddenInputsContainer = document.getElementById('hidden_tool_inputs');
        
        let html5QrcodeScanner = null;
        let addedToolIds = [];

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
            // Pause scanner momentarily after success detection (optional but good for UX)
            showStatus('QR Terbaca: ' + decodedText, 'success');
            
            // Masukkan nilai hasil scanner kamera ke fungsi existing 
            processBarcode(decodedText);
            
            // Auto-close camera logic (if user only needs to scan one, but here we let them scan multi, 
            // so we keep it open, but we have a delay to prevent duplicate scanning rapidly)
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
        }

        function processBarcode(code) {
            if (!code) {
                showStatus('Kode tidak boleh kosong!', 'error');
                return;
            }

            barcodeInput.disabled = true;
            btnManualAdd.disabled = true;
            showStatus('Mencari kode: ' + code + '...', 'info');

            fetch(`/get-tool-by-code?code=${encodeURIComponent(code)}`)
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        addToolToTable(res.data);
                        showStatus('Berhasil menambahkan: ' + res.data.tool_name, 'success');
                        barcodeInput.value = '';
                    } else {
                        showStatus(res.message, 'error');
                        barcodeInput.classList.add('border-rose-500', 'ring-rose-500');
                        setTimeout(() => barcodeInput.classList.remove('border-rose-500', 'ring-rose-500'), 2000);
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

        function addToolToTable(tool) {
            if (addedToolIds.includes(tool.id)) {
                showStatus('Aset ini sudah ada di daftar!', 'error');
                return;
            }

            if (emptyRow) emptyRow.style.display = 'none';

            addedToolIds.push(tool.id);

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tool_ids[]';
            hiddenInput.value = tool.id;
            hiddenInput.id = 'hidden_tool_' + tool.id;
            hiddenInputsContainer.appendChild(hiddenInput);

            const tr = document.createElement('tr');
            tr.id = 'row_tool_' + tool.id;
            tr.className = 'hover:bg-slate-50';
            tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-indigo-600 font-bold">${tool.tool_code}</td>
                <td class="px-4 py-3 text-sm text-slate-800 font-medium">${tool.tool_name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">${tool.category_name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                    <button type="button" onclick="removeTool(${tool.id})" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-1.5 rounded-lg transition" title="Hapus dari daftar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        }

        window.removeTool = function(toolId) {
            addedToolIds = addedToolIds.filter(id => id !== toolId);
            
            const hiddenObj = document.getElementById('hidden_tool_' + toolId);
            if (hiddenObj) hiddenObj.remove();

            const rowObj = document.getElementById('row_tool_' + toolId);
            if (rowObj) rowObj.remove();

            if (addedToolIds.length === 0 && emptyRow) {
                emptyRow.style.display = '';
            }

            showStatus('Aset dihapus dari daftar.', 'info');
            barcodeInput.focus();
        };

        function showStatus(message, type) {
            scanStatus.textContent = 'Status: ' + message;
            scanStatus.className = 'text-xs mt-1 font-medium transition-colors ';
            if (type === 'error') scanStatus.classList.add('text-rose-500');
            else if (type === 'success') scanStatus.classList.add('text-emerald-500');
            else scanStatus.classList.add('text-indigo-500');
        }
        
        // Form Validation Before Submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if(addedToolIds.length === 0) {
                e.preventDefault();
                alert('Anda harus melakukan scan aset minimal 1 barang!');
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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/borrowings/create.blade.php ENDPATH**/ ?>