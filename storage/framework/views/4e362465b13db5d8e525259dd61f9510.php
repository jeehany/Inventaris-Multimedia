<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pengajuan Pengadaan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
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
                    <img src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path('images/logo.png')))); ?>" style="height: 60px; width: auto;">
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
                <td>Pengajuan Pengadaan Barang (Requests)</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td><?php echo e(optional(auth()->user())->name ?? 'Admin'); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?php echo e(now()->translatedFormat('d F Y, H:i')); ?></td>
                <td><strong>Filter Vendor</strong></td>
                <td>:</td>
                <td><?php echo e(request('vendor_id') ? 'Vendor Tertentu' : 'Semua Vendor'); ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Kode</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Barang & Spec</th>
                <th width="10%">Vendor</th>
                <th width="8%">Qty</th>
                <th width="12%">Harga Satuan</th>
                <th width="12%">Total Estimasi</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td class="text-center"><?php echo e($req->purchase_code); ?></td>
                <td class="text-center"><?php echo e(\Carbon\Carbon::parse($req->date)->translatedFormat('d M Y')); ?></td>
                <td>
                    <strong><?php echo e($req->tool_name); ?></strong><br>
                    <small style="color:#666;"><?php echo e($req->specification ?? '-'); ?></small>
                </td>
                <td class="text-center"><?php echo e($req->vendor->name ?? '-'); ?></td>
                <td class="text-center"><?php echo e($req->quantity); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($req->unit_price, 0, ',', '.')); ?></td>
                <td class="text-right"><strong>Rp <?php echo e(number_format($req->subtotal, 0, ',', '.')); ?></strong></td>
                <td class="text-center">
                    <?php if($req->status == 'pending'): ?> <span style="color:#d97706; font-weight:bold;">PENDING</span>
                    <?php elseif($req->status == 'approved'): ?> <span style="color:#059669; font-weight:bold;">APPROVED</span>
                    <?php elseif($req->status == 'rejected'): ?> <span style="color:#dc2626; font-weight:bold;">REJECTED</span>
                    <?php else: ?> <?php echo e($req->status); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="9" class="text-center">Tidak ada data pengajuan.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Jurusan</p>
            <div class="signature-line"><?php echo e(auth()->user()->name ?? '(..........................)'); ?></div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/purchases/requests_pdf.blade.php ENDPATH**/ ?>