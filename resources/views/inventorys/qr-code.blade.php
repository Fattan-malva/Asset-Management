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
        .sticker {
            display: flex;
            align-items: center;
            border: 1px solid #000;
            padding: 20px;
            background-color: #f9f9f9;
            width: 600px;
            height: 300px;
            position: relative;
        }
        .qr-code {
            margin-right: 20px;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
        }
        .details {
            flex: 1;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .instructions {
            font-size: 16px;
            color: #555;
        }
        .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sticker">
            <div class="qr-code">
                {!! $qrCode !!}
            </div>
            <div class="details">
                <div class="title">Global Service Indonesia</div>
                <div class="instructions">
                    Harap tidak melepas, merobek, atau merusak label ini.
                </div>
            </div>
            <img src="{{ asset('img/GSI.png') }}" alt="Global Service Indonesia Logo" class="logo">
        </div>
    </div>
</body>
</html>
