@extends('layouts.app')

@section('content')
    <style>
        /* PANEL UTAMA */
        .setting-panel {
            background: white;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .panel-header {
            padding: 24px 28px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .panel-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(99, 102, 241, .35);
        }

        .panel-body {
            padding: 28px;
        }

        /* STATUS BESAR */
        .status-banner {
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .status-banner.active {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
        }

        .status-banner.inactive {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
        }

        .status-banner.empty {
            background: #fafbff;
            border: 2px dashed #c7d2fe;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 40px 24px;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #16a34a;
            position: relative;
            flex-shrink: 0;
        }

        .pulse-dot::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: rgba(22, 163, 74, .2);
            animation: pulse 2s infinite;
        }

        .pulse-dot.off {
            background: #cbd5e1;
        }

        .pulse-dot.off::before {
            background: transparent;
            animation: none;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* FIELD ROWS */
        .field-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f8fafc;
        }

        .field-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .field-label {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .06em;
            min-width: 120px;
            padding-top: 1px;
        }

        .field-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            flex: 1;
            text-align: right;
        }

        .field-value.muted {
            color: #94a3b8;
            font-weight: 400;
            font-style: italic;
        }

        /* DATE DISPLAY */
        .date-display {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 14px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
        }

        /* COUNTDOWN */
        .countdown-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .countdown-chip.future {
            background: #eff6ff;
            color: #2563eb;
        }

        .countdown-chip.today {
            background: #fef9c3;
            color: #854d0e;
        }

        .countdown-chip.past {
            background: #f1f5f9;
            color: #94a3b8;
        }

        /* ACTION BUTTONS */
        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            background: #fef9c3;
            color: #92400e;
            border: 1px solid #fde68a;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-edit:hover {
            background: #fde047;
            border-color: #f59e0b;
        }

        .btn-del {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-del:hover {
            background: #fecdd3;
            border-color: #fb7185;
        }

        .btn-primary-indigo {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(99, 102, 241, .35);
            transition: all .2s;
        }

        .btn-primary-indigo:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, .45);
        }

        /* TOGGLE SWITCH */
        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle {
            position: relative;
            width: 42px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            cursor: pointer;
            background: #e2e8f0;
            border-radius: 24px;
            transition: background .2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            left: 3px;
            top: 3px;
            transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
        }

        .toggle input:checked+.toggle-slider {
            background: #6366f1;
        }

        .toggle input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        /* INFO BOX */
        .info-box {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        /* MODAL */
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
            max-width: 520px;
            max-height: 92vh;
            overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .18);
            animation: modalIn .25s cubic-bezier(.34, 1.56, .64, 1);
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
            flex-shrink: 0;
            transition: all .15s;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

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
            font-family: inherit;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
        }

        .form-control::placeholder {
            color: #d1d5db;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .mbtn {
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            font-family: inherit;
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

        /* Mobile */
        @media (max-width: 640px) {
            .panel-header {
                padding: 18px 20px;
            }

            .panel-body {
                padding: 20px;
            }

            .status-banner {
                padding: 16px 18px;
            }

            .field-row {
                flex-direction: column;
                gap: 4px;
            }

            .field-value {
                text-align: left;
            }

            .panel-actions {
                flex-direction: column;
            }

            .panel-actions button {
                justify-content: center;
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
    </style>

    @php $ann = $announcements->first(); @endphp

    <div class="space-y-5">

        {{-- PAGE HEADER --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Setting Pengumuman</h2>
            <p class="text-xs text-gray-400 mt-0.5">Konfigurasi tanggal & status pengumuman kelulusan siswa</p>
        </div>

        {{-- ALERTS --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-500">
                <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-500">
                <i class="fa-solid fa-circle-xmark text-red-500"></i> {{ session('error') }}
            </div>
        @endif

        {{-- MAIN PANEL --}}
        <div class="setting-panel">

            <div class="panel-header">
                <div class="panel-header-icon">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div>
                    <h3 class="text-base font-700 text-gray-900">Pengumuman Kelulusan</h3>
                </div>
            </div>

            <div class="panel-body">

                @if (!$ann)
                    {{-- EMPTY STATE --}}
                    <div class="status-banner empty">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-calendar-xmark text-2xl text-indigo-300"></i>
                        </div>
                        <h4 class="text-sm font-700 text-gray-700">Belum ada pengumuman</h4>
                        <p class="text-xs text-gray-400 mt-1 mb-4">Atur tanggal pengumuman kelulusan agar siswa dapat mengecek
                            hasilnya</p>
                        <button onclick="openModal('addModal')" class="btn-primary-indigo">
                            <i class="fa-solid fa-plus text-[11px]"></i> Atur Pengumuman
                        </button>
                    </div>

                @else
                    @php
                        $isActive = $ann->is_active;
                        $isPast = \Carbon\Carbon::parse($ann->announcement_date)->isPast();
                        $isToday = \Carbon\Carbon::parse($ann->announcement_date)->isToday();
                    @endphp

                    {{-- STATUS BANNER --}}
                    <div class="status-banner {{ $isActive ? 'active' : 'inactive' }}">
                        <div class="status-indicator">
                            <div class="pulse-dot {{ $isActive ? '' : 'off' }}"></div>
                            <div>
                                <p
                                    class="text-xs font-700 {{ $isActive ? 'text-green-700' : 'text-gray-500' }} uppercase tracking-wide">
                                    {{ $isActive ? 'Pengumuman Aktif' : 'Pengumuman Nonaktif' }}
                                </p>
                                <p class="text-xs {{ $isActive ? 'text-green-600' : 'text-gray-400' }} mt-0.5">
                                    {{ $isActive ? 'Siswa dapat mengecek hasil kelulusan' : 'Siswa belum bisa melihat hasil kelulusan' }}
                                </p>
                            </div>
                        </div>

                        {{-- Quick toggle --}}
                        <form method="POST" action="{{ route('announcements.toggle', $ann->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="toggle-wrap"
                                style="background:none;border:none;cursor:pointer;padding:0;">
                                <label class="toggle" style="pointer-events:none;">
                                    <input type="checkbox" {{ $isActive ? 'checked' : '' }} style="pointer-events:none;">
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="text-xs font-600 {{ $isActive ? 'text-green-700' : 'text-gray-400' }}">
                                    {{ $isActive ? 'ON' : 'OFF' }}
                                </span>
                            </button>
                        </form>
                    </div>

                    {{-- DETAIL FIELDS --}}
                    <div class="mb-6">
                        <div class="field-row">
                            <span class="field-label">Judul</span>
                            <span class="field-value">{{ $ann->title }}</span>
                        </div>

                        <div class="field-row">
                            <span class="field-label">Tanggal</span>
                            <div class="text-right">
                                <span class="date-display">
                                    <i class="fa-solid fa-calendar text-[11px]"></i>
                                    {{ \Carbon\Carbon::parse($ann->announcement_date)->translatedFormat('d F Y') }}
                                </span>
                                <div class="mt-1.5">
                                    @if ($isToday)
                                        <span class="countdown-chip today">
                                            <i class="fa-solid fa-bell text-[10px]"></i> Hari ini!
                                        </span>
                                    @elseif ($isPast)
                                        <span class="countdown-chip past">
                                            <i class="fa-solid fa-clock-rotate-left text-[10px]"></i>
                                            {{ \Carbon\Carbon::parse($ann->announcement_date)->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="countdown-chip future">
                                            <i class="fa-solid fa-hourglass-half text-[10px]"></i>
                                            {{ \Carbon\Carbon::parse($ann->announcement_date)->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field-row">
                            <span class="field-label">Deskripsi</span>
                            @if ($ann->description)
                                <span class="field-value" style="max-width:280px;">{{ $ann->description }}</span>
                            @else
                                <span class="field-value muted">Tidak ada deskripsi</span>
                            @endif
                        </div>

                        <div class="field-row">
                            <span class="field-label">Terakhir diubah</span>
                            <span class="field-value" style="font-weight:400;color:#94a3b8;font-size:13px;">
                                {{ $ann->updated_at->translatedFormat('d F Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="panel-actions flex items-center gap-3">
                        <button onclick="openModal('editModal')" class="btn-edit">
                            <i class="fa-solid fa-pen-to-square text-[12px]"></i> Edit Pengumuman
                        </button>
                        <button onclick="hapus({{ $ann->id }}, '{{ addslashes($ann->title) }}')" class="btn-del">
                            <i class="fa-solid fa-trash-can text-[12px]"></i> Hapus
                        </button>
                        <form id="hapus-ann-{{ $ann->id }}" method="POST"
                            action="{{ route('announcements.destroy', $ann->id) }}" class="hidden">
                            @csrf @method('DELETE')
                        </form>
                    </div>

                @endif

            </div>
        </div>

        {{-- INFO BOX --}}
        <div class="info-box">
            <i class="fa-solid fa-circle-info text-indigo-500 text-sm mt-0.5 flex-shrink-0"></i>
            <div>
                <p class="text-xs font-700 text-indigo-800 mb-0.5">Cara Kerja Pengumuman</p>
                <p class="text-xs text-indigo-600 leading-relaxed">
                    Saat pengumuman berstatus <b>Aktif</b>, siswa dapat mengecek hasil kelulusan melalui halaman pencarian.
                    Nonaktifkan jika pengumuman belum saatnya dibuka. Untuk mengubah jadwal, gunakan tombol <b>Edit
                        Pengumuman</b>.
                </p>
            </div>
        </div>

    </div>

    {{-- MODAL: TAMBAH --}}
    <div id="addModal" class="modal">
        <form method="POST" action="{{ route('announcements.store') }}" class="modal-box">
            @csrf
            <div class="modal-header">
                <div>
                    <div class="modal-header-icon bg-indigo-50">
                        <i class="fa-solid fa-calendar-plus text-indigo-500"></i>
                    </div>
                    <h3>Atur Tanggal Pengumuman</h3>
                    <p>Konfigurasi pengumuman kelulusan siswa</p>
                </div>
                <button type="button" onclick="closeModal('addModal')" class="modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Pengumuman <span class="text-red-400">*</span></label>
                    <input name="title" class="form-control" placeholder="Contoh: Pengumuman Kelulusan TP 2024/2025"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Pengumuman <span class="text-red-400">*</span></label>
                    <input name="announcement_date" type="date" class="form-control" required min="{{ date('Y-m-d') }}">
                    <p class="text-[11px] text-gray-400 mt-1.5">Tanggal saat pengumuman dapat diakses siswa</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi <span class="text-gray-300 font-400">(opsional)</span></label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Keterangan tambahan..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Status Awal</label>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" value="1">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="text-sm text-gray-600">Langsung aktifkan setelah disimpan</span>
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

    {{-- MODAL: EDIT --}}
    @if ($ann)
        <div id="editModal" class="modal">
            <form method="POST" action="{{ route('announcements.update', $ann->id) }}" class="modal-box">
                @csrf @method('PUT')
                <div class="modal-header">
                    <div>
                        <div class="modal-header-icon bg-amber-50">
                            <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                        </div>
                        <h3>Edit Pengumuman</h3>
                        <p>Perbarui konfigurasi pengumuman kelulusan</p>
                    </div>
                    <button type="button" onclick="closeModal('editModal')" class="modal-close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Judul Pengumuman <span class="text-red-400">*</span></label>
                        <input name="title" class="form-control" value="{{ $ann->title }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengumuman <span class="text-red-400">*</span></label>
                        <input name="announcement_date" type="date" class="form-control"
                            value="{{ \Carbon\Carbon::parse($ann->announcement_date)->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi <span class="text-gray-300 font-400">(opsional)</span></label>
                        <textarea name="description" class="form-control" rows="3">{{ $ann->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="toggle-wrap">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1" {{ $ann->is_active ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="text-sm text-gray-600">Pengumuman aktif</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('editModal')" class="mbtn mbtn-cancel">Batal</button>
                    <button type="submit" class="mbtn mbtn-save">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        function openModal(id) { document.getElementById(id).classList.add('show'); }
        function closeModal(id) { document.getElementById(id).classList.remove('show'); }

        document.querySelectorAll('.modal').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
        });

        function hapus(id, title) {
            Swal.fire({
                title: 'Hapus Pengumuman?',
                html: `Data pengumuman <b>"${title}"</b> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then(r => { if (r.isConfirmed) document.getElementById('hapus-ann-' + id).submit(); });
        }
    </script>
@endpush