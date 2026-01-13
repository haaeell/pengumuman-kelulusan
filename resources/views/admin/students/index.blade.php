@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">Data Siswa</h2>
                <p class="text-sm text-gray-500">Manajemen data siswa & kelulusan</p>
            </div>

            <div class="flex gap-2">
                <button onclick="openModal('importModal')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-green-600 text-green-600 hover:bg-green-50">
                    <i class="fa-solid fa-file-excel"></i>
                    <span>Import Excel</span>
                </button>
                <button onclick="resetData()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-red-600 text-red-600 hover:bg-red-50">
                    <i class="fa-solid fa-trash"></i>
                    <span>Reset Data</span>
                </button>

                <form id="reset-form" method="POST" action="{{ route('students.reset') }}">
                    @csrf
                    @method('DELETE')
                </form>

                <button onclick="openModal('addModal')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tambah Siswa</span>
                </button>

            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Jumlah Siswa -->
            <div class="bg-blue-50 border border-blue-600 rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">Jumlah Siswa</p>
                    <h3 class="text-2xl font-bold">{{ $students->count() }}</h3>
                </div>
                <i class="fa-solid fa-users text-3xl text-blue-600"></i>
            </div>

            <!-- Eligible -->
            <div class="bg-green-50 border border-green-600 rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">Eligible</p>
                    <h3 class="text-2xl font-bold">{{ $students->where('is_eligible', 1)->count() }}</h3>
                </div>
                <i class="fa-solid fa-check-circle text-3xl text-green-600"></i>
            </div>

            <!-- Cadangan -->
            <div class="bg-yellow-50 border border-yellow-600 rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">Cadangan</p>
                    <h3 class="text-2xl font-bold">
                        {{ $students->whereNotIn('information', ['ELIGIBLE', 'TIDAK ELIGIBLE'])->count() }}
                    </h3>
                </div>
                <i class="fa-solid fa-question-circle text-3xl text-yellow-600"></i>
            </div>

            <!-- Tidak Eligible -->
            <div class="bg-red-50 border border-red-600 rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">Tidak Eligible</p>
                    <h3 class="text-2xl font-bold">{{ $students->where('is_eligible', 0)->count() }}</h3>
                </div>
                <i class="fa-solid fa-xmark-circle text-3xl text-red-600"></i>
            </div>

        </div>
        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow overflow-hidden p-5">
            <table class="w-full text-sm" id="studentsTable">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">NIS</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3 text-nowrap">Total Nilai</th>
                        <th class="px-4 py-3 text-nowrap">Rata Rata</th>
                        <th class="px-4 py-3">Ranking</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $s)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $s->nis }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $s->nama }}</td>
                            <td class="px-4 py-3">{{ $s->kelas }}</td>

                            <td class="px-4 py-3">{{ $s->total_score }}</td>
                            <td class="px-4 py-3">{{ number_format($s->average_score, 2) }}</td>
                            <td class="px-4 py-3">{{ $s->ranking }}</td>

                            <!-- KETERANGAN -->
                            <td class="px-4 py-3">
                                @if ($s->information == 'ELIGIBLE')
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                        ELIGIBLE
                                    </span>
                                @elseif($s->information == 'TIDAK ELIGIBLE')
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                        TIDAK ELIGIBLE
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs text-nowrap bg-yellow-100 text-yellow-700">
                                        {{ $s->information }}
                                    </span>
                                @endif
                            </td>

                            <!-- STATUS SISWA -->
                            <td class="px-4 py-3">
                                @if ($s->information != 'TIDAK ELIGIBLE')
                                    @if ($s->status === 'diterima')
                                        <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                            DITERIMA
                                        </span>
                                    @elseif($s->status === 'ditolak')
                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                            DITOLAK
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                            PENDING
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center space-x-1 flex">
                                <button onclick="openModal('edit{{ $s->id }}')"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200"
                                    title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <button onclick="hapus({{ $s->id }})"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-600 hover:bg-red-200"
                                    title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>

                                <form id="hapus-{{ $s->id }}" method="POST"
                                    action="{{ route('students.destroy', $s->id) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- MODAL TAMBAH -->
    <div id="addModal" class="modal">
        <form method="POST" action="{{ route('students.store') }}" class="modal-box">
            @csrf
            <h3 class="font-bold mb-4">Tambah Siswa</h3>

            <div class="space-y-3">

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-id-card text-gray-500"></i>
                        NIS / Username
                    </label>
                    <input name="nis" class="input" placeholder="Masukkan NIS / Username" required>
                </div>

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-user text-gray-500"></i>
                        Nama Lengkap
                    </label>
                    <input name="nama" class="input" placeholder="Masukkan nama lengkap" required>
                </div>

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-school text-gray-500"></i>
                        Kelas
                    </label>
                    <input name="kelas" class="input" placeholder="Contoh: XII-2" required>
                </div>

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-square-poll-horizontal text-gray-500"></i>
                        Total Nilai
                    </label>
                    <input name="total_score" class="input" type="number" step="0.01"
                        placeholder="Total nilai siswa" required>
                </div>

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-chart-line text-gray-500"></i>
                        Rata-rata Nilai
                    </label>
                    <input name="average_score" class="input" type="number" step="0.01"
                        placeholder="Nilai rata-rata" required>
                </div>

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-ranking-star text-gray-500"></i>
                        Ranking
                    </label>
                    <input name="ranking" class="input" type="number" placeholder="Peringkat siswa" required>
                </div>

                <div>
                    <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-circle-info text-gray-500"></i>
                        Keterangan
                    </label>
                    <input name="information" class="input" type="text" placeholder="Keterangan tambahan" required>
                </div>

            </div>


            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('addModal')" class="btn-secondary">Batal</button>
                <button class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <!-- MODAL IMPORT EXCEL -->
    <div id="importModal" class="modal">
        <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data"
            class="modal-box w-full max-w-5xl">
            @csrf

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <i class="fa-solid fa-file-excel text-green-600"></i>
                    Import Data Siswa
                </h3>

                <button type="button" onclick="closeModal('importModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- BODY -->

            <!-- STEP 1 -->
            <div class="border rounded-lg p-4 mb-4 bg-green-50">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-download text-green-600 text-2xl"></i>
                    <div>
                        <h6 class="font-semibold mb-1">
                            Langkah 1 — Download Template
                        </h6>
                        <p class="text-sm text-gray-600 mb-2">
                            Gunakan template resmi agar format data sesuai sistem.
                        </p>

                        <a href="{{ route('students.template') }}"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700">
                            <i class="fa-solid fa-file-arrow-down"></i>
                            Download Template Excel
                        </a>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div>
                <h6 class="font-semibold mb-2">
                    Langkah 2 — Upload File Excel
                </h6>

                <div class="border rounded-lg p-6 text-center bg-white">
                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400"></i>

                    <p class="mt-3 mb-1 font-semibold">
                        Pilih file Excel
                    </p>

                    <p class="text-sm text-gray-500 mb-3">
                        Format yang didukung: <b>.xlsx</b>, <b>.xls</b>
                    </p>

                    <input type="file" name="file" accept=".xlsx,.xls" required class="input">

                    <small class="text-gray-500 block mt-2">
                        Kolom wajib:
                        <b>NIS, Nama, Kelas, Nilai Akhir</b>
                    </small>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="flex justify-end gap-2 mt-6 border-t pt-4">
                <button type="button" onclick="closeModal('importModal')" class="btn-secondary">
                    Batal
                </button>

                <button type="submit" id="btnImport"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">

                    <svg id="importSpinner" class="hidden w-5 h-5 animate-spin text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z">
                        </path>
                    </svg>

                    <span id="importText">Import Data</span>
                </button>

            </div>
        </form>
    </div>


    @foreach ($students as $s)
        <div id="edit{{ $s->id }}" class="modal">
            <form method="POST" action="{{ route('students.update', $s->id) }}" class="modal-box">
                @csrf
                @method('PUT')

                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-pen text-yellow-500"></i>
                    Edit Siswa
                </h3>

                <div class="space-y-3">

                    <!-- NIS -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-id-card text-gray-500"></i>
                            NIS
                        </label>
                        <input name="nis" class="input" type="text" value="{{ $s->nis }}"
                            placeholder="NIS" required>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-user text-gray-500"></i>
                            Nama
                        </label>
                        <input name="nama" class="input" type="text" value="{{ $s->nama }}"
                            placeholder="Nama" required>
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-school text-gray-500"></i>
                            Kelas
                        </label>
                        <input name="kelas" class="input" type="text" value="{{ $s->kelas }}"
                            placeholder="Kelas" required>
                    </div>

                    <!-- Total Nilai -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-square-poll-horizontal text-gray-500"></i>
                            Total Nilai
                        </label>
                        <input name="total_score" class="input" type="number" step="0.01"
                            value="{{ $s->total_score }}" placeholder="Total Nilai">
                    </div>

                    <!-- Rata-rata Nilai -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-chart-line text-gray-500"></i>
                            Rata-rata Nilai
                        </label>
                        <input name="average_score" class="input" type="number" step="0.01"
                            value="{{ $s->average_score }}" placeholder="Rata-rata Nilai">
                    </div>

                    <!-- Ranking -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-ranking-star text-gray-500"></i>
                            Ranking
                        </label>
                        <input name="ranking" class="input" type="number" value="{{ $s->ranking }}"
                            placeholder="Ranking">
                    </div>

                    <!-- Keterangan / Informasi -->
                    <div>
                        <label class="text-sm font-semibold flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-circle-info text-gray-500"></i>
                            Keterangan
                        </label>
                        <input name="information" class="input" type="text" value="{{ $s->information }}"
                            placeholder="Keterangan tambahan" required>
                    </div>

                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal('edit{{ $s->id }}')" class="btn-secondary">
                        Batal
                    </button>
                    <button class="btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        const importForm = document.querySelector('#importModal form')
        const btnImport = document.getElementById('btnImport')
        const spinner = document.getElementById('importSpinner')
        const importText = document.getElementById('importText')

        if (importForm) {
            importForm.addEventListener('submit', function() {
                btnImport.disabled = true
                btnImport.classList.add('opacity-70', 'cursor-not-allowed')

                spinner.classList.remove('hidden')
                importText.textContent = 'Mengimpor...'
            })
        }

        $(document).ready(function() {
            $('#studentsTable').DataTable({
                pageLength: 10,
                order: [
                    [6, 'asc']
                ],
            });
        });

        function openModal(id) {
            document.getElementById(id).classList.add('show')
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('show')
        }

        function resetData() {
            Swal.fire({
                title: 'Reset semua data?',
                text: 'Semua data siswa akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal'
            }).then(r => {
                if (r.isConfirmed) {
                    document.getElementById('reset-form').submit()
                }
            })
        }


        function hapus(id) {
            Swal.fire({
                title: 'Yakin hapus?',
                text: 'Data tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus'
            }).then(r => {
                if (r.isConfirmed) {
                    document.getElementById('hapus-' + id).submit()
                }
            })
        }
    </script>

    <style>
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex
        }

        .modal-box {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 100%;
            max-width: 820px;
        }

        .input {
            width: 100%;
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            padding: 8px 14px;
            border-radius: 8px
        }

        .btn-secondary {
            background: #e5e7eb;
            padding: 8px 14px;
            border-radius: 8px
        }
    </style>
@endpush
