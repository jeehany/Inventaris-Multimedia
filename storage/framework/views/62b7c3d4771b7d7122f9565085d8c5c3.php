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

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Pinjam</th>
                <th width="20%">Peminjam</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Rencana Kembali</th>
                <th width="20%">Item</th>
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
                <td class="text-center">
                    <?php if($b->borrowing_status == 'active'): ?> <span style="color: blue;">Dipinjam</span>
                    <?php elseif($b->borrowing_status == 'returned'): ?> <span style="color: green;">Kembali</span>
                    <?php elseif($b->borrowing_status == 'overdue'): ?> <span style="color: red;">Terlambat</span>
                    <?php else: ?> <?php echo e($b->borrowing_status); ?>

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
            <p>Admin Peminjaman</p>
            <div class="signature-line"><?php echo e(optional(auth()->user())->name ?? '(..........................)'); ?></div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/borrowings/pdf.blade.php ENDPATH**/ ?>