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
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 p-8 shadow-xl mb-8">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-emerald-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-2">
                            Selamat Datang, <span class="text-indigo-400"><?php echo e(Auth::user()->name); ?></span>! 👋
                        </h3>
                        <p class="text-slate-300 max-w-xl">
                            <?php if(auth()->user()->isHead()): ?>
                                Berikut adalah ringkasan aktivitas peminjaman dan performa inventaris bulan ini.
                            <?php else: ?>
                                Panel operasional untuk mengelola aset, peminjaman, dan data pengguna secara efisien.
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/10">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></div>
                        <span class="text-sm font-medium text-white"><?php echo e(now()->translatedFormat('l, d F Y')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <?php if(auth()->user()->isHead()): ?>
                    <!-- Head Stats -->
                    <!-- CARD 1: ACTION NEEDED (Pengajuan Menunggu) -->
                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden ring-1 ring-orange-100">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-orange-600 text-sm font-bold uppercase tracking-wider mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                                Perlu Persetujuan
                            </div>
                            <div class="text-4xl font-extrabold text-slate-800 mt-2"><?php echo e($data['pending_purchases_count']); ?></div>
                            <div class="text-xs text-slate-500 font-medium mt-2">Pengajuan pengadaan baru</div>
                            
                            <?php if($data['pending_purchases_count'] > 0): ?>
                                <a href="<?php echo e(route('purchases.request')); ?>" class="absolute bottom-0 right-0 p-4 text-orange-600 hover:text-orange-700 font-semibold text-xs flex items-center gap-1">
                                    Lihat Detail <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- CARD 2: Peminjaman Bulan Ini -->
                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Sirkulasi Bulan Ini</div>
                            <div class="text-3xl font-bold text-slate-800"><?php echo e($data['monthly_borrowings']); ?></div>
                            <div class="text-xs text-indigo-500 font-medium mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                <span>Transaksi Peminjaman</span>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: Sedang Dipinjam -->
                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Aset Diluar</div>
                            <div class="text-3xl font-bold text-slate-800"><?php echo e($data['active_borrowings']); ?></div>
                             <div class="text-xs text-blue-500 font-medium mt-2">Sedang digunakan</div>
                        </div>
                    </div>

                    <!-- CARD 4: Button Laporan -->
                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden flex flex-col justify-center items-center text-center cursor-pointer" onclick="window.location='<?php echo e(route('purchases.history')); ?>'">
                        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-full mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-700">Laporan Pengadaan</h4>
                        <p class="text-xs text-slate-400 mt-1">Cek realisasi anggaran</p>
                    </div>
                <?php else: ?>
                    <!-- Admin Stats -->
                     <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Total Aset</div>
                            <div class="text-3xl font-bold text-slate-800"><?php echo e($data['total_tools']); ?></div>
                            <div class="text-xs text-indigo-500 font-medium mt-2">Item terdaftar</div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                         <div class="absolute right-0 top-0 w-24 h-24 bg-slate-100 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Total Pengguna</div>
                            <div class="text-3xl font-bold text-slate-800"><?php echo e($data['total_users']); ?></div>
                            <div class="text-xs text-slate-500 font-medium mt-2">Anggota aktif</div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                         <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Sedang Dipinjam</div>
                            <div class="text-3xl font-bold text-slate-800"><?php echo e($data['active_borrowings']); ?></div>
                             <div class="text-xs text-amber-600 font-medium mt-2 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Aset diluar</span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                         <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative">
                            <div class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-1">Kembali Hari Ini</div>
                            <div class="text-3xl font-bold text-emerald-600"><?php echo e($data['returned_today']); ?></div>
                            <div class="text-xs text-emerald-500 font-medium mt-2">Transaksi selesai</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Activity Feed (Left 2/3) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                                <span class="flex h-2 w-2 rounded-full <?php echo e(auth()->user()->isHead() ? 'bg-orange-500' : 'bg-indigo-500'); ?>"></span>
                                <?php echo e(auth()->user()->isHead() ? 'Pengajuan Menunggu Persetujuan' : 'Aktivitas Terbaru'); ?>

                            </h4>
                            <?php if(auth()->user()->isHead()): ?>
                                <a href="<?php echo e(route('purchases.request', ['status' => 'pending'])); ?>" class="text-sm font-medium text-orange-600 hover:text-orange-700 hover:underline">Lihat Semua</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('borrowings.index')); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:underline">Lihat Semua</a>
                            <?php endif; ?>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <?php if(auth()->user()->isHead()): ?>
                                            <th class="px-6 py-4 font-semibold">Tgl & Kode</th>
                                            <th class="px-6 py-4 font-semibold">Pemohon</th>
                                            <th class="px-6 py-4 font-semibold">Barang</th>
                                            <th class="px-6 py-4 font-semibold text-right">Total (Est)</th>
                                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                                        <?php else: ?>
                                            <th class="px-6 py-4 font-semibold">Peminjam</th>
                                            <th class="px-6 py-4 font-semibold">Barang</th>
                                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                                            <th class="px-6 py-4 font-semibold">Status</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php $__empty_1 = true; $__currentLoopData = $data['recent_activities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                            <?php if(auth()->user()->isHead()): ?>
                                                
                                                <td class="px-6 py-4">
                                                    <div class="font-bold text-slate-800"><?php echo e($activity->purchase_code); ?></div>
                                                    <div class="text-xs text-slate-500"><?php echo e($activity->created_at->format('d M y')); ?></div>
                                                </td>
                                                <td class="px-6 py-4 text-slate-600">
                                                    <?php echo e($activity->user ? $activity->user->name : '-'); ?>

                                                </td>
                                                <td class="px-6 py-4 font-medium text-indigo-600">
                                                    <?php echo e($activity->tool_name); ?>

                                                    <div class="text-xs text-slate-400 font-normal"><?php echo e($activity->quantity); ?> Unit</div>
                                                </td>
                                                <td class="px-6 py-4 text-right font-bold text-slate-700">
                                                    Rp <?php echo e(number_format($activity->subtotal, 0, ',', '.')); ?>

                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <a href="<?php echo e(route('purchases.request', ['search' => $activity->purchase_code])); ?>" class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded hover:bg-orange-200 transition">
                                                        Review
                                                    </a>
                                                </td>
                                            <?php else: ?>
                                                
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 text-white flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm">
                                                            <?php echo e(substr($activity->borrower->name, 0, 1)); ?>

                                                        </div>
                                                        <div class="font-medium text-slate-900"><?php echo e($activity->borrower->name); ?></div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-slate-600">
                                                    <?php if($activity->items->count() > 0): ?>
                                                        <?php echo e($activity->items->first()->tool->name); ?>

                                                        <?php if($activity->items->count() > 1): ?>
                                                            <span class="text-xs text-slate-400 ml-1">(+<?php echo e($activity->items->count() - 1); ?> lainnya)</span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-slate-400 italic">No Data</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 text-slate-500">
                                                    <?php echo e(\Carbon\Carbon::parse($activity->borrow_date)->format('d M Y')); ?>

                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php if($activity->borrowing_status == 'active'): ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                            Sedang Dipinjam
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            Dikembalikan
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    <p>Tidak ada data baru.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Sidebar (Right 1/3) -->
                <div class="space-y-6">
                    <!-- Quick Menu Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                        <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Menu Cepat
                        </h4>
                        <div class="space-y-3">
                            <?php if(auth()->user()->isHead()): ?>
                                
                                <a href="<?php echo e(route('purchases.request')); ?>" class="w-full group flex items-center p-3 rounded-lg bg-orange-50 hover:bg-orange-100 border border-orange-100 transition-all duration-200 text-left">
                                    <div class="p-2 bg-orange-500 rounded-md shadow-md text-white mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-orange-900 text-sm">Review Pengajuan</div>
                                        <div class="text-xs text-orange-600">Persetujuan pembelian</div>
                                    </div>
                                </a>

                                
                                <a href="<?php echo e(route('purchases.history')); ?>" class="w-full group flex items-center p-3 rounded-lg bg-violet-50 hover:bg-violet-100 border border-violet-100 transition-all duration-200 text-left">
                                    <div class="p-2 bg-violet-500 rounded-md shadow-md text-white mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-violet-900 text-sm">Laporan Pengadaan</div>
                                        <div class="text-xs text-violet-600">Cek budget & realisasi</div>
                                    </div>
                                </a>

                                
                                <a href="<?php echo e(route('borrowings.index')); ?>" class="w-full group flex items-center p-3 rounded-lg bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition-all duration-200 text-left">
                                    <div class="p-2 bg-indigo-500 rounded-md shadow-md text-white mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-indigo-900 text-sm">Laporan Peminjaman</div>
                                        <div class="text-xs text-indigo-600">Riwayat sirkulasi aset</div>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('borrowings.create')); ?>" class="w-full group flex items-center p-3 rounded-lg bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition-all duration-200 text-left">
                                    <div class="p-2 bg-indigo-500 rounded-md shadow-md text-white mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-indigo-900 text-sm">Peminjaman Baru</div>
                                        <div class="text-xs text-indigo-600">Input transaksi cepat</div>
                                    </div>
                                </a>

                                <a href="<?php echo e(route('tools.index')); ?>" class="w-full group flex items-center p-3 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-all duration-200 text-left">
                                    <div class="p-2 bg-white rounded-md shadow-sm text-slate-600 mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700 text-sm">Data Aset</div>
                                        <div class="text-xs text-slate-500">Manajemen inventaris</div>
                                    </div>
                                </a>

                                <a href="<?php echo e(route('users.create')); ?>" class="w-full group flex items-center p-3 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-all duration-200 text-left">
                                    <div class="p-2 bg-white rounded-md shadow-sm text-slate-600 mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700 text-sm">Tambah Pengguna</div>
                                        <div class="text-xs text-slate-500">Registrasi member</div>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

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
<?php endif; ?><?php /**PATH C:\laragon\www\app-inventaris\resources\views/dashboard.blade.php ENDPATH**/ ?>