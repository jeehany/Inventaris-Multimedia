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
            <?php echo e(__('Pusat Laporan & Analitik')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">Katalog Laporan Operasional</h3>
                <p class="text-slate-500 mt-1">Pilih jenis laporan yang ingin Anda unduh dan tentukan rentang waktu jika diperlukan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                
                <div id="repo-1" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">1</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Laporan Peminjaman Keluar-Masuk</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Riwayat aktivitas sirkulasi aset yang dipinjam beserta tanggal peminjaman & pengembalian.</p>
                    </div>
                    <form action="<?php echo e(route('reports.borrowing')); ?>" method="GET">
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Mulai Tanggal</label>
                                <input type="date" name="start_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Hingga Tanggal</label>
                                <input type="date" name="end_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-2" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Laporan Riwayat Maintenance</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Daftar perbaikan alat yang selesai beserta total rincian biaya yang dihabiskan.</p>
                    </div>
                    <form action="<?php echo e(route('reports.maintenance')); ?>" method="GET">
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Mulai Tanggal</label>
                                <input type="date" name="start_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Hingga Tanggal</label>
                                <input type="date" name="end_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-3" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Laporan Pengadaan Barang</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Merekap bukti transaksi belanja, pengeluaran anggaran dan detail harga per item.</p>
                    </div>
                    <form action="<?php echo e(route('reports.purchase')); ?>" method="GET">
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Mulai Tanggal</label>
                                <input type="date" name="start_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Hingga Tanggal</label>
                                <input type="date" name="end_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-4" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">4</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Analisis Penggunaan Aset</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Menghitung frekuensi tingkat penggunaan aset. Menampilkan daftar alat dari yang terbanyak disewa.</p>
                    </div>
                    <form action="<?php echo e(route('reports.assetUsage')); ?>" method="GET">
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Mulai Tanggal (Periode Pinjam)</label>
                                <input type="date" name="start_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Hingga Tanggal</label>
                                <input type="date" name="end_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-5" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">5</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Kondisi Barang Terkini</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Menampilkan katalog status alat (Baik vs Rusak Ringan/Berat) posisi realtime tanpa filter tanggal.</p>
                    </div>
                    <form action="<?php echo e(route('reports.assetCondition')); ?>" method="GET">
                        <div class="h-[124px] flex items-center justify-center border-2 border-dashed border-slate-100 rounded-xl mb-4 bg-slate-50">
                            <span class="text-xs font-medium text-slate-400">Dicetak Berdasarkan Kondisi Real-Time</span>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-6" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-fuchsia-50 text-fuchsia-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">6</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Nilai Aset / Depresiasi</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Analisis Harga Beli Awal vs Total Beban Investasi / Perawatan yang telah dikeluarkan.</p>
                    </div>
                    <form action="<?php echo e(route('reports.assetDepreciation')); ?>" method="GET">
                         <div class="h-[124px] flex items-center justify-center border-2 border-dashed border-slate-100 rounded-xl mb-4 bg-slate-50">
                            <span class="text-xs font-medium text-slate-400 text-center px-4">Mengakumulasi seluruh data biaya sejarah.</span>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-7" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">7</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Rekap Kerusakan per Kategori</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Menilai kategori alat mana yang paling rengkih/sering diservis berdasarkan akumulasi perawatan.</p>
                    </div>
                    <form action="<?php echo e(route('reports.damageCategory')); ?>" method="GET">
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Mulai Tanggal (Periode Servis)</label>
                                <input type="date" name="start_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Hingga Tanggal</label>
                                <input type="date" name="end_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

                
                <div id="repo-8" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">8</span>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2">Laporan Rekapitulasi Vendor</h4>
                        <p class="text-xs text-slate-500 mb-4 line-clamp-3">Daftar peringkat vendor supplier yang paling sering menerima PO dari perusahaan.</p>
                    </div>
                    <form action="<?php echo e(route('reports.vendorRecap')); ?>" method="GET">
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Mulai Tanggal (Transaksi)</label>
                                <input type="date" name="start_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase">Hingga Tanggal</label>
                                <input type="date" name="end_date" class="w-full text-xs border-slate-300 rounded-lg shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded-xl text-sm transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/reports/index.blade.php ENDPATH**/ ?>