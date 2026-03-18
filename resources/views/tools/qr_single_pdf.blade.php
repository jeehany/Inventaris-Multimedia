<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Label QR Asset {{ $tool->tool_code }} - Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
        }
        .label-box {
            border: 1px dashed #ccc;
            padding: 20px;
            text-align: center;
            width: 250px;
            margin: 0 auto;
        }
        .qr-image {
            margin-bottom: 10px;
        }
        .asset-code {
            font-size: 16px;
            font-weight: bold;
            color: #1a202c;
            margin: 0 0 5px 0;
            font-family: monospace;
        }
        .asset-name {
            font-size: 13px;
            color: #4a5568;
            margin: 0;
            text-transform: uppercase;
        }
        .tag-footer {
            font-size: 10px;
            color: #718096;
            margin-top: 10px;
            border-top: 1px dashed #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="label-box">
            <div class="qr-image">
                <img src="data:image/svg+xml;base64,{!! base64_encode(QrCode::size(150)->generate($tool->tool_code)) !!}">
            </div>
            <p class="asset-code">{{ $tool->tool_code }}</p>
            <p class="asset-name">{{ Str::limit($tool->tool_name, 35) }}</p>
            <p class="tag-footer">Inventaris Multimedia</p>
        </div>
    </div>
</body>
</html>
