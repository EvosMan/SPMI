<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Audit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .section {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>LAPORAN AUDIT MUTU INTERNAL</h2>

    <table>
        <tr>
            <th width="30%">Tahun</th>
            <td>{{ $audit->jadwalAudit->tahun }}</td>
        </tr>
        <tr>
            <th>Tanggal Audit</th>
            <td>{{ $audit->jadwalAudit->tanggal_mulai }} s/d {{ $audit->jadwalAudit->tanggal_selesai }}</td>
        </tr>
        <tr>
            <th>Auditor</th>
            <td>{{ $audit->jadwalAudit->user->name }}</td>
        </tr>
        <tr>
            <th>Keterangan Audit</th>
            <td>{{ $audit->keterangan }}</td>
        </tr>
        <tr>
            <th>Status Audit</th>
            <td>{{ $audit->status }}</td>
        </tr>
        <tr>
            <th>Validasi Kaprodi</th>
            <td>{{ $audit->v_kaprodi }}</td>
        </tr>
        <tr>
            <th>Validasi Staf</th>
            <td>{{ $audit->v_staf }}</td>
        </tr>
        <tr>
            <th>Status Pelaksanaan</th>
            <td>{{ $audit->status_pelaksanaan }}</td>
        </tr>
    </table>

</body>

</html>
