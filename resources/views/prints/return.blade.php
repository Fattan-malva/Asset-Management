<!DOCTYPE html>
<html>
<head>
    <title>Print Return</title>
    <style>
        /* Add some basic styles for printing */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Return Report</h1>
    <table>
        <thead>
            <tr>
                <th>Asset Tagging</th>
                <th>Merk</th>
                <th>Jenis Aset</th>
                <th>Old Holder</th>
                <th>New Holder</th>
                <th>Changed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($history as $item)
                <tr>
                    <td>{{ $item->asset_tagging }}</td>
                    <td>{{ $item->merk }}</td>
                    <td>{{ $item->jenis_aset_old }}</td>
                    <td>{{ $item->nama_old }}</td>
                    <td>{{ $item->nama_new }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->changed_at)->format('d-m-Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
