@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Data Siswa</h4>
                <small class="text-muted">Manajemen data siswa & kelulusan</small>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
                </button>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Siswa
                </button>
            </div>
        </div>
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">

                    <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- HEADER --}}
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="importModalLabel">
                                <i class="bi bi-file-earmark-excel text-success me-1"></i>
                                Import Data Siswa
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        {{-- BODY --}}
                        <div class="modal-body">

                            {{-- STEP 1 --}}
                            <div class="border rounded p-3 mb-4 bg-light">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="bi bi-download fs-4 text-success"></i>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Langkah 1 — Download Template</h6>
                                        <p class="mb-2 text-muted small">
                                            Gunakan template resmi agar format data sesuai sistem.
                                        </p>
                                        <a href="{{ route('students.template') }}" class="btn btn-sm btn-success">
                                            <i class="bi bi-file-earmark-arrow-down me-1"></i>
                                            Download Template Excel
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- STEP 2 --}}
                            <div>
                                <h6 class="fw-semibold mb-2">Langkah 2 — Upload File Excel</h6>

                                <div class="border rounded p-4 text-center bg-white">
                                    <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>

                                    <p class="mt-2 mb-1 fw-semibold">
                                        Pilih file Excel
                                    </p>

                                    <p class="text-muted small mb-3">
                                        Format yang didukung: <b>.xlsx</b>, <b>.xls</b>
                                    </p>

                                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                                    <small class="text-muted d-block mt-2">
                                        Kolom wajib: <b>NIS, Nama, Kelas, Nilai Akhir</b>
                                    </small>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-upload me-1"></i>
                                Import Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-3 mb-4">
            <div class="col-8">
                <div class="row">

                    {{-- Jumlah Siswa --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100"
                            style="background-color: #e5f3ff; border: 2px solid #0068e6; color: #111;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="fw-semibold mb-1">Jumlah Siswa</h6>
                                    <h3 class="fw-bold">{{ $students->count() }}</h3>
                                </div>
                                <i class="bi bi-people-fill fs-1" style="color:#0068e6; opacity:0.8;"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Eligible --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100"
                            style="background-color: #d1fae5; border: 2px solid #16a34a; color: #111;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="fw-semibold mb-1">Eligible</h6>
                                    <h3 class="fw-bold">{{ $students->where('is_eligible', 1)->count() }}</h3>
                                </div>
                                <i class="bi bi-check-circle-fill fs-1" style="color:#16a34a; opacity:0.8;"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Tidak Eligible --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100"
                            style="background-color: #ffe4e6; border: 2px solid #dc2626; color: #111;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="fw-semibold mb-1">Tidak Eligible</h6>
                                    <h3 class="fw-bold">{{ $students->where('is_eligible', 0)->count() }}</h3>
                                </div>
                                <i class="bi bi-x-circle-fill fs-1" style="color:#dc2626; opacity:0.8;"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        {{-- CARD TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="studentsTable" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th class="text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $s)
                                <tr>
                                    <td>{{ $s->nis }}</td>
                                    <td class="fw-semibold">{{ $s->nama }}</td>
                                    <td>{{ $s->kelas }}</td>
                                    <td>{{ $s->final_score }}</td>
                                    <td>
                                        @if ($s->is_eligible)
                                            <span class="badge bg-success-subtle text-success">
                                                ELIGIBLE
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">
                                                TIDAK
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $s->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger" onclick="hapus({{ $s->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <form id="hapus-{{ $s->id }}"
                                            action="{{ route('students.destroy', $s->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="editModal{{ $s->id }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('students.update', $s->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Edit Siswa</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- NIS -->
                                                    <div class="mb-3">
                                                        <label class="form-label">NIS</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-card-text"></i></span>
                                                            <input type="text" class="form-control" name="nis"
                                                                value="{{ $s->nis }}" placeholder="Masukkan NIS">
                                                        </div>
                                                    </div>

                                                    <!-- Nama -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-person"></i></span>
                                                            <input type="text" class="form-control" name="nama"
                                                                value="{{ $s->nama }}" placeholder="Masukkan Nama">
                                                        </div>
                                                    </div>

                                                    <!-- Kelas -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-journal-bookmark"></i></span>
                                                            <input type="text" class="form-control" name="kelas"
                                                                value="{{ $s->kelas }}" placeholder="Masukkan Kelas">
                                                        </div>
                                                    </div>

                                                    <!-- Nilai Akhir -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Nilai Akhir</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-calculator"></i></span>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="final_score" value="{{ $s->final_score }}"
                                                                placeholder="Masukkan Nilai Akhir">
                                                        </div>
                                                    </div>

                                                    <!-- Status Kelulusan -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Status Kelulusan</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_eligible" value="1"
                                                                {{ $s->is_eligible ? 'checked' : '' }}>
                                                            <label class="form-check-label">Eligible / Lulus</label>
                                                        </div>
                                                        <small class="text-muted">
                                                            Jika tidak dicentang, status otomatis <b>Tidak Eligible</b>
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Data siswa belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- NIS -->
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-card-text"></i>
                                </span>
                                <input type="text" class="form-control" name="nis" placeholder="Masukkan NIS">
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama">
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-journal-bookmark"></i>
                                </span>
                                <input type="text" class="form-control" name="kelas" placeholder="Masukkan Kelas">
                            </div>
                        </div>

                        <!-- Nilai Akhir -->
                        <div class="mb-3">
                            <label class="form-label">Nilai Akhir</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calculator"></i>
                                </span>
                                <input type="number" step="0.01" class="form-control" name="final_score"
                                    placeholder="Masukkan Nilai Akhir">
                            </div>
                        </div>

                        <!-- Status Kelulusan -->
                        <div class="mb-3">
                            <label class="form-label">Status Kelulusan</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_eligible" value="1">
                                <label class="form-check-label">
                                    Eligible / Lulus
                                </label>
                            </div>
                            <small class="text-muted">
                                Jika tidak dicentang, status otomatis <b>Tidak Eligible</b>
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#studentsTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    ordering: true,
                    responsive: true,
                    autoWidth: false,
                    language: {
                        search: "Cari:",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        infoFiltered: "(difilter dari _MAX_ data)",
                        paginate: {
                            next: "›",
                            previous: "‹"
                        }
                    },
                    columnDefs: [{
                            orderable: false,
                            targets: 5
                        } // kolom aksi
                    ]
                });

                function hapus(id) {
                    Swal.fire({
                        title: 'Yakin hapus?',
                        text: 'Data tidak bisa dikembalikan',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('hapus-' + id).submit();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
