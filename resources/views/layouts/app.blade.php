<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | Pengumuman Kelulusan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.4rem 0.6rem;
            font-family: 'Inter', sans-serif;
        }

        table.dataTable thead th {
            background-color: #f9fafb;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .user-dropdown {
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #mobileDrawer {
            transition: transform 0.3s ease;
            transform: translateX(-100%);
        }

        #mobileDrawer.open {
            transform: translateX(0);
        }

        #drawerOverlay {
            transition: opacity 0.3s ease;
            opacity: 0;
            pointer-events: none;
        }

        #drawerOverlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        @media (max-width: 768px) {

            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_length {
                float: none;
                text-align: left;
                margin-bottom: 0.5rem;
            }

            table.dataTable {
                font-size: 13px;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800">

    <div id="drawerOverlay" class="fixed inset-0 bg-black/40 z-30 md:hidden" onclick="closeDrawer()"></div>

    <aside id="mobileDrawer"
        class="fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-200 z-40 flex flex-col md:hidden">
        <div class="h-16 flex items-center justify-between px-5 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 rounded-lg">
                <span class="text-sm font-semibold text-gray-900">Pengumuman</span>
            </div>
            <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="/students" onclick="closeDrawer()"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
               {{ request()->is('students') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fa-solid fa-users w-4 text-center"></i>
                <span>Data Siswa</span>
            </a>
            <a href="/announcements" onclick="closeDrawer()"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
               {{ request()->is('announcements') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fa-brands fa-discord w-4 text-center"></i>
                <span>Tanggal Pengumuman</span>
            </a>
        </nav>
        <div class="px-4 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-3">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=6366f1&color=fff"
                    class="w-8 h-8 rounded-full flex-shrink-0">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500">Signed in as</p>
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex min-h-screen">

        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="h-9 w-9 rounded-lg">
                    <span class="text-sm font-semibold text-gray-900">Pengumuman</span>
                </div>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="/students"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                   {{ request()->is('students') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-users w-4 text-center"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="/announcements"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                   {{ request()->is('announcements') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fa-brands fa-discord w-4 text-center"></i>
                    <span>Tanggal Pengumuman</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col bg-gray-50 min-w-0">

            <header
                class="h-14 sm:h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button onclick="openDrawer()" class="md:hidden text-gray-500 hover:text-gray-700 text-lg p-1">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-base sm:text-lg font-semibold text-gray-900">Admin Panel</h1>
                </div>

                <div class="relative">
                    <button onclick="toggleDropdown()"
                        class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 rounded-lg hover:bg-gray-50 transition-all focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=6366f1&color=fff"
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full">
                        <span class="text-sm font-medium text-gray-700 hidden sm:inline">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
                    </button>

                    <div id="userDropdown"
                        class="user-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden overflow-hidden z-20">
                        <div class="px-4 py-2.5 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Signed in as</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 min-w-0">
                @yield('content')
            </main>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    @stack('scripts')

    <script>
        function openDrawer() {
            document.getElementById('mobileDrawer').classList.add('open');
            document.getElementById('drawerOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            document.getElementById('mobileDrawer').classList.remove('open');
            document.getElementById('drawerOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }

        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonColor: '#6366f1',
                customClass: { popup: 'rounded-xl' }
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error')),
                confirmButtonColor: '#6366f1',
                customClass: { popup: 'rounded-xl' }
            })
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#6366f1',
                customClass: { popup: 'rounded-xl' }
            })
        </script>
    @endif

</body>

</html>