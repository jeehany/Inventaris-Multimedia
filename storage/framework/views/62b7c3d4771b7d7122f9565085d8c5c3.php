<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .meta { margin-bottom: 15px; font-size: 11px; }
        .meta table { border: none; width: 100%; margin: 0; }
        .meta td { border: none; padding: 2px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #e5e7eb; font-weight: bold; text-align: center; color: #1f2937; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer { margin-top: 40px; width: 100%; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-box p { margin: 5px 0; }
        .signature-line { margin-top: 60px; border-bottom: 1px solid #333; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none; margin-bottom: 0;">
            <tr>
                <td style="width: 60px; border: none; text-align: center; vertical-align: middle;">
                    <img src="<?php echo e($logo); ?>" style="height: 60px; width: auto;">
                </td>
                <td style="border: none; text-align: center; vertical-align: middle;">
                    <h1 style="margin: 0; font-size: 18px; text-transform: uppercase;">HM COMPANY</h1>
                    <p style="margin: 2px 0; font-size: 12px;">INVENTORY MANAGEMENT SYSTEM</p>
                    <p style="margin: 2px 0; font-size: 12px;">Laporan Resmi Sistem Informasi Inventaris</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="meta">
        <table style="width: 100%">
            <tr>
                <td style="width: 20%"><strong>Laporan</strong></td>
                <td style="width: 2%">:</td>
                <td>Data Peminjaman Aset (Borrowing)</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td><?php echo e(optional(auth()->user())->name ?? 'Admin'); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?php echo e(now()->translatedFormat('d F Y, H:i')); ?></td>
                <td><strong>Total Record</strong></td>
                <td>:</td>
                <td><?php echo e($borrowings->count()); ?> Data</td>
            </tr>
        </table>
    </div>

    <!-- BLOK RINGKASAN ANALITIK EKSEKUTIF -->
    <div style="background-color: #f8fafc; padding: 12px; border: 1px solid #cbd5e1; margin-bottom: 15px; border-radius: 4px;">
        <h4 style="margin-top: 0; margin-bottom: 8px; color: #1e293b; font-size: 13px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;">Ringkasan Keputusan Analitik (Executive Summary)</h4>
        <table style="border: none; margin: 0; width: 100%; font-size: 10px;">
            <tr>
                <td style="border: none; vertical-align: top; width: 33%; padding: 4px;">
                    <strong>Total Transaksi:</strong> <span style="color: #4338ca;"><?php echo e($borrowings->count()); ?> Peminjaman</span><br>
                    <strong>Sedang Dipinjam:</strong> <span style="color: #047857;"><?php echo e($borrowings->where('borrowing_status', 'active')->count()); ?> Transaksi Berjalan</span>
                </td>
                <td style="border: none; vertical-align: top; width: 33%; padding: 4px;">
                    <strong>Telah Kembali:</strong> <?php echo e($borrowings->where('borrowing_status', 'returned')->count()); ?> Transaksi Selesai<br>
                    <strong>Pengembalian Rusak/Cacat:</strong> <span style="color: #dc2626;"><?php echo e($borrowings->where('borrowing_status', 'returned')->where('return_condition', '!=', 'Baik')->count()); ?> Kasus Ditemukan</span>
                </td>
                <td style="border: none; vertical-align: top; width: 33%; padding: 4px;">
                    <strong>Total Aset Beredar:</strong> <?php echo e($borrowings->where('borrowing_status', 'active')->sum(function($b) { return $b->items->count(); })); ?> Unit<br>
                    <strong>Rata-rata Durasi Pinjam:</strong> 
                    <?php
                        $returned = $borrowings->where('borrowing_status', 'returned')->whereNotNull('actual_return_date');
                        $avgDuration = $returned->count() > 0 ? round($returned->avg(function($b) {
                            return \Carbon\Carbon::parse($b->borrow_date)->diffInDays(\Carbon\Carbon::parse($b->actual_return_date));
                        })) : 0;
                    ?>
                    <?php echo e($avgDuration); ?> Hari
                </td>
            </tr>
        </table>
    </div>
    <!-- END BLOK ANALITIK -->

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Pinjam</th>
                <th width="20%">Peminjam</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Rencana Kembali</th>
                <th width="20%">Aset</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $borrowings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td class="text-center"><?php echo e($b->borrowing_code ?? '-'); ?></td>
                <td>
                    <strong><?php echo e($b->borrower->name ?? 'Umum'); ?></strong><br>
                    <small><?php echo e($b->borrower->department ?? '-'); ?></small>
                </td>
                <td class="text-center"><?php echo e(\Carbon\Carbon::parse($b->borrow_date)->translatedFormat('d M Y')); ?></td>
                <td class="text-center"><?php echo e($b->planned_return_date ? \Carbon\Carbon::parse($b->planned_return_date)->translatedFormat('d M Y') : '-'); ?></td>
                <td>
                   <ul style="margin: 0; padding-left: 15px;">
                       <?php $__currentLoopData = $b->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($item->tool->tool_name ?? '?'); ?></li>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </ul>
                </td>
                <td>
                    <?php if($b->borrowing_status == 'active'): ?>
                        <span class="status-badge status-active">Dipinjam</span>
                    <?php elseif($b->borrowing_status == 'pending_head'): ?>
                        <span class="status-badge" style="background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe;">Menunggu</span>
                    <?php elseif($b->borrowing_status == 'rejected_head'): ?>
                        <span class="status-badge" style="background-color: #ffe4e6; color: #9f1239; border: 1px solid #fecdd3;">Ditolak</span>
                    <?php else: ?>
                        <span class="status-badge status-returned">Kembali</span><br>
                        <span class="status-sub"><?php echo e($b->final_status); ?><br>(<?php echo e($b->return_condition); ?>)</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data peminjaman.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Manajemen Inventaris</p>
            <div class="signature-line"><?php echo e(optional(auth()->user())->name ?? '(..........................)'); ?></div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/borrowings/pdf.blade.php ENDPATH**/ ?>