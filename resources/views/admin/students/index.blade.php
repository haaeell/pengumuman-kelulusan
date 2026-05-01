@extends('layouts.app')

@section('content')
    <style>
        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            padding: 18px 20px;
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
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
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

        /* TABLE */
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
            padding: 12px 14px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            white-space: nowrap;
        }

        #studentsTable tbody td {
            padding: 11px 14px !important;
            font-size: 13px !important;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #374151;
        }

        #studentsTable tbody tr:hover td {
            background: #fafbff !important;
        }

        /* Mobile table scroll */
        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* BADGE */
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

        /* ACTION BUTTONS */
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

        /* TOP BUTTONS */
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

        /* Mobile: button group stacks */
        @media (max-width: 640px) {
            .page-header {
                flex-direction: column;
                align-items: stretch !important;
                gap: 12px;
            }

            .page-header .btn-group {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .page-header .btn-group .btn-primary-indigo {
                grid-column: 1 / -1;
                justify-content: center;
            }

            .btn-outline-green,
            .btn-outline-red,
            .btn-primary-indigo {
                justify-content: center;
            }

            .stat-card {
                padding: 14px 16px;
            }

            .stat-card h3.text-3xl {
                font-size: 1.6rem;
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

        /* MODAL OVERLAY */
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

        /* MODAL BOX */
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

        /* MODAL HEADER */
        .modal-header {
            padding: 20px 24px 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .modal-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .modal-header h3 {
            font-size: 16px;
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

        /* MODAL BODY */
        .modal-body {
            padding: 16px 24px;
        }

        .modal-footer {
            padding: 14px 24px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #f1f5f9;
        }

        /* Responsive modal grid */
        @media (max-width: 480px) {
            .modal-box {
                border-radius: 16px;
            }

            .modal-header {
                padding: 16px 18px 0;
            }

            .modal-body {
                padding: 12px 18px;
            }

            .modal-footer {
                padding: 12px 18px 18px;
            }

            .form-grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* FORM */
        .form-group {
            margin-bottom: 14px;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* DIVIDER */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 16px 0 12px;
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

        /* MODAL BUTTONS */
        .mbtn {
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* IMPORT */
        .import-step {
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 14px;
            transition: border-color .2s;
        }

        .import-step:hover {
            border-color: #c7d2fe;
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            background: #eef2ff;
            color: #6366f1;
            margin-bottom: 8px;
        }

        .upload-zone {
            border: 2px dashed #c7d2fe;
            border-radius: 12px;
            padding: 24px 16px;
            text-align: center;
            background: #fafbff;
            cursor: pointer;
            transition: all .2s;
        }

        .upload-zone:hover {
            background: #eff6ff;
            border-color: #818cf8;
        }

        /* SCROLLBAR */
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

        /* DataTables mobile tweaks */
        @media (max-width: 768px) {
            #studentsTable_wrapper .dataTables_filter {
                text-align: left;
            }

            #studentsTable_wrapper .row {
                margin: 0;
            }
        }
    </style>

    <div class="space-y-5">

        {{-- PAGE HEADER --}}
        <div class="page-header flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Data Siswa</h2>
                <p class="text-xs text-gray-400 mt-0.5">Manajemen data, nilai & status kelulusan siswa</p>
            </div>

            <div class="btn-group flex flex-wrap items-center gap-2">
                <button onclick="openModal('importModal')" class="btn-outline-green">
                    <i class="fa-solid fa-file-excel text-[12px]"></i> Import Excel
                </button>
                <button onclick="resetData()" class="btn-outline-red">
                    <i class="fa-solid fa-arrow-rotate-left text-[12px]"></i> Reset Data
                </button>
                <form id="reset-form" method="POST" action="{{ route('students.reset') }}" class="hidden">
                    @csrf @method('DELETE')
                </form>
                <button onclick="openModal('addModal')" class="btn-primary-indigo">
                    <i class="fa-solid fa-plus text-[11px]"></i> Tambah Siswa
                </button>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <p class="text-xs font-600 text-blue-600 mb-0.5">Total Siswa</p>
                    <h3 class="text-3xl font-800 text-blue-700 leading-none">{{ $students->count() }}</h3>
                </div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="fa-solid fa-check"></i></div>
                <div>
                    <p class="text-xs font-600 text-green-600 mb-0.5">Lulus</p>
                    <h3 class="text-3xl font-800 text-green-700 leading-none">
                        {{ $students->where('status', 'lulus')->count() }}
                    </h3>
                </div>
            </div>
            <div class="stat-card red">
                <div class="stat-icon"><i class="fa-solid fa-xmark"></i></div>
                <div>
                    <p class="text-xs font-600 text-red-600 mb-0.5">Tidak Lulus</p>
                    <h3 class="text-3xl font-800 text-red-700 leading-none">
                        {{ $students->where('status', 'tidak_lulus')->count() }}
                    </h3>
                </div>
            </div>
            <div class="stat-card amber">
                <div class="stat-icon"><i class="fa-solid fa-percent"></i></div>
                <div>
                    <p class="text-xs font-600 text-amber-600 mb-0.5">Tingkat Kelulusan</p>
                    @php
                        $total = $students->count();
                        $lulus = $students->where('status', 'lulus')->count();
                        $pct = $total > 0 ? round($lulus / $total * 100) : 0;
                    @endphp
                    <h3 class="text-3xl font-800 text-amber-700 leading-none">{{ $pct }}<span class="text-lg">%</span></h3>
                </div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <i class="fa-solid fa-table-list text-indigo-500 text-xs"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-700 text-gray-800">Daftar Siswa</h4>
                        <p class="text-[11px] text-gray-400">{{ $students->count() }} siswa terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-6">
                <div class="table-responsive-wrapper">
                    <table class="w-full text-sm" id="studentsTable">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Siswa</th>
                                <th>Kelahiran</th>
                                <th>Orang Tua</th>
                                <th>Akademik (Mapel)</th>
                                <th>Nilai (Total/Avg)</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $s)
                                <tr>
                                    <!-- Ranking -->
                                    <td class="text-center">
                                        <span class="flex items-center justify-center gap-1">
                                            <span class="text-amber-500 text-xs"><i class="fa-solid fa-trophy"></i></span>
                                            <span class="font-800 text-lg">#{{ $s->ranking }}</span>
                                        </span>
                                    </td>

                                    <!-- Siswa (NIS, NISN, Nama, Kelas) -->
                                    <td>
                                        <div class="font-700 text-gray-900">{{ $s->nama }}</div>
                                        <div class="text-[10px] text-gray-500 font-mono">
                                            NIS: {{ $s->nis }} | NISN: {{ $s->nisn }}
                                        </div>
                                        <span
                                            class="bg-indigo-50 text-indigo-600 text-[10px] font-700 px-1.5 py-0.5 rounded mt-1 inline-block uppercase">
                                            {{ $s->kelas }}
                                        </span>
                                    </td>

                                    <!-- Kelahiran -->
                                    <td>
                                        <div class="text-gray-700">{{ $s->tempat_lahir }}</div>
                                        <div class="text-[11px] text-gray-400">
                                            <i class="fa-regular fa-calendar-days mr-1"></i>
                                            {{ $s->tanggal_lahir ? $s->tanggal_lahir : '-' }}
                                        </div>
                                    </td>

                                    <!-- Orang Tua -->
                                    <td class="text-gray-600 italic">
                                        {{ $s->nama_orang_tua ?? '-' }}
                                    </td>

                                    <!-- Mapel -->
                                    <td>
                                        <span class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-600 font-500">
                                            {{ $s->mapel ?? 'Semua Mapel' }}
                                        </span>
                                    </td>

                                    <!-- Nilai -->
                                    <td>
                                        <div class="font-700 text-gray-800">{{ $s->total_score }}</div>
                                        <div class="text-[11px] text-indigo-500 font-600">
                                            Avg: {{ number_format($s->average_score, 2) }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if ($s->isLulus())
                                            <span class="badge badge-lulus"><i class="fa-solid fa-circle-check"></i> LULUS</span>
                                        @else
                                            <span class="badge badge-gagal"><i class="fa-solid fa-circle-xmark"></i> GAGAL</span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td>
                                        <div class="flex items-center justify-center gap-1.5">
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
                        <input name="kelas" class="form-control" placeholder="Contoh: XII‑IPA 2" required>
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
                        <label class="form-label">Rata‑rata Nilai</label>
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
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Data
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
                    <h6 class="text-sm font-700 text-gray-800 mb-1">Download Template</h6>
                    <p class="text-xs text-gray-500 mb-3">Gunakan template resmi agar format kolom sesuai sistem.</p>
                    <a href="{{ route('students.template') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-xs font-600 hover:bg-green-700 transition-colors"
                        style="border-radius:10px; text-decoration:none;">
                        <i class="fa-solid fa-file-arrow-down"></i> Download Template Excel
                    </a>
                </div>
                <div class="import-step">
                    <div class="step-badge">2</div>
                    <h6 class="text-sm font-700 text-gray-800 mb-3">Upload File Excel</h6>
                    <div class="upload-zone" onclick="document.getElementById('excelFile').click()">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-indigo-300 mb-3"></i>
                        <p class="text-sm font-600 text-gray-700">Klik untuk pilih file</p>
                        <p class="text-xs text-gray-400 mt-1">Format: <b>.xlsx</b> atau <b>.xls</b></p>
                        <input type="file" id="excelFile" name="file" accept=".xlsx,.xls" required class="hidden"
                            onchange="updateFileName(this)">
                    </div>
                    <p id="fileName" class="text-xs text-indigo-600 font-600 mt-2 hidden"></p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach(['NIS', 'Nama', 'Kelas', 'Total Nilai', 'Rata‑rata', 'Ranking', 'Status'] as $col)
                            <span class="text-[11px] font-600 bg-gray-100 text-gray-500 px-2 py-1 rounded-lg">{{ $col }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('importModal')" class="mbtn mbtn-cancel">Batal</button>
                <button type="submit" id="btnImport" class="mbtn mbtn-green">
                    <svg id="importSpinner" class="hidden w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z" />
                    </svg>
                    <i id="importIcon" class="fa-solid fa-upload"></i>
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
                            <label class="form-label">Rata‑rata Nilai</label>
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
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Update Data
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
                order: [[6, 'asc']],
                scrollX: false,
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
            if (input.files.length) { el.textContent = '📎 ' + input.files[0].name; el.classList.remove('hidden'); }
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
                confirmButtonText: 'Ya, Reset Sekarang',
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
    </script>
@endpush