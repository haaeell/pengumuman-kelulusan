<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel | Pengumuman Siswa</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- DataTables CSS (NO Bootstrap) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" />

    <style>
        /* DataTables + Tailwind tuning */
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.4rem 0.6rem;
        }

        table.dataTable thead th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white hidden md:flex flex-col">
            <div class="h-16 flex items-center px-6 border-b border-slate-700">
                <!-- Logo Sekolah -->
                <img src="https://yt3.googleusercontent.com/aqwnd_6PPBpG0PqWP1QMcBjJZX0GwVYQCmJ0_r0pdJPrAgiqjH3TaxhHCF9a-oHRbhk90Bpz=s900-c-k-c0x00ffffff-no-rj"
                    alt="Logo Sekolah" class="h-10 w-10 rounded-full mr-3 shadow-sm">

                <!-- Teks Pengumuman dengan ikon -->
                <span class="text-lg font-bold tracking-wide flex items-center gap-2">Pengumuman
                </span>
            </div>


            <nav class="flex-1 px-4 py-4 space-y-2">
                {{-- <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-slate-800">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a> --}}

                <a href="/students" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800
                       {{ request()->is('students') ? 'bg-slate-800 text-white' : 'text-gray-200' }}">
                    <i class="fa-solid fa-users"></i>
                    <span class="text-sm font-medium">Data Siswa</span>
                </a>

                <a href="/wa-links" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800
                       {{ request()->is('wa-links') ? 'bg-slate-800 text-white' : 'text-gray-200' }}">
                    <i class="fa-solid fa-whatsapp"></i>
                    <span class="text-sm font-medium">Link Whatsapp</span>
                </a>


                {{-- <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800">
                    <i class="fa-solid fa-gear"></i>
                    <span class="text-sm font-medium">Pengaturan</span>
                </a> --}}
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col">

            <!-- Navbar -->
            <header class="h-16 bg-white shadow flex items-center justify-between px-6">
                <h1 class="text-lg font-semibold">Admin Panel</h1>

                <!-- User Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=2563eb&color=fff"
                            class="w-9 h-9 rounded-full">
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                    </button>

                    <div id="userDropdown" class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow border hidden">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 rounded-lg">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables JS (NO Bootstrap) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    @stack('scripts')

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
    </script>

    {{-- SweetAlert --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success'))
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error'))
            })
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`
            })
        </script>
    @endif

</body>

</html>