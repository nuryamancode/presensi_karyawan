<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Dinas Karyawan</title>\
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        thead {
            display: table-header-group;
            text-align: center;
        }

        tbody {
            display: table-row-group;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Laporan Dinas Karyawan</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Dinas</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Foto Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan_dinas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_event }}</td>
                    <td>{{ $item->karyawan->nama_lengkap }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id_ID')->isoFormat('D MMMM Y') }}
                    </td>
                    <td>
                        <img src="{{ asset($item->foto_kunjungan) }}" alt="">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
