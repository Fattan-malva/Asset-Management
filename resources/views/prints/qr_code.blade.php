<!-- resources/views/prints/qr_code.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>QR Code</title>
    <style>
        /* Style for the QR code container */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .qr-code {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="qr-code">
            {!! $qrCode !!}
        </div>
    </div>
    <script>
        // Automatically print the page when loaded
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
