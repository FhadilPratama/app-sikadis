<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Data Peserta Didik</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #334155;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #1e293b;
            font-size: 18px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
            color: #64748b;
        }

        .meta-info {
            width: 100%;
            margin-bottom: 15px;
        }

        .meta-info td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #475569;
            width: 120px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: left;
        }

        table.data-table th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        table.data-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-male {
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .badge-female {
            background-color: #fdf2f8;
            color: #be185d;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DAFTAR PESERTA DIDIK</h1>
        <p>Tahun Ajar: <strong>{{ $activeTahunAjar->tahun ?? 'Semua' }}</strong></p>
        <p>Dicetak Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table class="meta-info">
        <tr>
            <td class="label">Rombongan Belajar</td>
            <td>: {{ $selectedRombel ? $selectedRombel->nama_rombel : 'Semua Rombel' }}</td>
        </tr>
        <tr>
            <td class="label">Total Siswa</td>
            <td>: {{ $students->count() }} Siswa</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>Nama Lengkap</th>
                <th style="width: 80px;">NIS</th>
                <th style="width: 80px;">NISN</th>
                <th style="width: 60px; text-align: center;">L/P</th>
                <th>Rombel Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $student->nama }}</strong>
                        <br>
                        <span style="font-size: 9px; color: #64748b;">{{ $student->email }}</span>
                    </td>
                    <td>{{ $student->nis }}</td>
                    <td>{{ $student->nisn }}</td>
                    <td style="text-align: center;">
                        <span class="badge {{ $student->jenis_kelamin == 'L' ? 'badge-male' : 'badge-female' }}">
                            {{ $student->jenis_kelamin }}
                        </span>
                    </td>
                    <td>
                        @php 
                            $rombel = $student->anggotaRombel->where('tahun_ajar_id', $activeTahunAjar->id ?? 0)->first();
                        @endphp
                        {{ $rombel ? $rombel->rombonganBelajar->nama_rombel : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                        Tidak ada data siswa ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
       
 Dokumen ini digenerate otomatis oleh Sistem Informasi Akademik Sekolah (SIKADIS).
    </div>
</body>
</html>