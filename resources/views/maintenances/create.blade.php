<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Catat Pemeliharaan / Perbaikan Baru') }}
        </h2>
    </x-slot>

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
            
            {{-- Alert Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Terdapat kesalahan pada input:
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-xl font-bold text-slate-800">Form Perbaikan Aset</h3>
                        <p class="text-slate-500 mt-1 text-sm">Input data aset yang memerlukan pemeliharaan atau perbaikan.</p>
                    </div>

                    <form action="{{ route('maintenances.store') }}" method="POST">
                        @csrf

                        {{-- 1. PILIH ASET DENGAN BARCODE / QR SCANNER --}}
                        <div class="mb-5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Aset / Pindai QR Code Multimedia</label>
                            
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <input type="text" id="barcode_input" placeholder="Ketik kode aset atau Pindai QR..." class="w-full md:w-1/2 border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm" autofocus>
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
                            <div id="qr-reader-container" class="hidden w-full md:w-1/2 mb-4 border border-indigo-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                <div id="qr-reader" style="width: 100%;"></div>
                                <button type="button" id="btn_close_camera" class="w-full bg-rose-50 text-rose-600 py-3 font-bold text-sm hover:bg-rose-100 transition border-t border-rose-100 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Tutup Scanner Kamera
                                </button>
                            </div>

                            <p class="text-xs text-slate-500 mt-1" id="scan_status">Status: Standby untuk pemindaian QR...</p>
                            
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

                        {{-- 2. Pilihan Jenis Maintenance --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Perbaikan / Pemeliharaan</label>
                            <select name="maintenance_type_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 font-medium" required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('maintenance_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($types->isEmpty())
                                <p class="text-xs text-rose-500 mt-1 font-semibold">
                                    *Data Jenis Maintenance belum tersedia.
                                </p>
                            @endif
                        </div>

                        {{-- 3. Tanggal Mulai --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        {{-- 4. Deskripsi Masalah --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Keluhan</label>
                            <textarea name="note" rows="4" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400" placeholder="Jelaskan detail kerusakan atau pemeliharaan yang dibutuhkan..." required>{{ old('note') }}</textarea>
                        </div>

                        <div class="flex flex-row-reverse gap-3 border-t border-slate-100 pt-6">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                Simpan Data
                            </button>
                            <a href="{{ route('maintenances.index') }}" class="bg-white border border-slate-300 text-slate-700 px-6 py-2 rounded-lg font-semibold hover:bg-slate-50 transition">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    {{-- JAVASCRIPT LOGIC & HTML5-QRCODE --}}
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
</x-app-layout>