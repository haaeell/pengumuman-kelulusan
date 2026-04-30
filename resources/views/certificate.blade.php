<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Keterangan Kelulusan — {{ $student->nama }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "DejaVu Serif", "Times New Roman", serif;
            font-size: 11pt;
            color: #1c1c2e;
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            position: relative;
            overflow: hidden;
        }

        /* ══ BORDER FRAME ══ */
        .frame-outer {
            position: absolute;
            top: 7mm;
            left: 7mm;
            right: 7mm;
            bottom: 7mm;
            border: 4px solid #1a3668;
        }

        .frame-inner {
            position: absolute;
            top: 10.5mm;
            left: 10.5mm;
            right: 10.5mm;
            bottom: 10.5mm;
            border: 1px solid #b8922a;
        }

        /* ══ CORNER ACCENTS ══ */
        .corner {
            position: absolute;
            width: 18mm;
            height: 18mm;
        }

        .corner-tl {
            top: 6mm;
            left: 6mm;
            border-top: 5px solid #b8922a;
            border-left: 5px solid #b8922a;
        }

        .corner-tr {
            top: 6mm;
            right: 6mm;
            border-top: 5px solid #b8922a;
            border-right: 5px solid #b8922a;
        }

        .corner-bl {
            bottom: 6mm;
            left: 6mm;
            border-bottom: 5px solid #b8922a;
            border-left: 5px solid #b8922a;
        }

        .corner-br {
            bottom: 6mm;
            right: 6mm;
            border-bottom: 5px solid #b8922a;
            border-right: 5px solid #b8922a;
        }

        /* ══ WATERMARK ══ */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -30mm;
            margin-left: -55mm;
            z-index: 0;
            opacity: 0.04;
        }

        .wm-text {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 80pt;
            font-weight: bold;
            color: #1a3668;
            text-transform: uppercase;
            letter-spacing: 6px;
            transform: rotate(-30deg);
            display: block;
        }

        /* ══ PAGE CONTENT ══ */
        .page {
            position: relative;
            z-index: 1;
            padding: 17mm 22mm 14mm;
        }

        /* ══════════════════════
           KOP SURAT
        ══════════════════════ */
        .kop {
            border-bottom: 3px double #1a3668;
            padding-bottom: 10px;
            margin-bottom: 0;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo-cell {
            width: 22mm;
            vertical-align: middle;
        }

        .kop-logo-cell img {
            width: 20mm;
            height: 20mm;
            border-radius: 3px;
        }

        .kop-center-cell {
            vertical-align: middle;
            text-align: center;
            padding: 0 8px;
        }

        .kop-instansi {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 7.5pt;
            color: #777;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .kop-nama-sekolah {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 17pt;
            font-weight: bold;
            color: #1a3668;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .kop-alamat {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 8pt;
            color: #555;
            margin-top: 3px;
            line-height: 1.55;
        }

        .kop-akreditasi-cell {
            width: 22mm;
            vertical-align: middle;
            text-align: right;
        }

        .akr-box {
            display: inline-block;
            width: 18mm;
            height: 18mm;
            border: 2px solid #b8922a;
            text-align: center;
            padding-top: 2mm;
        }

        .akr-grade {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 20pt;
            font-weight: bold;
            color: #b8922a;
            line-height: 1;
        }

        .akr-label {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 6pt;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ══════════════════════
           JUDUL
        ══════════════════════ */
        .judul-section {
            text-align: center;
            padding: 13px 0 4px;
        }

        .judul-text {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 14pt;
            font-weight: bold;
            color: #1a3668;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .nomor-text {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 9pt;
            color: #888;
            margin-top: 4px;
        }

        /* Ornamen garis */
        .ornamen {
            text-align: center;
            margin: 8px 0 15px;
        }

        .orn-line {
            display: inline-block;
            width: 48mm;
            height: 1.5px;
            background: #b8922a;
            vertical-align: middle;
        }

        .orn-diamond {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #b8922a;
            transform: rotate(45deg);
            vertical-align: middle;
            margin: 0 6px;
        }

        .orn-dot {
            display: inline-block;
            width: 4px;
            height: 4px;
            background: #b8922a;
            border-radius: 50%;
            vertical-align: middle;
            margin: 0 4px;
        }

        /* ══════════════════════
           BADAN TEKS
        ══════════════════════ */
        .pembuka {
            font-size: 10.5pt;
            line-height: 2;
            text-align: justify;
            margin-bottom: 8px;
        }

        /* Data Siswa */
        .data-tbl {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 12px 10mm;
        }

        .data-tbl td {
            font-size: 10.5pt;
            padding: 2.5px 0;
            vertical-align: top;
        }

        .data-tbl .dk {
            width: 44mm;
            color: #444;
        }

        .data-tbl .ds {
            width: 8mm;
            color: #444;
        }

        .data-tbl .dv {
            font-weight: bold;
            color: #0d1e3d;
        }

        /* ══════════════════════
           TABEL NILAI
        ══════════════════════ */
        .nilai-wrap {
            margin: 8px 0 10px;
        }

        .nilai-header {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 8pt;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #1a3668;
            border-left: 3px solid #b8922a;
            padding-left: 7px;
            margin-bottom: 7px;
        }

        .nilai-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .nilai-tbl thead td {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 8.5pt;
            font-weight: bold;
            color: #ffffff;
            background: #1a3668;
            text-align: center;
            padding: 7px 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #1a3668;
        }

        .nilai-tbl tbody td {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 16pt;
            font-weight: bold;
            color: #1a3668;
            text-align: center;
            padding: 10px 8px;
            background: #fdfbf3;
            border: 1px solid #e8d9a0;
        }

        .nilai-tbl tbody td .sub-lbl {
            display: block;
            font-size: 7pt;
            font-weight: normal;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* ══════════════════════
           STATUS BADGE
        ══════════════════════ */
        .status-wrap {
            text-align: center;
            margin: 10px 0 8px;
        }

        .status-outer {
            display: inline-block;
            border: 2px solid #b8922a;
            padding: 2px;
        }

        .status-inner {
            background: #1a3668;
            padding: 9px 42px;
        }

        .status-declared {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 8.5pt;
            color: #9ab0cc;
            letter-spacing: 3px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }

        .status-main {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 21pt;
            font-weight: bold;
            color: #f5c842;
            letter-spacing: 8px;
            text-transform: uppercase;
            display: block;
            line-height: 1;
        }

        /* ══════════════════════
           PENUTUP
        ══════════════════════ */
        .penutup {
            font-size: 10.5pt;
            line-height: 1.95;
            text-align: justify;
            margin-top: 8px;
        }

        /* ══════════════════════
           TANDA TANGAN
        ══════════════════════ */
        .ttd-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        .ttd-left {
            width: 50%;
            vertical-align: top;
        }

        .ttd-right {
            vertical-align: top;
            text-align: center;
        }

        .ttd-kota {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 10pt;
        }

        .ttd-jabatan {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 10.5pt;
            font-weight: bold;
            color: #1a3668;
            margin-top: 2px;
            margin-bottom: 50px;
        }

        .stempel-circle {
            width: 28mm;
            height: 28mm;
            border: 1.5px dashed #ccc;
            border-radius: 50%;
            margin: 0 auto 3px;
            text-align: center;
            padding-top: 10mm;
        }

        .stempel-label {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 7pt;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ttd-garis {
            width: 52mm;
            border-top: 1.5px solid #1c1c2e;
            margin: 0 auto 4px;
        }

        .ttd-nama-kepsek {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 10.5pt;
            font-weight: bold;
            color: #1a3668;
        }

        .ttd-nip {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 8.5pt;
            color: #777;
            margin-top: 2px;
        }

        /* ══════════════════════
           FOOTER DOKUMEN
        ══════════════════════ */
        .doc-footer {
            margin-top: 14px;
            border-top: 1px solid #e0e0e0;
            padding-top: 7px;
        }

        .footer-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-info {
            vertical-align: middle;
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 7.5pt;
            color: #aaa;
            line-height: 1.6;
        }

        .footer-code-cell {
            vertical-align: middle;
            text-align: right;
        }

        .code-box {
            display: inline-block;
            border: 1px solid #e8e8e8;
            padding: 4px 10px;
            text-align: center;
        }

        .code-lbl {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 6.5pt;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .code-val {
            font-family: "DejaVu Mono", "Courier New", monospace;
            font-size: 9pt;
            font-weight: bold;
            color: #1a3668;
            letter-spacing: 2px;
        }
    </style>
</head>

<body>

    {{-- Frame --}}
    <div class="frame-outer"></div>
    <div class="frame-inner"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    {{-- Watermark --}}
    <div class="watermark">
        <span class="wm-text">LULUS</span>
    </div>

    <div class="page">

        {{-- KOP --}}
        <div class="kop">
            <table class="kop-table">
                <tr>
                    <td class="kop-logo-cell">
                        <img src="https://yt3.googleusercontent.com/aqwnd_6PPBpG0PqWP1QMcBjJZX0GwVYQCmJ0_r0pdJPrAgiqjH3TaxhHCF9a-oHRbhk90Bpz=s900-c-k-c0x00ffffff-no-rj"
                            alt="Logo Sekolah">
                    </td>
                    <td class="kop-center-cell">
                        <div class="kop-instansi">Pemerintah Kabupaten Contoh &bull; Dinas Pendidikan dan Kebudayaan
                        </div>
                        <div class="kop-nama-sekolah">SMA Negeri 1 Contoh</div>
                        <div class="kop-alamat">
                            Jl. Pendidikan No. 1, Kec. Contoh, Kab. Contoh, Jawa Tengah 12345<br>
                            Telp. (021) 123-4567 &nbsp;&bull;&nbsp; Email: info@sman1contoh.sch.id &nbsp;&bull;&nbsp;
                            NPSN: 12345678
                        </div>
                    </td>
                    <td class="kop-akreditasi-cell">
                        <div class="akr-box">
                            <div class="akr-grade">A</div>
                            <div class="akr-label">Akreditasi</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- JUDUL --}}
        <div class="judul-section">
            <div class="judul-text">Surat Keterangan Kelulusan</div>
            <div class="nomor-text">
                Nomor: 422/{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}/SKL/{{ $year }}
            </div>
        </div>
        <div class="ornamen">
            <span class="orn-dot"></span>
            <span class="orn-line"></span>
            <span class="orn-diamond"></span>
            <span class="orn-line"></span>
            <span class="orn-dot"></span>
        </div>

        {{-- PEMBUKA --}}
        <p class="pembuka">
            Yang bertanda tangan di bawah ini, Kepala SMA Negeri 1 Contoh, Kabupaten Contoh,
            Provinsi Jawa Tengah, dengan ini menerangkan bahwa siswa yang tersebut di bawah ini:
        </p>

        {{-- DATA SISWA --}}
        <table class="data-tbl">
            <tr>
                <td class="dk">Nama Lengkap</td>
                <td class="ds">:</td>
                <td class="dv">{{ strtoupper($student->nama) }}</td>
            </tr>
            <tr>
                <td class="dk">Nomor Induk Siswa (NIS)</td>
                <td class="ds">:</td>
                <td class="dv">{{ $student->nis }}</td>
            </tr>
            <tr>
                <td class="dk">Kelas</td>
                <td class="ds">:</td>
                <td class="dv">{{ $student->kelas }}</td>
            </tr>
            <tr>
                <td class="dk">Tahun Pelajaran</td>
                <td class="ds">:</td>
                <td class="dv">{{ $school_year }}</td>
            </tr>
        </table>

        {{-- NILAI --}}
        <div class="nilai-wrap">
            <div class="nilai-header">Rekapitulasi Nilai Akhir</div>
            <table class="nilai-tbl">
                <thead>
                    <tr>
                        <td>Total Nilai</td>
                        <td>Rata-rata Nilai</td>
                        <td>Peringkat</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $student->total_score }}
                            <span class="sub-lbl">Akumulasi Seluruh Mapel</span>
                        </td>
                        <td>
                            {{ number_format($student->average_score, 2) }}
                            <span class="sub-lbl">Nilai Rata-rata Akhir</span>
                        </td>
                        <td>
                            #{{ $student->ranking }}
                            <span class="sub-lbl">Di Angkatan Ini</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- STATUS --}}
        <div class="status-wrap">
            <div class="status-outer">
                <div class="status-inner">
                    <span class="status-declared">Dinyatakan</span>
                    <span class="status-main">L U L U S</span>
                </div>
            </div>
        </div>

        {{-- PENUTUP --}}
        <p class="penutup">
            dari Satuan Pendidikan <strong>SMA Negeri 1 Contoh</strong> pada Tahun Pelajaran
            <strong>{{ $school_year }}</strong>, setelah memenuhi seluruh kriteria kelulusan
            yang telah ditetapkan sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.
            <br><br>
            Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan
            sebagaimana mestinya.
        </p>

        {{-- TANDA TANGAN --}}
        <table class="ttd-tbl">
            <tr>
                <td class="ttd-left"></td>
                <td class="ttd-right">
                    <div class="ttd-kota">Contoh, {{ $issued_at }}</div>
                    <div class="ttd-jabatan">Kepala Sekolah,</div>
                    <div class="stempel-circle">
                        <div class="stempel-label">Stempel<br>Sekolah</div>
                    </div>
                    <div class="ttd-garis"></div>
                    <div class="ttd-nama-kepsek">Drs. Nama Kepala Sekolah, M.Pd.</div>
                    <div class="ttd-nip">NIP. 196001011985011001</div>
                </td>
            </tr>
        </table>

        {{-- FOOTER --}}
        <div class="doc-footer">
            <table class="footer-tbl">
                <tr>
                    <td class="footer-info">
                        Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Pengumuman Kelulusan.<br>
                        Dicetak pada: <strong>{{ $issued_at }}</strong>
                        &nbsp;&bull;&nbsp; Berlaku sebagai dokumen sementara sebelum ijazah resmi diterbitkan.
                    </td>
                    <td class="footer-code-cell">
                        <div class="code-box">
                            <div class="code-lbl">Kode Verifikasi</div>
                            <div class="code-val">
                                SKL-{{ strtoupper(substr(md5($student->nis . $student->id . $year), 0, 10)) }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>{{-- /page --}}

</body>

</html>