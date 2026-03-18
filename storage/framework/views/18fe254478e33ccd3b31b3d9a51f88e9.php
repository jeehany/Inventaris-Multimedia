<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Label QR Asset - Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        td {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            width: 33.33%; /* 3 Kolom */
            overflow: hidden;
        }
        /* Page break avoid inside cells */
        td {
            page-break-inside: avoid;
        }
        .qr-image {
            margin-bottom: 10px;
        }
        .asset-code {
            font-size: 14px;
            font-weight: bold;
            color: #1a202c;
            margin: 0 0 5px 0;
            font-family: monospace;
        }
        .asset-name {
            font-size: 11px;
            color: #4a5568;
            margin: 0;
            text-transform: uppercase;
        }
        .tag-footer {
            font-size: 9px;
            color: #718096;
            margin-top: 5px;
            border-top: 1px dashed #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <?php $columnCount = 3; $currentCol = 0; ?>
            <?php $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                
                <?php if($currentCol == 0): ?>
                    <tr>
                <?php endif; ?>
                
                <td>
                    <div class="qr-image">
                        <img src="data:image/svg+xml;base64,<?php echo base64_encode(QrCode::size(120)->generate($tool->tool_code)); ?>">
                    </div>
                    <p class="asset-code"><?php echo e($tool->tool_code); ?></p>
                    <p class="asset-name"><?php echo e(Str::limit($tool->tool_name, 25)); ?></p>
                    <p class="tag-footer">Inventaris Multimedia</p>
                </td>
                
                
                <?php $currentCol++; ?>
                
                
                <?php if($currentCol == $columnCount): ?>
                    </tr>
                    <?php $currentCol = 0; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            
            <?php if($currentCol > 0): ?>
                <?php for($i = $currentCol; $i < $columnCount; $i++): ?>
                    <td></td>
                <?php endfor; ?>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/tools/qr_pdf.blade.php ENDPATH**/ ?>