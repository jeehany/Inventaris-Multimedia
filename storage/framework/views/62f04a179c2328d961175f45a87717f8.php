<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Pengadaan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 25px; }
        .logo-container { width: 100%; text-align: center; margin-bottom: 10px; }
        .logo-container img { max-height: 70px; }
        .title { font-size: 16px; font-weight: bold; margin: 10px 0 5px; text-transform: uppercase; text-decoration: underline; }
        .subtitle { font-size: 12px; margin-bottom: 20px; text-align: center; }
        .content { margin-bottom: 30px; }
        .user-info p { margin: 3px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #333; padding: 8px; text-align: left; }
        .table th { background-color: #f4f4f4; text-align: center; }
        .qr-section { margin-top: 40px; text-align: right; }
        .qr-container { display: inline-block; text-align: center; border: 1px dashed #ccc; padding: 10px; }
        .qr-container img { width: 80px; height: 80px; }
        .qr-note { font-size: 10px; color: #666; margin-top: 5px; }
        .grand-total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <?php if($logo): ?>
            <div class="logo-container">
                <img src="<?php echo e($logo); ?>" alt="Logo Instansi">
            </div>
        <?php else: ?>
            <h2>DIVISI MULTIMEDIA & INVENTARIS</h2>
        <?php endif; ?>
        <div class="title">Surat Perintah Pengadaan Aset</div>
        <div class="subtitle">Nomor Pendaftaran: <?php echo e($purchase->purchase_code); ?></div>
    </div>

    <div class="content">
        <p>Berdasarkan pengajuan per tanggal <strong><?php echo e(\Carbon\Carbon::parse($purchase->date)->format('d F Y')); ?></strong>, maka dengan ini Kepala Divisi secara sah memberi perintah kepada Staf di bawah ini:</p>
        
        <div class="user-info">
            <p><strong>Nama Staf Pelaksana :</strong> <?php echo e($purchase->user->name); ?></p>
            <p><strong>Jabatan / Peran :</strong> <?php echo e(strtoupper($purchase->user->role)); ?></p>
            <p><strong>Email :</strong> <?php echo e($purchase->user->email); ?></p>
        </div>

        <p>Untuk melaksanakan pembelian fisik dan berhak atas pencairan dana pada sistem pelaporan keuangan (Bendahara) terkait rincian inventaris berikut:</p>

        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama & Kategori Aset</th>
                    <th width="10%">Qty</th>
                    <th width="20%">Estimasi Harga Satuan</th>
                    <th width="30%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="text-align: center"><?php echo e($index + 1); ?></td>
                    <td>
                        <strong><?php echo e($item->tool_name); ?></strong><br>
                        <span style="font-size: 10px"><?php echo e($item->category->category_name ?? '-'); ?> (<?php echo e($item->specification); ?>)</span>
                    </td>
                    <td style="text-align: center"><?php echo e($item->quantity); ?></td>
                    <td style="text-align: right">Rp <?php echo e(number_format($item->unit_price, 0, ',', '.')); ?></td>
                    <td style="text-align: right">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="4" class="grand-total">GRAND TOTAL ESTIMASI</td>
                    <td style="text-align: right; font-weight: bold; color: #4338ca;">
                        Rp <?php echo e(number_format($purchase->total_amount, 0, ',', '.')); ?>

                    </td>
                </tr>
            </tbody>
        </table>

        <p>Surat ini menjadi landasan absoh agar pencairan uang oleh Bendahara dijalankan kepada Staf terkait secara manual/langsung. Usai barang terbeli atau diserah-terimakan, Staf yang ditugaskan <strong>wajib</strong> mengunggah nota asli kwitansi beserta menginput nominal riil pembelian ke dalam Sistem Inventarisasi Multimedia paling lambat 1x24 jam.</p>
    </div>

    <div class="qr-section">
        <div style="margin-bottom: 5px; font-weight: bold;">Telah Diotorisasi & Disetujui Otomatis Secara Elektronik oleh:</div>
        <div style="margin-bottom: 10px;">Kepala Divisi Multimedia</div>
        <div class="qr-container">
            <img src="<?php echo e($qrUrl); ?>" alt="QR Code Otorisasi">
            <div class="qr-note">
                VALID SYSTEM TICKET<br>
                Status: <?php echo e(strtoupper($purchase->status)); ?>

            </div>
        </div>
        <div style="font-size: 11px; margin-top: 10px;">
            Terbit: <?php echo e(now()->format('d/m/Y H:i:s')); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/purchases/surat_perintah_pdf.blade.php ENDPATH**/ ?>