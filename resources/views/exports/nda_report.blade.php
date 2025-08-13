<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan NDA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #1e3a8a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #e0e7ff;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Proyek NDA</h1>
        <p>Tanggal: {{ now()->format('d F Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Proyek</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Durasi</th>
                <th>Tanggal TTD</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ndas as $nda)
                <tr>
                    <td>{{ str_pad($nda->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $nda->project_name }}</td>
                    <td>{{ $nda->start_date ? $nda->start_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $nda->end_date ? $nda->end_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $nda->formatted_duration }}</td>
                    <td>{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $nda->description ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} NDA Management System. All rights reserved.
    </div>
</body>

</html>
