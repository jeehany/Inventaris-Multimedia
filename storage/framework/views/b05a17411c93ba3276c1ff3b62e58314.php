<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Riwayat Pengadaan & Analisa Budget</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 11px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 5px; text-align: left; vertical-align: top; }
        th { background-color: #f3f4f6; font-weight: bold; text-align: center; color: #111; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .badge-hemat { color: #059669; font-weight: bold; }
        .badge-over { color: #dc2626; font-weight: bold; }
        .badge-normal { color: #4b5563; }
        
        .footer { margin-top: 30px; width: 100%; }
        .signature-box { float: right; width: 220px; text-align: center; }
        .signature-line { margin-top: 50px; border-bottom: 1px solid #333; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none; margin-bottom: 0;">
            <tr>
                <td style="width: 50px; border: none; text-align: center;">
                    <img src="<?php echo e($logo); ?>" style="height: 50px; width: auto;">
                </td>
                <td style="border: none; text-align: center;">
                    <h1>HM COMPANY</h1>
                    <p>INVENTORY MANAGEMENT SYSTEM</p>
                    <p><strong>LAPORAN RIWAYAT PENGADAAN & ANALISA BUDGET</strong></p>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 15px;">
        <table style="width: 100%; border:none;">
            <tr>
                <td style="border:none; width: 15%;"><strong>Periode Cetak</strong></td>
                <td style="border:none;">: <?php echo e(now()->translatedFormat('d F Y')); ?></td>
                <td style="border:none; width: 15%;"><strong>Oleh</strong></td>
                <td style="border:none;">: <?php echo e(auth()->user()->name); ?></td>
            </tr>
            <tr>
                <td style="border:none;"><strong>Filter Status</strong></td>
                <td style="border:none;">: <?php echo e(request('status') ?: 'Semua (Selesai/Ditolak)'); ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Tgl & Kode</th>
                <th width="20%">Item Details</th>
                <th width="10%">Vendor</th>
                <th width="5%">Qty</th>
                <th width="10%">Biaya Satuan</th>
                <th width="12%">Budget (Rencana)</th>
                <th width="12%">Realisasi (Akhir)</th>
                <th width="15%">Analisa Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $totalBudget = 0; 
                $totalRealization = 0; 
                $totalSavings = 0;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $planTotal = $h->unit_price * $h->quantity;
                
                // Jika rejected, realisasi 0
                if($h->status == 'rejected') {
                    $realTotal = 0;
                    $actualPrice = 0;
                    $diff = 0; 
                } else {
                    $actualPrice = $h->actual_unit_price ?? $h->unit_price;
                    $realTotal = $actualPrice * $h->quantity;
                    $diff = $planTotal - $realTotal; // Positif = Hemat, Negatif = Boros
                }

                // Accumulate only for completed items to make sense? 
                // Or accumulate all? Usually Analysis excludes rejected.
                if($h->status == 'completed' || $h->is_purchased) {
                    $totalBudget += $planTotal;
                    $totalRealization += $realTotal;
                    $totalSavings += $diff;
                }
            ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td>
                    <div style="font-weight:bold;"><?php echo e($h->purchase_code); ?></div>
                    <small><?php echo e(\Carbon\Carbon::parse($h->updated_at)->format('d/m/Y')); ?></small>
                </td>
                <td>
                    <strong><?php echo e($h->tool_name); ?></strong><br>
                    <small style="color:#555;"><?php echo e($h->category->category_name ?? '-'); ?></small>
                </td>
                <td><?php echo e($h->vendor->name ?? '-'); ?></td>
                <td class="text-center"><?php echo e($h->quantity); ?></td>
                <td class="text-right"><?php echo e(number_format($actualPrice, 0, ',', '.')); ?></td>
                
                <td class="text-right" style="background-color: #f9fafb;">
                    Rp <?php echo e(number_format($planTotal, 0, ',', '.')); ?>

                </td>
                
                <td class="text-right">
                    <?php if($h->status == 'rejected'): ?>
                        <span style="color:red; font-style:italic;">Ditolak</span>
                    <?php else: ?>
                        Rp <?php echo e(number_format($realTotal, 0, ',', '.')); ?>

                    <?php endif; ?>
                </td>

                <td class="text-right">
                    <?php if($h->status == 'rejected'): ?>
                        -
                    <?php else: ?>
                        <?php if($diff > 0): ?>
                            <span class="badge-hemat">(+) Hemat <?php echo e(number_format($diff, 0, ',', '.')); ?></span>
                        <?php elseif($diff < 0): ?>
                            <span class="badge-over">(-) Boros <?php echo e(number_format(abs($diff), 0, ',', '.')); ?></span>
                        <?php else: ?>
                            <span class="badge-normal">Sesuai Budget</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="9" class="text-center">Tidak ada data riwayat.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f3f4f6; font-weight: bold;">
                <td colspan="6" class="text-right">TOTAL (Selesai Only)</td>
                <td class="text-right">Rp <?php echo e(number_format($totalBudget, 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($totalRealization, 0, ',', '.')); ?></td>
                <td class="text-right">
                    <?php if($totalSavings > 0): ?>
                        <span style="color:#059669;">Hemat: Rp <?php echo e(number_format($totalSavings, 0, ',', '.')); ?></span>
                    <?php elseif($totalSavings < 0): ?>
                        <span style="color:#dc2626;">Over: Rp <?php echo e(number_format(abs($totalSavings), 0, ',', '.')); ?></span>
                    <?php else: ?>
                        Sesuai
                    <?php endif; ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Pimpinan Bagian Pengadaan</p>
            <div class="signature-line"><?php echo e(auth()->user()->name); ?></div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/purchases/history_pdf.blade.php ENDPATH**/ ?>