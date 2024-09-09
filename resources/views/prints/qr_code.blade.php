<!-- resources/views/prints/qr_code.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>QR Code</title>
    <style>
        @media print {
            .container {
                display: block;
                margin: 0;
                font-family: Arial, sans-serif;
            }
            .sticker {
                display: flex;
                align-items: center;
                border: 5px solid #000;
                padding: 10px;
                background-color: #f9f9f9;
                width: 200mm; /* Width for A4 */
                height: 100mm; /* Height for A4 */
                position: relative;
                box-sizing: border-box;
                page-break-inside: avoid;
            }
            .qr-code {
                margin-right: 10mm;
                margin-left: 10mm;
            }
            .qr-code img {
                width: 40mm; /* Adjust size for print */
                height: 40mm; /* Adjust size for print */
            }
            .details {
                flex: 1;
            }
            .title {
                font-size: 14pt; /* Adjust font size for print */
                font-weight: bold;
                margin-bottom: 5mm;
            }
            .instructions {
                font-size: 10pt; /* Adjust font size for print */
                color: #555;
            }
            .logo {
                position: absolute;
                top: 10px;
                right: 10px;
                width: 40mm; /* Adjust size for print */
            }
        }
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
            border: 5px solid #000;
            padding: 5px;
            background-color: #f9f9f9;
            width: 600px;
            height: 250px;
            position: relative;
        }
        .qr-code {
            margin-right: 20px;
            margin-left: 20px;
        }
        .qr-code img {
            width: 80px;
            height: 80px;
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
            top: -3px;
            right: 10px;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sticker" id="sticker">
            <div class="qr-code">
                {!! $qrCode !!}
            </div>
            <div class="details">
                <div class="title">Global Service Indonesia</div>
                <div class="instructions">
                    Harap tidak melepas, merobek, atau merusak label ini.
                </div>
            </div>
            <img src="{{ asset('assets/img/GSI.png') }}" alt="Global Service Indonesia Logo" class="logo">
        </div>
    </div>
    <script>
        // Trigger print dialog automatically
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
