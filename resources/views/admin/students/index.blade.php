@extends('layouts.app')

@section('content')
    <style>
        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            right: -16px;
            top: -24px;
            opacity: .12;
        }

        .stat-card.blue {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .stat-card.blue::before {
            background: #2563eb;
        }

        .stat-card.green {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .stat-card.green::before {
            background: #16a34a;
        }

        .stat-card.red {
            background: #fff1f2;
            border: 1px solid #fecdd3;
        }

        .stat-card.red::before {
            background: #dc2626;
        }

        .stat-card.amber {
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        .stat-card.amber::before {
            background: #d97706;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .stat-card.blue .stat-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .stat-card.green .stat-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-card.red .stat-icon {
            background: #ffe4e6;
            color: #dc2626;
        }

        .stat-card.amber .stat-icon {
            background: #fef3c7;
            color: #d97706;
        }

        #studentsTable_wrapper .dataTables_filter input,
        #studentsTable_wrapper .dataTables_length select {
            border: 1.5px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 6px 10px !important;
            font-size: 13px !important;
            outline: none !important;
            transition: border-color .2s;
        }

        #studentsTable_wrapper .dataTables_filter input:focus,
        #studentsTable_wrapper .dataTables_length select:focus {
            border-color: #6366f1 !important;
        }

        #studentsTable thead th {
            background: #f8fafc !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            letter-spacing: .06em !important;
            text-transform: uppercase !important;
            color: #64748b !important;
            padding: 11px 12px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            white-space: nowrap;
        }

        #studentsTable tbody td {
            padding: 10px 12px !important;
            font-size: 13px !important;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #374151;
        }

        #studentsTable tbody tr:hover td {
            background: #fafbff !important;
        }

        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .03em;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .badge-lulus {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-gagal {
            background: #ffe4e6;
            color: #be123c;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all .15s;
            border: none;
            cursor: pointer;
        }

        .action-btn.edit {
            background: #fef9c3;
            color: #ca8a04;
        }

        .action-btn.edit:hover {
            background: #fde047;
            color: #854d0e;
        }

        .action-btn.del {
            background: #ffe4e6;
            color: #e11d48;
        }

        .action-btn.del:hover {
            background: #fecdd3;
            color: #9f1239;
        }

        .btn-outline-green {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid #16a34a;
            color: #16a34a;
            background: white;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-outline-green:hover {
            background: #f0fdf4;
        }

        .btn-outline-red {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid #dc2626;
            color: #dc2626;
            background: white;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-outline-red:hover {
            background: #fff1f2;
        }

        .btn-primary-indigo {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(99, 102, 241, .35);
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-primary-indigo:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, .45);
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
            padding: 16px;
        }

        .modal.show {
            display: flex;
        }

        .modal-box {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 560px;
            max-height: 92vh;
            overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .18);
            animation: modalIn .25s cubic-bezier(.34, 1.56, .64, 1);
        }

        .modal-box.wide {
            max-width: 680px;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.93) translateY(16px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            padding: 20px 22px 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .modal-header-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .modal-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .modal-header p {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #f1f5f9;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 13px;
            transition: all .15s;
            flex-shrink: 0;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .modal-body {
            padding: 14px 22px;
        }

        .modal-footer {
            padding: 12px 22px 18px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #f1f5f9;
        }

        .form-group {
            margin-bottom: 13px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            letter-spacing: .02em;
        }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            color: #111827;
            background: white;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
        }

        .form-control::placeholder {
            color: #d1d5db;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 14px;
        }

        .form-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 14px 0 10px;
        }

        .form-divider span {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #94a3b8;
            white-space: nowrap;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .mbtn {
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
        }

        .mbtn-cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .mbtn-cancel:hover {
            background: #e2e8f0;
        }

        .mbtn-save {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 2px 8px rgba(99, 102, 241, .3);
        }

        .mbtn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, .4);
        }

        .mbtn-green {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            box-shadow: 0 2px 8px rgba(34, 197, 94, .3);
        }

        .mbtn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, .4);
        }

        .import-step {
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 12px;
            transition: border-color .2s;
        }

        .import-step:hover {
            border-color: #c7d2fe;
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 800;
            background: #eef2ff;
            color: #6366f1;
            margin-bottom: 7px;
        }

        .upload-zone {
            border: 2px dashed #c7d2fe;
            border-radius: 12px;
            padding: 22px 16px;
            text-align: center;
            background: #fafbff;
            cursor: pointer;
            transition: all .2s;
        }

        .upload-zone:hover {
            background: #eff6ff;
            border-color: #818cf8;
        }

        .modal-box::-webkit-scrollbar {
            width: 4px;
        }

        .modal-box::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal-box::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .btn-outline-blue {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border: 1px solid #3b82f6;
            color: #3b82f6;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            background: transparent;
            transition: background 0.15s;
        }

        .btn-outline-blue:hover {
            background: #eff6ff;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 0;
            }

            .modal-box {
                border-radius: 16px;
            }

            .modal-header {
                padding: 14px 16px 0;
            }

            .modal-body {
                padding: 10px 16px;
            }

            .modal-footer {
                padding: 10px 16px 16px;
            }

            #studentsTable_wrapper .dataTables_filter,
            #studentsTable_wrapper .dataTables_length {
                width: 100%;
            }

            #studentsTable_wrapper .dataTables_filter input {
                width: 100% !important;
            }

            #studentsTable_wrapper .dataTables_info,
            #studentsTable_wrapper .dataTables_paginate {
                font-size: 12px;
            }
        }
    </style>

    <div class="space-y-4 sm:space-y-5">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 tracking-tight">Data Siswa</h2>
                <p class="text-xs text-gray-400 mt-0.5">Manajemen data, nilai & status kelulusan siswa</p>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2">
                <button onclick="openModal('importModal')" class="btn-outline-green justify-center">
                    <i class="fa-solid fa-file-excel text-[12px]"></i>Import Excel
                </button>
                <button onclick="resetData()" class="btn-outline-red justify-center">
                    <i class="fa-solid fa-arrow-rotate-left text-[12px]"></i>Reset Data
                </button>

                <button onclick="generateAllSurat()" class="btn-outline-blue justify-center" id="btn-generate-surat">
                    <i class="fa-solid fa-file-pdf text-[12px]"></i>Generate Semua Surat
                </button>

                <form id="reset-form" method="POST" action="{{ route('students.reset') }}" class="hidden">
                    @csrf @method('DELETE')
                </form>

                <button onclick="openModal('addModal')" class="btn-primary-indigo col-span-2 sm:col-span-1 justify-center">
                    <i class="fa-solid fa-plus text-[11px]"></i> Tambah Siswa
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <p class="text-xs font-semibold text-blue-600 mb-0.5">Total Siswa</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-blue-700 leading-none">{{ $students->count() }}</h3>
                </div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="fa-solid fa-check"></i></div>
                <div>
                    <p class="text-xs font-semibold text-green-600 mb-0.5">Lulus</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-green-700 leading-none">
                        {{ $students->where('status', 'lulus')->count() }}
                    </h3>
                </div>
            </div>
            <div class="stat-card red">
                <div class="stat-icon"><i class="fa-solid fa-xmark"></i></div>
                <div>
                    <p class="text-xs font-semibold text-red-600 mb-0.5">Tidak Lulus</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-red-700 leading-none">
                        {{ $students->where('status', 'tidak_lulus')->count() }}
                    </h3>
                </div>
            </div>
            <div class="stat-card amber">
                <div class="stat-icon"><i class="fa-solid fa-percent"></i></div>
                <div>
                    <p class="text-xs font-semibold text-amber-600 mb-0.5">Kelulusan</p>
                    @php
                        $total = $students->count();
                        $lulus = $students->where('status', 'lulus')->count();
                        $pct = $total > 0 ? round($lulus / $total * 100) : 0;
                    @endphp
                    <h3 class="text-2xl sm:text-3xl font-bold text-amber-700 leading-none">
                        {{ $pct }}<span class="text-base sm:text-lg">%</span>
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <i class="fa-solid fa-table-list text-indigo-500 text-xs"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Daftar Siswa</h4>
                        <p class="text-[11px] text-gray-400">{{ $students->count() }} siswa terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="p-3 sm:p-5">
                <div class="table-responsive-wrapper">
                    <table class="w-full text-sm" id="studentsTable" style="min-width:700px">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Siswa</th>
                                <th>Kelahiran</th>
                                <th>Orang Tua</th>
                                <th>Mapel</th>
                                <th>Nilai</th>
                                <th>SKL</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $s)
                                <tr>
                                    <td class="text-center">
                                        <span class="flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-trophy text-amber-400 text-[10px]"></i>
                                            <span class="font-bold text-base">#{{ $s->ranking }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="font-semibold text-gray-900 text-[13px]">{{ $s->nama }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono mt-0.5">
                                            {{ $s->nis }} · {{ $s->nisn }}
                                        </div>
                                        <span
                                            class="bg-indigo-50 text-indigo-600 text-[10px] font-semibold px-1.5 py-0.5 rounded mt-1 inline-block uppercase">
                                            {{ $s->kelas }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-[13px] text-gray-700">{{ $s->tempat_lahir ?? '-' }}</div>
                                        <div class="text-[11px] text-gray-400 mt-0.5">
                                            {{ $s->tanggal_lahir ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="text-gray-500 text-[13px] italic">{{ $s->nama_orang_tua ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="text-[11px] bg-slate-100 px-2 py-1 rounded text-slate-600 font-medium leading-tight block max-w-[140px]">
                                            {{ $s->mapel ?? 'Semua Mapel' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="font-bold text-gray-800 text-[13px]">{{ $s->total_score }}</div>
                                        <div class="text-[11px] text-indigo-500 font-semibold">
                                            {{ number_format($s->average_score, 2) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($s->file_surat)
                                            <a href="{{ Storage::url($s->file_surat) }}" target="_blank"
                                                class="text-blue-600 hover:underline text-xs">
                                                <i class="fa-solid fa-file-pdf"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">Belum digenerate</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($s->isLulus())
                                            <span class="badge badge-lulus"><i class="fa-solid fa-circle-check"></i> LULUS</span>
                                        @else
                                            <span class="badge badge-gagal"><i class="fa-solid fa-circle-xmark"></i> GAGAL</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center gap-1.5">
                                            <form id="generate-{{ $s->id }}" method="POST"
                                                action="{{ route('students.generateSurat', $s->id) }}" class="hidden">
                                                @csrf
                                            </form>
                                            <button onclick="generateSurat({{ $s->id }}, '{{ addslashes($s->nama) }}')"
                                                class="action-btn" style="background:#eff6ff;color:#3b82f6"
                                                title="{{ $s->file_surat ? 'Regenerate Surat' : 'Generate Surat' }}">
                                                <i class="fa-solid fa-file-pdf text-[10px]"></i>
                                            </button>
                                            <button onclick="openModal('edit{{ $s->id }}')" class="action-btn edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button onclick="hapus({{ $s->id }})" class="action-btn del">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <form id="hapus-{{ $s->id }}" method="POST"
                                                action="{{ route('students.destroy', $s->id) }}" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL: TAMBAH SISWA --}}
    <div id="addModal" class="modal">
        <form method="POST" action="{{ route('students.store') }}" class="modal-box">
            @csrf
            <div class="modal-header">
                <div>
                    <div class="modal-header-icon bg-indigo-50">
                        <i class="fa-solid fa-user-plus text-indigo-500"></i>
                    </div>
                    <h3>Tambah Siswa Baru</h3>
                    <p>Isi data siswa dengan lengkap dan benar</p>
                </div>
                <button type="button" onclick="closeModal('addModal')" class="modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-divider"><span>Identitas</span></div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">NIS / Username</label>
                        <input name="nis" class="form-control" placeholder="Contoh: 2024001" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <input name="kelas" class="form-control" placeholder="Contoh: XII IPA 2" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input name="nama" class="form-control" placeholder="Nama lengkap siswa" required>
                </div>

                <div class="form-divider"><span>Data Tambahan</span></div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">NISN</label>
                        <input name="nisn" class="form-control" placeholder="Contoh: 1234567890" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran</label>
                        <input name="mapel" class="form-control" placeholder="Contoh: Matematika">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input name="tempat_lahir" class="form-control" placeholder="Contoh: Magelang">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Orang Tua</label>
                    <input name="nama_orang_tua" class="form-control" placeholder="Nama orang tua">
                </div>

                <div class="form-divider"><span>Nilai & Peringkat</span></div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Total Nilai</label>
                        <input name="total_score" class="form-control" type="number" step="0.01" placeholder="0.00"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rata-rata Nilai</label>
                        <input name="average_score" class="form-control" type="number" step="0.01" placeholder="0.00"
                            required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Ranking</label>
                        <input name="ranking" class="form-control" type="number" placeholder="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Kelulusan</label>
                        <select name="status" class="form-control">
                            <option value="lulus">✓ Lulus</option>
                            <option value="tidak_lulus">✗ Tidak Lulus</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('addModal')" class="mbtn mbtn-cancel">Batal</button>
                <button type="submit" class="mbtn mbtn-save">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- MODAL: IMPORT EXCEL --}}
    <div id="importModal" class="modal">
        <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data" class="modal-box wide">
            @csrf
            <div class="modal-header">
                <div>
                    <div class="modal-header-icon bg-green-50">
                        <i class="fa-solid fa-file-excel text-green-500"></i>
                    </div>
                    <h3>Import Data Siswa</h3>
                    <p>Upload file Excel untuk memasukkan data massal</p>
                </div>
                <button type="button" onclick="closeModal('importModal')" class="modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="import-step">
                    <div class="step-badge">1</div>
                    <h6 class="text-sm font-bold text-gray-800 mb-1">Download Template</h6>
                    <p class="text-xs text-gray-500 mb-3">Gunakan template resmi agar format kolom sesuai sistem.</p>
                    <a href="{{ route('students.template') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-xs font-semibold hover:bg-green-700 transition-colors"
                        style="border-radius:10px; text-decoration:none;">
                        <i class="fa-solid fa-file-arrow-down"></i> Download Template
                    </a>
                </div>
                <div class="import-step">
                    <div class="step-badge">2</div>
                    <h6 class="text-sm font-bold text-gray-800 mb-3">Upload File Excel</h6>
                    <div class="upload-zone" onclick="document.getElementById('excelFile').click()">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-indigo-300 mb-3 block"></i>
                        <p class="text-sm font-semibold text-gray-700">Klik untuk pilih file</p>
                        <p class="text-xs text-gray-400 mt-1">Format: <b>.xlsx</b> atau <b>.xls</b></p>
                        <input type="file" id="excelFile" name="file" accept=".xlsx,.xls" required class="hidden"
                            onchange="updateFileName(this)">
                    </div>
                    <p id="fileName" class="text-xs text-indigo-600 font-semibold mt-2 hidden"></p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach(['NIS', 'Nama', 'Kelas', 'Total Nilai', 'Rata-rata', 'Ranking', 'Status'] as $col)
                            <span
                                class="text-[11px] font-semibold bg-gray-100 text-gray-500 px-2 py-1 rounded-lg">{{ $col }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('importModal')" class="mbtn mbtn-cancel">Batal</button>
                <button type="submit" id="btnImport" class="mbtn mbtn-green">
                    <svg id="importSpinner" class="hidden w-4 h-4 animate-spin mr-1" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z" />
                    </svg>
                    <i id="importIcon" class="fa-solid fa-upload mr-1"></i>
                    <span id="importText">Import Sekarang</span>
                </button>
            </div>
        </form>
    </div>

    {{-- MODAL: EDIT SISWA --}}
    @foreach ($students as $s)
        <div id="edit{{ $s->id }}" class="modal">
            <form method="POST" action="{{ route('students.update', $s->id) }}" class="modal-box">
                @csrf @method('PUT')
                <div class="modal-header">
                    <div>
                        <div class="modal-header-icon bg-amber-50">
                            <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                        </div>
                        <h3>Edit Data Siswa</h3>
                        <p>Perbarui informasi untuk <b>{{ $s->nama }}</b></p>
                    </div>
                    <button type="button" onclick="closeModal('edit{{ $s->id }}')" class="modal-close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-divider"><span>Identitas</span></div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">NIS</label>
                            <input name="nis" class="form-control" value="{{ $s->nis }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelas</label>
                            <input name="kelas" class="form-control" value="{{ $s->kelas }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input name="nama" class="form-control" value="{{ $s->nama }}" required>
                    </div>

                    <div class="form-divider"><span>Data Tambahan</span></div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">NISN</label>
                            <input name="nisn" class="form-control" value="{{ $s->nisn }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mata Pelajaran</label>
                            <input name="mapel" class="form-control" value="{{ $s->mapel }}">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Tempat Lahir</label>
                            <input name="tempat_lahir" class="form-control" value="{{ $s->tempat_lahir }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $s->tanggal_lahir }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Orang Tua</label>
                        <input name="nama_orang_tua" class="form-control" value="{{ $s->nama_orang_tua }}">
                    </div>

                    <div class="form-divider"><span>Nilai & Peringkat</span></div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Total Nilai</label>
                            <input name="total_score" class="form-control" type="number" step="0.01"
                                value="{{ $s->total_score }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rata-rata Nilai</label>
                            <input name="average_score" class="form-control" type="number" step="0.01"
                                value="{{ $s->average_score }}">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ranking</label>
                            <input name="ranking" class="form-control" type="number" value="{{ $s->ranking }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Kelulusan</label>
                            <select name="status" class="form-control">
                                <option value="lulus" {{ $s->status == 'lulus' ? 'selected' : '' }}>✓ Lulus</option>
                                <option value="tidak_lulus" {{ $s->status == 'tidak_lulus' ? 'selected' : '' }}>✗ Tidak Lulus
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('edit{{ $s->id }}')" class="mbtn mbtn-cancel">Batal</button>
                    <button type="submit" class="mbtn mbtn-save">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#studentsTable').DataTable({
                pageLength: 10,
                scrollX: false,
                ordering: false,
                language: {
                    search: '',
                    searchPlaceholder: 'Cari siswa...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    paginate: { previous: '‹', next: '›' }
                }
            });
        });

        function openModal(id) { document.getElementById(id).classList.add('show'); }
        function closeModal(id) { document.getElementById(id).classList.remove('show'); }

        document.querySelectorAll('.modal').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
        });

        function updateFileName(input) {
            const el = document.getElementById('fileName');
            if (input.files.length) {
                el.textContent = '📎 ' + input.files[0].name;
                el.classList.remove('hidden');
            }
        }

        document.querySelector('#importModal form')?.addEventListener('submit', function () {
            const btn = document.getElementById('btnImport');
            const spin = document.getElementById('importSpinner');
            const icon = document.getElementById('importIcon');
            const text = document.getElementById('importText');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            spin.classList.remove('hidden');
            icon.classList.add('hidden');
            text.textContent = 'Mengimpor...';
        });

        function resetData() {
            Swal.fire({
                title: 'Reset Semua Data?',
                text: 'Seluruh data siswa akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then(r => { if (r.isConfirmed) document.getElementById('reset-form').submit(); });
        }

        function hapus(id) {
            Swal.fire({
                title: 'Hapus Data Siswa?',
                text: 'Data ini tidak bisa dikembalikan setelah dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then(r => { if (r.isConfirmed) document.getElementById('hapus-' + id).submit(); });
        }

        function generateAllSurat() {
            Swal.fire({
                title: 'Generate Semua Surat?',
                html: `<p style="font-size:13px;color:#64748b">
                                        Proses berjalan di background via SSE.<br>
                                        Progress tampil real-time, kamu bisa pantau dari halaman ini.
                                    </p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Generate!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then(r => {
                if (!r.isConfirmed) return;

                // Tampilkan progress bar
                Swal.fire({
                    title: 'Sedang Memproses...',
                    html: `
                                            <div style="margin:12px 0">
                                                <div style="background:#e0e7ff;border-radius:99px;height:10px;overflow:hidden">
                                                    <div id="swal-progress-bar"
                                                         style="height:100%;width:0%;background:linear-gradient(90deg,#6366f1,#3b82f6);
                                                                border-radius:99px;transition:width .4s ease"></div>
                                                </div>
                                                <p id="swal-progress-text"
                                                   style="font-size:12px;color:#64748b;margin-top:8px">
                                                    Menginisialisasi...
                                                </p>
                                                <p style="font-size:11px;color:#94a3b8;margin-top:4px">
                                                    Jangan tutup halaman ini
                                                </p>
                                            </div>
                                        `,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-2xl' }
                });

                // Buka koneksi SSE ke server
                const source = new EventSource('{{ route('students.generateAllSurat') }}');

                source.onmessage = function (e) {
                    const data = JSON.parse(e.data);
                    console.log('SSE:', data);


                    if (data.status === 'done') {
                        source.close();
                        const msg = data.total === 0
                            ? 'Semua siswa sudah memiliki surat kelulusan.'
                            : `${data.total} surat kelulusan berhasil digenerate.`;

                        Swal.fire({
                            title: data.total === 0 ? 'Tidak Ada yang Diproses' : 'Selesai! 🎉',
                            text: msg,
                            icon: data.total === 0 ? 'info' : 'success',
                            confirmButtonColor: '#6366f1',
                            customClass: { popup: 'rounded-2xl' }
                        }).then(() => location.reload());
                        return;
                    }

                    if (data.status === 'running') {
                        const pct = data.total > 0 ? Math.round(data.generated / data.total * 100) : 0;
                        const bar = document.getElementById('swal-progress-bar');
                        const text = document.getElementById('swal-progress-text');
                        if (bar) bar.style.width = pct + '%';
                        if (text) text.textContent = `${data.generated} / ${data.total} surat selesai (${pct}%)`;
                    }
                };

                source.onerror = function () {
                    source.close();
                    Swal.fire({
                        title: 'Koneksi Terputus',
                        text: 'Proses mungkin masih berjalan. Refresh halaman untuk cek status.',
                        icon: 'warning',
                        confirmButtonColor: '#6366f1',
                        customClass: { popup: 'rounded-2xl' }
                    });
                };
            });
        }

        function generateSurat(id, nama) {
            Swal.fire({
                title: 'Generate Surat?',
                html: `<p style="font-size:13px;color:#64748b">Generate surat kelulusan untuk <b>${nama}</b>?</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Generate!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then(r => {
                if (r.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        html: `<p style="font-size:13px;color:#64748b">Membuat surat untuk <b>${nama}</b>...</p>`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                    document.getElementById('generate-' + id).submit();
                }
            });
        }
    </script>
@endpush