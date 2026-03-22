<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Buat Peminjaman Baru') }}
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
                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-2xl font-bold text-slate-800">Form Transaksi Sirkulasi</h3>
                        <p class="text-slate-500 mt-1">Isi data lengkap untuk mencatat peminjaman aset multimedia.</p>
                    </div>

                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            
                            {{-- ========================================== --}}
                            {{-- KOLOM KIRI (INFORMASI ADMIN & JADWAL) --}}
                            {{-- ========================================== --}}
                            <div class="lg:col-span-4 flex flex-col gap-6">
                                
                                {{-- 1. BAGIAN PEMINJAM --}}
                                <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                                    <div class="flex justify-between items-center mb-4 border-b border-indigo-100 pb-2">
                                        <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider">Informasi Peminjam</h4>
                                        <button type="button" onclick="toggleModal('modal-create-borrower')" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg flex items-center transition shadow-sm" title="Tambah Cepat">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                    
                                    <div>
                                        <select name="borrower_id" id="borrower_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-medium text-sm" required>
                                            <option value="">-- Cari Nama Anggota --</option>
                                            @foreach($borrowers as $borrower)
                                                <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                                                    {{ $borrower->name }} (ID: {{ $borrower->code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- 3. JADWAL --}}
                                <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Durasi Peminjaman</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                                        <div>
                                            <label for="borrow_date" class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Pinjam</label>
                                            <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" required>
                                        </div>
                                        <div>
                                            <label for="return_date" class="block text-xs font-semibold text-slate-700 mb-1">Rencana Kembali</label>
                                            <input type="date" name="return_date" id="return_date" value="{{ old('return_date') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- 4. CATATAN --}}
                                <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Catatan Peminjaman</h4>
                                    <textarea 
                                        name="notes" 
                                        id="notes" 
                                        rows="3" 
                                        class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder-slate-400" 
                                        placeholder="Tulis keperluan aset... opsional."
                                    >{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            {{-- ========================================== --}}
                            {{-- KOLOM KANAN (ASET YANG DIPINJAM & KAMERA) --}}
                            {{-- ========================================== --}}
                            <div class="lg:col-span-8 flex flex-col h-full bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                                
                                {{-- 2. PILIH ASET DENGAN BARCODE SCANNER --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="flex justify-between items-center mb-5 pb-2 border-b border-indigo-100">
                                        <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider">Aset Multimedia yang Dipinjam</h4>
                                    </div>
                                    
                                    {{-- Input Scanner --}}
                                    <div class="mb-4">
                                        <label for="barcode_input" class="block text-xs font-semibold text-slate-700 mb-2">Tambah Cepat (Scan / Ketik ID Aset)</label>
                                        <div class="flex flex-col sm:flex-row gap-2 mb-3 items-start">
                                            <div class="flex-1 w-full relative">
                                                <input type="text" id="barcode_input" placeholder="Ketik kode aset atau Pindai Barcode..." class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm" autofocus>
                                            </div>
                                            <div class="flex gap-2 w-full sm:w-auto shrink-0">
                                                <button type="button" id="btn_manual_add" class="flex-1 sm:flex-none justify-center bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition font-medium text-sm flex items-center gap-1.5 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    Pilih
                                                </button>
                                                <button type="button" id="btn_scan_camera" class="flex-1 sm:flex-none justify-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-1.5 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    Kamera
                                                </button>
                                            </div>
                                        </div>

                                        <p class="text-xs font-semibold text-slate-500" id="scan_status">Status: Menunggu scan aset...</p>
                                    </div>

                                    {{-- Tabel / List Aset Terpilih --}}
                                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col min-h-[240px] mt-1">
                                        <table class="min-w-full divide-y divide-slate-200 flex-1">
                                            <thead class="bg-slate-100 sticky top-0 z-10 shadow-sm border-b border-slate-200">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wide">Kode Aset</th>
                                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wide">Nama Aset</th>
                                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wide hidden sm:table-cell">Kategori</th>
                                                    <th class="px-6 py-3 text-center text-xs font-bold text-slate-700 uppercase tracking-wide w-20">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 bg-white" id="scanned_tools_body">
                                                <tr id="empty_row" class="bg-slate-50/50">
                                                    <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                        <p class="text-sm font-medium">Belum ada aset yang di-scan atau ditambahkan.</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Hidden Input Container for tool_ids[] --}}
                                    <div id="hidden_tool_inputs"></div>
                                </div>

                                {{-- TOMBOL SUBMIT (TERPAUT DI KOLOM KANAN BAWAH) --}}
                                <div class="bg-slate-100 border-t border-slate-200 p-5 flex items-center justify-end gap-3 mt-auto">
                                    <a href="{{ route('borrowings.index') }}" class="text-slate-500 hover:text-slate-800 font-semibold px-4 py-2 transition text-sm">Kembali</a>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-indigo-500/30 transition duration-200 ease-in-out transform hover:-translate-y-0.5 whitespace-nowrap text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Selesaikan Peminjaman
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE BORROWER AJAX --}}
    <div id="modal-create-borrower" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-hidden="true" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="toggleModal('modal-create-borrower')"></div>
            
            <div class="inline-block w-full max-w-md bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all relative z-[70]">
                <form id="form-create-borrower" onsubmit="submitBorrowerAjax(event)">
                    <div class="bg-white px-6 pt-6 pb-6">
                        <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-3">
                            <h3 class="text-lg font-bold text-slate-900">Tambah Anggota Cepat</h3>
                            <button type="button" onclick="toggleModal('modal-create-borrower')" class="text-slate-400 hover:text-rose-500 transition-colors">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Nomor Induk / ID -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">ID (NIM/NIP) <span class="text-rose-500">*</span></label>
                                <input type="text" name="code" required 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400" placeholder="Misal: 2210010...">
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required 
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kontak (WhatsApp)</label>
                                <input type="text" name="phone"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                        <button type="submit" id="btn-save-borrower" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition">Simpan Anggota</button>
                        <button type="button" onclick="toggleModal('modal-create-borrower')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-semibold shadow-sm transition">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- MODAL SCANNER KAMERA (POPUP) --}}
    <div id="modal-scanner-camera" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" id="bg-close-scanner"></div>
            
            <div class="inline-block w-full max-w-sm bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all relative z-[70]">
                <div class="bg-slate-800 px-4 py-3 border-b border-slate-700 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pemindai Aset Bulk-Scan
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
                            <span>Tertambahkan!</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 px-4 py-3 text-center border-t border-slate-200">
                    <p class="text-xs text-slate-500 font-medium whitespace-normal">Kamera dirancang untuk Multi-Scan, silakan scan aset secara berurutan. Klik [x] jika sudah selesai.</p>
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
        const bgCloseScanner = document.getElementById('bg-close-scanner');
        const scanSuccessOverlay = document.getElementById('scan-success-overlay');
        const scanStatus = document.getElementById('scan_status');
        const tableBody = document.getElementById('scanned_tools_body');
        const emptyRow = document.getElementById('empty_row');
        const hiddenInputsContainer = document.getElementById('hidden_tool_inputs');
        
        let html5QrcodeScanner = null;
        let addedToolIds = [];
        // Prevent scanning same code rapid fire
        let lastScannedCode = null;
        let scanThrottleTimer = null;

        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                processBarcode(this.value.trim());
            }
        });

        btnManualAdd.addEventListener('click', function() {
            processBarcode(barcodeInput.value.trim());
        });

        // Toggle Camera Scanner Modal
        btnScanCamera.addEventListener('click', function() {
            toggleModal('modal-scanner-camera'); // Buka model modal pop up
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
            // Throttling agar satu barcode tidak trigger puluhan kali per detik (Bulk scan protection)
            if (lastScannedCode === decodedText) return;
            
            lastScannedCode = decodedText;
            clearTimeout(scanThrottleTimer);
            scanThrottleTimer = setTimeout(() => { lastScannedCode = null; }, 2000); // 2 seconds delay before scanning SAME item again
            
            // Tampilkan animasi pop/overlay
            scanSuccessOverlay.classList.remove('opacity-0');
            setTimeout(() => {
                scanSuccessOverlay.classList.add('opacity-0');
            }, 800);

            showStatus('QR Terbaca: ' + decodedText, 'success');
            
            // Masukkan nilai hasil scanner kamera ke API fetch 
            processBarcode(decodedText);
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
            tr.className = 'hover:bg-slate-50 border-b border-slate-100';
            tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-xs font-mono text-indigo-600 font-bold">${tool.tool_code}</td>
                <td class="px-4 py-3 text-xs text-slate-800 font-medium">${tool.tool_name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-xs text-slate-500 hidden sm:table-cell">${tool.category_name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium">
                    <button type="button" onclick="removeTool(${tool.id})" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-1.5 rounded-lg transition" title="Hapus">
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
            // Check if it's the main form, not the modal form
            if (e.target.id === 'form-create-borrower') return;

            if(addedToolIds.length === 0) {
                e.preventDefault();
                alert('Anda harus melakukan scan aset minimal 1 barang!');
                barcodeInput.focus();
            }
        });

        // POPUP MODAL BORROWER LOGIC
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.toggle('hidden');
            }
        }

        async function submitBorrowerAjax(e) {
            e.preventDefault();
            const form = e.target;
            const btn = document.getElementById('btn-save-borrower');
            
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';

            const formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}'); // Explicit CSRF, though meta is also fine

            try {
                const response = await fetch('{{ route('borrowers.storeAjax') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Append new option to SELECT Box
                    const select = document.getElementById('borrower_id');
                    const option = new Option(`${result.borrower.name} (ID: ${result.borrower.code})`, result.borrower.id, true, true);
                    select.add(option);
                    
                    form.reset();
                    toggleModal('modal-create-borrower');
                    showStatus('Peminjam baru berhasil disimpan!', 'success');
                } else {
                    let errorMsg = 'Gagal!\n';
                    if (result.errors) {
                        for (let key in result.errors) {
                            errorMsg += `- ${result.errors[key][0]}\n`;
                        }
                    } else if (result.message) {
                        errorMsg += result.message;
                    }
                    alert(errorMsg);
                }
            } catch (error) {
                alert('Terjadi kesalahan koneksi saat menyimpan!');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Simpan Anggota';
            }
        }
    </script>
</x-app-layout>