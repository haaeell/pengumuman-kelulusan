<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Kelulusan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #111827;
            line-height: 1.6;
            margin: 0;
            padding: 0 20px;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #4b5563;
        }

        .divider {
            border-bottom: 3px solid #111827;
            width: 60px;
            margin: 8px auto 0;
        }

        /* ===== BOX ===== */
        .box {
            border-radius: 12px;
            padding: 20px;
            border: 2px solid {{ $student->is_eligible ? '#16a34a' : '#dc2626' }};
            background-color: #f9fafb;
        }

        /* ===== STATUS ===== */
        .status {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff;
            background-color: {{ $student->is_eligible ? '#16a34a' : '#dc2626' }};
            padding: 10px 0;
            border-radius: 8px;
            margin-top: 16px;
        }

        .status i {
            margin-right: 6px;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        td {
            padding: 8px 6px;
            font-size: 13px;
        }

        td.label {
            width: 40%;
            color: #6b7280;
            font-weight: 500;
        }

        td.value {
            font-weight: 600;
            color: #111827;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
        }

        .footer strong {
            color: #111827;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h1>PENGUMUMAN KELULUSAN SISWA</h1>
        <p>Tahun Ajaran {{ date('Y') }}</p>
        <div class="divider"></div>
    </div>

    <!-- CONTENT -->
    <div class="box">
        <table>
            <tr>
                <td class="label">Nomor Induk Siswa (NIS)</td>
                <td class="value">{{ $student->nis }}</td>
            </tr>
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="value">{{ $student->nama }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="value">{{ $student->kelas }}</td>
            </tr>
            <tr>
                <td class="label">Nilai Akhir</td>
                <td class="value">{{ $student->final_score }}</td>
            </tr>
        </table>

        <div class="status">
            <i class="bi {{ $student->is_eligible ? 'bi-check-lg' : 'bi-x-lg' }}"></i>
            {{ $student->is_eligible ? 'ELIGIBLE (LULUS)' : 'TIDAK ELIGIBLE' }}
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Keputusan ini bersifat <strong>final</strong> dan tidak dapat diganggu gugat.</p>
        <p>Dicetak pada {{ now()->format('d F Y H:i') }}</p>
    </div>

</body>

</html>
