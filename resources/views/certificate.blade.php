<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Keterangan Lulus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Serif', 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
            padding: 0 50px;
            line-height: 1.2;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            /* sebelumnya 0 */
            left: 0;
            right: 0;
            text-align: center;
            margin-bottom: 20px;
        }

        .footer-bar {
            width: 100%;
            background-color: #6f7fb3;
            /* fallback untuk dompdf */
            padding: 10px 0;
            margin-bottom: 6px;
        }

        .footer-tagline {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 2px;
            color: #fff;
            /* ganti jadi putih */
        }

        .footer-detail {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.2;
        }

        .page {
            padding: 18px 45px 105px 45px;
        }

        .kop {
            position: relative;
            width: 100%;
            height: 210px;
        }

        .kop-logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 120px;
            text-align: center;
            padding-left: 10px;
        }

        .kop-logo img {
            width: 23z0px;
            height: 230px;
            margin-top: 20px;
        }

        .kop-teks {
            position: absolute;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            text-align: center;
            width: 100%;
        }

        .t-yayasan {
            font-family: Arial, sans-serif;
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: -1px;
            text-transform: uppercase;
            line-height: 1;
            padding-top: 30px;
        }

        .t-sekolah {
            font-family: Arial, sans-serif;
            font-size: 24pt;
            font-weight: 900;
            letter-spacing: -4px;
            line-height: 0.9;
        }

        .t-kampus {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .t-alamat {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            margin-top: 4px;
            line-height: 1;
        }

        .t-akreditasi {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            font-weight: bold;
            margin-top: 4px;
            line-height: 1;
        }

        hr.garis-kop {
            border: none;
            height: 4px;
            background-color: #8fa1c7;
            margin: 12px 0 0 0;
        }

        .judul {
            text-align: center;
            margin: 16px 0 16px 0;
        }

        .judul-text {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 2px;
        }

        .pembuka {
            font-size: 10pt;
            margin-bottom: 4px;
        }

        .daftar td {
            font-size: 10pt;
        }

        .menerangkan {
            font-size: 10pt;
            margin-bottom: 2px;
        }

        .biodata {
            width: 100%;
            border-collapse: collapse;
        }

        .biodata td {
            font-size: 10pt;
            padding: 0;
            vertical-align: top;
        }

        .b-label {
            width: 220px;
            padding-left: 8px;
            white-space: nowrap;
        }

        .b-sep {
            width: 16px;
        }

        .ttd {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .td-kanan {
            width: 50%;
            text-align: center;
        }

        .ttd-kota {
            margin-bottom: 2px;
        }

        .ttd-jabatan {
            margin-bottom: 4px;
        }

        .ttd-gambar {
            position: relative;
            width: 160px;
            height: 120px;
            margin: 0 auto;
        }

        .ttd-gambar img.g-cap {
            position: absolute;
            width: 1.9in;
            left: -270px;
            top: -150px;
        }

        .ttd-gambar img.g-ttd {
            position: absolute;
            width: 3.4in;
            left: -200px;
            top: -320px;
        }

        .ttd-nama {
            font-weight: bold;
            margin-top: 4px;
        }

        .ttd-nip {
            font-size: 10pt;
        }

        .ket {
            margin-top: 24px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 10pt;
        }
    </style>
</head>

<body>

    <div class="footer">
        <div class="footer-bar">
            <div class="footer-tagline">COMMITED TO THE LEADER EDUCATION QUALITY</div>
        </div>
        <div class="footer-detail">Jl. Raya Binong No. 65 Binong – Subang Jawa Barat Kode Pos 41253</div>
        <div class="footer-detail">
            Email :<span style="color:#0000FF;">smapnasofficial@gmail.com</span> &nbsp;
            Web. <span style="color:#0000FF;">http://asthahannas.com</span>
        </div>
    </div>

    <div class="page">

        <div class="kop">
            <div class="kop-logo">
                <img src="{{ $logo_url }}">
            </div>

            <div class="kop-teks">
                <div class="t-yayasan">YAYASAN ASTHA HANNAS</div>
                <div class="t-sekolah">SMA PLUS ASTHA HANNAS</div>
                <div class="t-kampus">KAMPUS PEMBANGUNAN KARAKTER BANGSA INDONESIA</div>
                <div class="t-alamat">
                    SK. Dinas Pendidikan Kabupaten Subang, Jawa Barat No. 820/012/Disdik/2005<br>
                    NIS. 300330 &nbsp; NSS. 302021999665 &nbsp; NPSN. 20233663
                </div>
                <div class="t-akreditasi">AKREDITASI "A"</div>
            </div>
        </div>

        <hr class="garis-kop">

        <div class="judul">
            <span class="judul-text">SURAT KETERANGAN LULUS</span>
        </div>

        <br><br>
        <p class="pembuka">
            Kepala Sekolah Menengah Atas Plus Astha Hannas Tahun Pelajaran {{ $school_year }}, dengan berdasarkan:
        </p>
        <br>

        <div style="padding: 0 30px">
            <ol class="daftar">
                <li>Penyelesaian seluruh program pembelajaran pada Kurikulum Nasional;</li>
                <li>Kriteria kelulusan dari satuan pendidikan sesuai dengan peraturan perundang-undangan;</li>
                <li>Rapat Pleno Dewan Guru tentang Penetapan Kelulusan pada tanggal {{ $rapat_tanggal }};</li>
            </ol>
        </div>

        <br>
        <p class="menerangkan">Menerangkan bahwa:</p>
        <br><br>

        <div style="padding: 0 50px">
            <table class="biodata">
                <tr>
                    <td class="b-label">Nama</td>
                    <td class="b-sep">:</td>
                    <td class="b-val"><strong>{{ strtoupper($student->nama) }}</strong></td>
                </tr>
                <tr>
                    <td class="b-label">Tempat dan Tanggal Lahir</td>
                    <td class="b-sep">:</td>
                    <td class="b-val">{{ $student->tempat_lahir }},
                        {{ \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('j F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="b-label">Nama Orang Tua</td>
                    <td class="b-sep">:</td>
                    <td class="b-val">{{ strtoupper($student->nama_orang_tua) }}</td>
                </tr>
                <tr>
                    <td class="b-label">Nomor Induk Siswa</td>
                    <td class="b-sep">:</td>
                    <td class="b-val">{{ $student->nis }}</td>
                </tr>
                <tr>
                    <td class="b-label">Nomor Induk Siswa Nasional</td>
                    <td class="b-sep">:</td>
                    <td class="b-val">{{ $student->nisn }}</td>
                </tr>
                <tr>
                    <td class="b-label">Mapel Pilihan</td>
                    <td class="b-sep">:</td>
                    <td class="b-val">
                        {{ $student->mapel_pilihan ?? 'Matematika Tingkat Lanjut, Fisika, Kimia, dan Biologi' }}
                    </td>
                </tr>
                <tr>
                    <td class="b-label">Dinyatakan</td>
                    <td class="b-sep">:</td>
                    <td class="b-val"><strong>LULUS</strong></td>
                </tr>
                <tr>
                    <td class="b-label">dengan Rata-rata Nilai*</td>
                    <td class="b-sep">:</td>
                    <td class="b-val"><strong>{{ number_format($student->average_score, 2, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <table class="ttd">
            <tr>
                <td class="td-kiri"></td>
                <td class="td-kanan">
                    <div class="ttd-kota">Kab. Subang, {{ $issued_at }}</div>
                    <div class="ttd-jabatan">Kepala Sekolah,</div>
                    <div class="ttd-gambar">
                        <img class="g-cap" src="{{ $cap_url }}" alt="Cap Sekolah">
                        <img class="g-ttd" src="{{ $ttd_url }}" alt="Tanda Tangan">
                    </div>
                    <div class="ttd-nama">{{ $kepala_sekolah }}</div>
                    <div class="ttd-nip">NIP. {{ $nip_kepsek }}</div>
                </td>
            </tr>
        </table>

        <div class="ket">
            <strong>Keterangan:</strong><br>
            *) &nbsp;rata-rata nilai peserta didik yang sama dengan nilai yang akan ditulis dalam Transkrip Nilai
            Ijazah.
        </div>

    </div>
</body>

</html>