<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Evaluasi</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        .info {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <h2>LAPORAN EVALUASI</h2>
    <div class="info">
        <p><strong>Aspek</strong>: {{ $evaluasi->aspek ?? '-' }}</p>

    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Subaspek</th>
                <th>Jawaban Evaluasi</th>
                <th>Nama Dokumen</th>
                <th>Keterangan Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluasi->detailEvaluasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="text-align: left">{{ $item->sub_aspek }}</td>
                <td>{{ $item->hasilEvaluasi->jawaban }}</td>
                <td style="text-align: left">{{ $item->hasilEvaluasi->nama_dokumen ?? '-' }}</td>
                <td style="text-align: left">{{ $item->hasilEvaluasi->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>