@extends('layouts.app')

@section('content')
    <style>
        /* ANNOUNCEMENT CARDS */
        .ann-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 18px 20px;
            transition: box-shadow .2s, border-color .2s;
            position: relative;
            overflow: hidden;
        }
        .ann-card:hover { border-color: #c7d2fe; box-shadow: 0 4px 16px rgba(99,102,241,.08); }

        .ann-card.active-card { border-color: #6366f1; }
        .ann-card.active-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: linear-gradient(180deg,#6366f1,#4f46e5);
            border-radius: 4px 0 0 4px;
        }

        .ann-date-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #eef2ff; color: #4f46e5;
            font-size: 12px; font-weight: 700;
            padding: 5px 12px; border-radius: 20px;
        }
        .ann-date-badge.inactive { background: #f1f5f9; color: #94a3b8; }

        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 700; letter-spacing: .03em;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-pill.on  { background: #dcfce7; color: #15803d; }
        .status-pill.off { background: #f1f5f9; color: #94a3b8; }

        .status-dot {
            width: 6px; height: 6px; border-radius: 50%;
        }
        .status-dot.on  { background: #16a34a; }
        .status-dot.off { background: #cbd5e1; }

        /* EMPTY STATE */
        .empty-state {
            text-align: center; padding: 48px 24px;
        }
        .empty-state .empty-icon {
            width: 64px; height: 64px; border-radius: 20px;
            background: #eef2ff;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 24px; color: #6366f1;
        }

        /* BUTTONS */
        .btn-primary-indigo {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 10px;
            font-size: 13px; font-weight: 600;
            background: linear-gradient(135deg,#6366f1,#4f46e5);
            color: white; border: none; cursor: pointer;
            box-shadow: 0 2px 8px rgba(99,102,241,.35);
            transition: all .2s; white-space: nowrap;
            text-decoration: none;
        }
        .btn-primary-indigo:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,.45); color: white; }

        .btn-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; border: none; cursor: pointer; transition: all .15s;
        }
        .btn-icon.edit   { background: #fef9c3; color: #ca8a04; }
        .btn-icon.edit:hover { background: #fde047; color: #854d0e; }
        .btn-icon.del    { background: #ffe4e6; color: #e11d48; }
        .btn-icon.del:hover  { background: #fecdd3; color: #9f1239; }
        .btn-icon.toggle { background: #eff6ff; color: #2563eb; }
        .btn-icon.toggle:hover { background: #dbeafe; }
        .btn-icon.toggle.active { background: #dcfce7; color: #16a34a; }
        .btn-icon.toggle.active:hover { background: #bbf7d0; }

        /* MODAL */
        .modal {
            position: fixed; inset: 0;
            background: rgba(15,23,42,.55);
            backdrop-filter: blur(4px);
            display: none; align-items: center; justify-content: center;
            z-index: 50; padding: 16px;
        }
        .modal.show { display: flex; }
        .modal-box {
            background: white; border-radius: 20px;
            width: 100%; max-width: 520px;
            max-height: 92vh; overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0,0,0,.18);
            animation: modalIn .25s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes modalIn {
            from { opacity:0; transform:scale(.93) translateY(16px); }
            to   { opacity:1; transform:scale(1) translateY(0); }
        }

        .modal-header {
            padding: 20px 24px 0;
            display: flex; align-items: flex-start; justify-content: space-between;
        }
        .modal-header-icon {
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; margin-bottom: 10px;
        }
        .modal-header h3 { font-size: 16px; font-weight: 700; color: #0f172a; }
        .modal-header p  { font-size: 12px; color: #94a3b8; margin-top: 2px; }
        .modal-close {
            width: 30px; height: 30px; border-radius: 8px;
            background: #f1f5f9; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; font-size: 13px; flex-shrink: 0; transition: all .15s;
        }
        .modal-close:hover { background: #e2e8f0; color: #0f172a; }

        .modal-body   { padding: 16px 24px; }
        .modal-footer {
            padding: 14px 24px 20px;
            display: flex; justify-content: flex-end; gap: 10px;
            border-top: 1px solid #f1f5f9;
        }

        /* FORM */
        .form-group  { margin-bottom: 14px; }
        .form-label  {
            display: block; margin-bottom: 5px;
            font-size: 12px; font-weight: 600; color: #374151;
        }
        .form-control {
            width: 100%; padding: 9px 12px;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: 13px; color: #111827; background: white;
            transition: border-color .2s, box-shadow .2s;
            outline: none; font-family: inherit; box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
        .form-control::placeholder { color: #d1d5db; }
        textarea.form-control { resize: vertical; min-height: 80px; }

        /* TOGGLE SWITCH */
        .toggle-wrap { display: flex; align-items: center; gap: 10px; }
        .toggle {
            position: relative; width: 42px; height: 24px;
            flex-shrink: 0;
        }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; inset: 0; cursor: pointer;
            background: #e2e8f0; border-radius: 24px;
            transition: background .2s;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px; height: 18px; border-radius: 50%;
            background: white; left: 3px; top: 3px;
            transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0,0,0,.15);
        }
        .toggle input:checked + .toggle-slider { background: #6366f1; }
        .toggle input:checked + .toggle-slider::before { transform: translateX(18px); }

        /* MBTN */
        .mbtn {
            padding: 8px 18px; border-radius: 10px;
            font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; transition: all .2s; font-family: inherit;
        }
        .mbtn-cancel { background:#f1f5f9; color:#475569; }
        .mbtn-cancel:hover { background:#e2e8f0; }
        .mbtn-save {
            background: linear-gradient(135deg,#6366f1,#4f46e5);
            color: white; box-shadow: 0 2px 8px rgba(99,102,241,.3);
        }
        .mbtn-save:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,.4); }

        /* INFO BOX */
        .info-box {
            background: #eef2ff; border: 1px solid #c7d2fe;
            border-radius: 12px; padding: 12px 16px;
            display: flex; gap: 10px; align-items: flex-start;
        }
        .info-box i { color: #6366f1; margin-top: 1px; flex-shrink: 0; }

        /* Mobile */
        @media (max-width: 640px) {
            .page-header { flex-direction: column; align-items: stretch; gap: 12px; }
            .page-header button, .page-header a { justify-content: center; }
            .modal-box { border-radius: 16px; }
            .modal-header { padding: 16px 18px 0; }
            .modal-body   { padding: 12px 18px; }
            .modal-footer { padding: 12px 18px 18px; }
            .ann-card { padding: 14px 16px; }
        }

        /* Scrollbar */
        .modal-box::-webkit-scrollbar { width: 4px; }
        .modal-box::-webkit-scrollbar-track { background: transparent; }
        .modal-box::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
    </style>

    <div class="space-y-5">

        {{-- PAGE HEADER --}}
        <div class="page-header flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Setting Pengumuman</h2>
                <p class="text-xs text-gray-400 mt-0.5">Kelola tanggal & jadwal pengumuman kelulusan siswa</p>
            </div>
            <button onclick="openModal('addModal')" class="btn-primary-indigo">
                <i class="fa-solid fa-plus text-[11px]"></i> Tambah Pengumuman
            </button>
        </div>

        {{-- SUCCESS / ERROR ALERT --}}
        @if (session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-500">
                <i class="fa-solid fa-circle-check text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-500">
                <i class="fa-solid fa-circle-xmark text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- INFO BOX --}}
        <div class="info-box">
            <i class="fa-solid fa-circle-info text-sm mt-0.5"></i>
            <div>
                <p class="text-xs font-700 text-indigo-800 mb-0.5">Tentang Pengumuman Aktif</p>
                <p class="text-xs text-indigo-600 leading-relaxed">Hanya satu pengumuman yang bisa aktif sekaligus. Pengumuman aktif akan ditampilkan kepada siswa di halaman pengecekan hasil kelulusan sesuai tanggal yang ditentukan.</p>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                <p class="text-xs text-gray-400 font-600 mb-1">Total Pengumuman</p>
                <h3 class="text-2xl font-800 text-gray-800">{{ $announcements->count() }}</h3>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                <p class="text-xs text-green-600 font-600 mb-1">Sedang Aktif</p>
                <h3 class="text-2xl font-800 text-green-700">{{ $announcements->where('is_active', true)->count() }}</h3>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm col-span-2 sm:col-span-1">
                <p class="text-xs text-indigo-600 font-600 mb-1">Akan Datang</p>
                @php
                    $upcoming = $announcements->filter(fn($a) => \Carbon\Carbon::parse($a->announcement_date)->isFuture())->count();
                @endphp
                <h3 class="text-2xl font-800 text-indigo-700">{{ $upcoming }}</h3>
            </div>
        </div>

        {{-- ANNOUNCEMENT LIST --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-days text-indigo-500 text-xs"></i>
                </div>
                <div>
                    <h4 class="text-sm font-700 text-gray-800">Daftar Pengumuman</h4>
                    <p class="text-[11px] text-gray-400">{{ $announcements->count() }} jadwal terdaftar</p>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @if ($announcements->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <h4 class="text-sm font-700 text-gray-700 mb-1">Belum ada pengumuman</h4>
                        <p class="text-xs text-gray-400 mb-4">Tambahkan tanggal pengumuman pertama Anda</p>
                        <button onclick="openModal('addModal')" class="btn-primary-indigo">
                            <i class="fa-solid fa-plus text-[11px]"></i> Tambah Sekarang
                        </button>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($announcements as $ann)
                            @php
                                $isActive = $ann->is_active;
                                $isPast   = \Carbon\Carbon::parse($ann->announcement_date)->isPast();
                                $isToday  = \Carbon\Carbon::parse($ann->announcement_date)->isToday();
                            @endphp
                            <div class="ann-card {{ $isActive ? 'active-card' : '' }}">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                                    {{-- LEFT: info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <span class="ann-date-badge {{ $isActive ? '' : 'inactive' }}">
                                                <i class="fa-solid fa-calendar text-[10px]"></i>
                                                {{ \Carbon\Carbon::parse($ann->announcement_date)->translatedFormat('d F Y') }}
                                            </span>
                                            <span class="status-pill {{ $isActive ? 'on' : 'off' }}">
                                                <span class="status-dot {{ $isActive ? 'on' : 'off' }}"></span>
                                                {{ $isActive ? 'AKTIF' : 'NONAKTIF' }}
                                            </span>
                                            @if ($isToday)
                                                <span class="text-[11px] font-700 bg-amber-100 text-amber-700 px-2 py-1 rounded-xl">
                                                    <i class="fa-solid fa-bell text-[9px]"></i> Hari Ini
                                                </span>
                                            @elseif ($isPast)
                                                <span class="text-[11px] font-600 bg-gray-100 text-gray-400 px-2 py-1 rounded-xl">Sudah Lewat</span>
                                            @else
                                                <span class="text-[11px] font-600 bg-blue-50 text-blue-500 px-2 py-1 rounded-xl">
                                                    <i class="fa-solid fa-clock text-[9px]"></i>
                                                    {{ \Carbon\Carbon::parse($ann->announcement_date)->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>

                                        <h5 class="text-sm font-700 text-gray-800 truncate">{{ $ann->title }}</h5>

                                        @if ($ann->description)
                                            <p class="text-xs text-gray-400 mt-1 leading-relaxed line-clamp-2">{{ $ann->description }}</p>
                                        @endif

                                        <p class="text-[11px] text-gray-300 mt-2">
                                            Dibuat {{ $ann->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    {{-- RIGHT: actions --}}
                                    <div class="flex items-center gap-2 sm:flex-shrink-0">
                                        {{-- Toggle active --}}
                                        <form method="POST" action="{{ route('announcements.toggle', $ann->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="btn-icon toggle {{ $isActive ? 'active' : '' }}"
                                                title="{{ $isActive ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fa-solid {{ $isActive ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>

                                        <button onclick="openModal('editModal{{ $ann->id }}')"
                                            class="btn-icon edit" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <button onclick="hapus({{ $ann->id }}, '{{ addslashes($ann->title) }}')"
                                            class="btn-icon del" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <form id="hapus-ann-{{ $ann->id }}" method="POST"
                                            action="{{ route('announcements.destroy', $ann->id) }}" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
    MODAL: TAMBAH PENGUMUMAN
    ══════════════════════════════════════ --}}
    <div id="addModal" class="modal">
        <form method="POST" action="{{ route('announcements.store') }}" class="modal-box">
            @csrf

            <div class="modal-header">
                <div>
                    <div class="modal-header-icon bg-indigo-50">
                        <i class="fa-solid fa-calendar-plus text-indigo-500"></i>
                    </div>
                    <h3>Tambah Tanggal Pengumuman</h3>
                    <p>Atur jadwal pengumuman kelulusan baru</p>
                </div>
                <button type="button" onclick="closeModal('addModal')" class="modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Pengumuman <span class="text-red-400">*</span></label>
                    <input name="title" class="form-control" placeholder="Contoh: Pengumuman Kelulusan TP 2024/2025" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Pengumuman <span class="text-red-400">*</span></label>
                    <input name="announcement_date" type="date" class="form-control" required
                        min="{{ date('Y-m-d') }}">
                    <p class="text-[11px] text-gray-400 mt-1.5">Tanggal saat pengumuman ditampilkan kepada siswa</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi <span class="text-gray-300 font-400">(opsional)</span></label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Keterangan tambahan tentang pengumuman ini..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" value="1">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="text-sm text-gray-600">Aktifkan pengumuman ini sekarang</span>
                    </div>
                    <p class="text-[11px] text-amber-600 mt-1.5">
                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                        Mengaktifkan ini akan menonaktifkan pengumuman lain yang sedang aktif
                    </p>
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

    {{-- ══════════════════════════════════════
    MODAL: EDIT PENGUMUMAN (loop)
    ══════════════════════════════════════ --}}
    @foreach ($announcements as $ann)
        <div id="editModal{{ $ann->id }}" class="modal">
            <form method="POST" action="{{ route('announcements.update', $ann->id) }}" class="modal-box">
                @csrf @method('PUT')

                <div class="modal-header">
                    <div>
                        <div class="modal-header-icon bg-amber-50">
                            <i class="fa-solid fa-calendar-pen text-amber-500"></i>
                        </div>
                        <h3>Edit Pengumuman</h3>
                        <p>Perbarui jadwal pengumuman</p>
                    </div>
                    <button type="button" onclick="closeModal('editModal{{ $ann->id }}')" class="modal-close">
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
                    <button type="button" onclick="closeModal('editModal{{ $ann->id }}')" class="mbtn mbtn-cancel">Batal</button>
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
        function openModal(id)  { document.getElementById(id).classList.add('show'); }
        function closeModal(id) { document.getElementById(id).classList.remove('show'); }

        document.querySelectorAll('.modal').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
        });

        function hapus(id, title) {
            Swal.fire({
                title: 'Hapus Pengumuman?',
                html: `Pengumuman <b>"${title}"</b> akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then(r => { if (r.isConfirmed) document.getElementById('hapus-ann-' + id).submit(); });
        }

        /* Auto-dismiss alerts */
        setTimeout(() => {
            document.querySelectorAll('.alert-auto').forEach(el => {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 3500);
    </script>
@endpush