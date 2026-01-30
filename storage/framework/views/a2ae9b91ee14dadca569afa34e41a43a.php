<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Aset Inventaris</title>
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
                    <?php $logoPath = public_path('images/logo.png'); ?>
                    <?php if(file_exists($logoPath)): ?>
                        <img src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents($logoPath))); ?>" style="height: 60px; width: auto;">
                    <?php else: ?>
                       <span style="font-weight:bold; font-size:12px;">LOGO</span>
                    <?php endif; ?>
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
                <td style="width: 15%"><strong>Laporan</strong></td>
                <td style="width: 2%">:</td>
                <td>Data Aset (Inventaris)</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td><?php echo e(optional(auth()->user())->name ?? 'Admin'); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?php echo e(now()->translatedFormat('d F Y, H:i')); ?></td>
                <td><strong>Filter</strong></td>
                <td>:</td>
                <td><?php echo e(request('category_id') ? 'Kategori Tertentu' : 'Semua Kategori'); ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Aset</th>
                <th width="25%">Nama Barang & Merk</th>
                <th width="15%">Kategori</th>
                <th width="15%">Tanggal Beli</th>
                <th width="10%">Kondisi</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td class="text-center"><?php echo e($tool->tool_code); ?></td>
                <td>
                    <strong><?php echo e($tool->tool_name); ?></strong><br>
                    <small><?php echo e($tool->brand ?? '-'); ?></small>
                </td>
                <td class="text-center"><?php echo e($tool->category->category_name ?? '-'); ?></td>
                <td class="text-center"><?php echo e($tool->purchase_date ? \Carbon\Carbon::parse($tool->purchase_date)->translatedFormat('d/m/Y') : '-'); ?></td>
                <td class="text-center"><?php echo e($tool->current_condition); ?></td>
                <td class="text-center">
                    <?php if($tool->availability_status == 'available'): ?> Tersedia
                    <?php elseif($tool->availability_status == 'borrowed'): ?> Dipinjam
                    <?php elseif($tool->availability_status == 'maintenance'): ?> Perbaikan
                    <?php elseif($tool->availability_status == 'disposed'): ?> Dihapus
                    <?php else: ?> <?php echo e($tool->availability_status); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data aset.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Manajemen Inventaris</p>
            <div class="signature-line"><?php echo e(auth()->user()->name ?? '(..........................)'); ?></div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/tools/pdf.blade.php ENDPATH**/ ?>