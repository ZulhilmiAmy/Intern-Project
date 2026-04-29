<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Report Bulanan</title>

    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #ddd;
            padding: 6px;
        }

        td {
            padding: 6px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>

<body>

    <h3>Laporan Tempahan Bilik</h3>
    <div class="sub">
        Hospital Enche' Besar Hajjah Khalsom <br>
        Bulan: {{ date('F', mktime(0,0,0,$month,1)) }} <br>
        Tahun: {{ $year }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Tiket</th>
                <th>Nama</th>
                <th>Tarikh</th>
                <th>Masa</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $b)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $b->ticket_no }}</td>
                <td>{{ $b->nama_penuh }}</td>
                <td>{{ \Carbon\Carbon::parse($b->tarikh_mula)->format('d/m/Y') }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($b->masa_mula)->format('g:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($b->masa_tamat)->format('g:i A') }}
                </td>
                <td>{{ $b->location->location_name ?? '-' }}</td>
                <td>{{ ucfirst($b->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dijana pada:
        {{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('d/m/Y H:i') }}
    </div>

</body>
</html>