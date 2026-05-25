<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pemeliharaan Aset</title>
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

        .status-badge { font-weight: bold; font-size: 10px; padding: 2px 5px; border-radius: 4px; display: inline-block; }
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
                <td style="width: 20%"><strong>Laporan</strong></td>
                <td style="width: 2%">:</td>
                <td>Pemeliharaan & Perbaikan Aset (Maintenance)</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td><?php echo e(optional(auth()->user())->name ?? 'Admin'); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?php echo e(now()->translatedFormat('d F Y, H:i')); ?></td>
                <td><strong>Filter Status</strong></td>
                <td>:</td>
                <td><?php echo e(request('status') ? (request('status')=='completed'?'Selesai':'Sedang Proses') : 'Semua Status'); ?></td>
            </tr>
        </table>
    </div>

    <!-- BLOK RINGKASAN ANALITIK EKSEKUTIF -->
    <div style="background-color: #fffbeb; padding: 12px; border: 1px solid #fde68a; margin-bottom: 15px; border-radius: 4px;">
        <h4 style="margin-top: 0; margin-bottom: 8px; color: #92400e; font-size: 13px; border-bottom: 1px solid #fde68a; padding-bottom: 4px;">Ringkasan Keputusan Analitik (Executive Summary)</h4>
        <table style="border: none; margin: 0; width: 100%; font-size: 10px;">
            <tr>
                <td style="border: none; vertical-align: top; width: 33%; padding: 4px;">
                    <strong>Total Kasus Servis:</strong> <span style="color: #b45309;"><?php echo e($maintenances->count()); ?> Permintaan</span><br>
                    <strong>Tuntas (Selesai):</strong> <span style="color: #047857;"><?php echo e($maintenances->where('status', 'completed')->count()); ?> Kasus</span>
                </td>
                <td style="border: none; vertical-align: top; width: 33%; padding: 4px;">
                    <strong>Total Biaya (RAB):</strong> <span style="color: #b45309;">Rp <?php echo e(number_format($maintenances->sum('cost'), 0, ',', '.')); ?></span><br>
                    <strong>Rata-rata Biaya per Servis:</strong> Rp <?php echo e($maintenances->count() > 0 ? number_format($maintenances->sum('cost') / $maintenances->count(), 0, ',', '.') : 0); ?>

                </td>
                <td style="border: none; vertical-align: top; width: 33%; padding: 4px;">
                    <strong>Keluhan Terbanyak:</strong> <?php echo e($maintenances->groupBy('type_id')->sortByDesc(function($item) { return $item->count(); })->first()?->first()?->type->name ?? '-'); ?><br>
                    <strong>Aset Paling Sering Diservis:</strong> <?php echo e($maintenances->groupBy('tool_id')->sortByDesc(function($item) { return $item->count(); })->first()?->first()?->tool->tool_name ?? '-'); ?>

                </td>
            </tr>
        </table>
    </div>
    <!-- END BLOK ANALITIK -->

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Aset</th>
                <th width="15%">Jenis Pemeliharaan</th>
                <th width="20%">Keluhan</th>
                <th width="15%">Tindakan & Biaya</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $maintenances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td class="text-center">
                    <?php echo e(\Carbon\Carbon::parse($mt->start_date)->translatedFormat('d M Y')); ?>

                    <?php if($mt->end_date): ?>
                    <br><small>s/d <?php echo e(\Carbon\Carbon::parse($mt->end_date)->format('d M y')); ?></small>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?php echo e($mt->tool->tool_name ?? 'Item Terhapus'); ?></strong><br>
                    <small><?php echo e($mt->tool->tool_code ?? '-'); ?></small>
                </td>
                <td class="text-center"><?php echo e($mt->type->name ?? '-'); ?></td>
                <td><?php echo e($mt->note); ?></td>
                <td>
                    <?php echo e($mt->action_taken ?? '-'); ?><br>
                    <?php if($mt->cost > 0): ?>
                    <strong style="color: #047857;">Rp <?php echo e(number_format($mt->cost, 0, ',', '.')); ?></strong>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if($mt->status == 'completed'): ?>
                        <span style="color: green;">SELESAI</span>
                    <?php else: ?>
                        <span style="color: orange;">PROSES</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pemeliharaan.</td>
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
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/maintenances/pdf.blade.php ENDPATH**/ ?>