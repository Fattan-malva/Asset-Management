<!-- resources/views/prints/qr_code.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>QR Code</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .qr-code {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="qr-code">
            {!! $qrCode !!}
        </div>
        <div class="details">
            <p><strong>Assets Tag:</strong> {{ $inventory->tagging }}</p>
            <p><strong>Assets Name:</strong> {{ $inventory->asets }}</p>
            <p><strong>Merk:</strong> {{ $inventory->merk_name }}</p>
            <p><strong>Serial Number:</strong> {{ $inventory->seri }}</p>
            <p><strong>Type:</strong> {{ $inventory->type }}</p>
        </div>
    </div>
</body>
</html>
