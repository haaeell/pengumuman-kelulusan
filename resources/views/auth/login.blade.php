<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Pengumuman Kelulusan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            transition: all 0.2s;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }

        .btn-gradient:active {
            transform: translateY(0);
        }

        .input-focus:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .blob-1 {
            position: absolute;
            top: -80px;
            left: -80px;
            width: 260px;
            height: 260px;
            background: rgba(99, 102, 241, 0.25);
            border-radius: 50%;
            filter: blur(40px);
        }

        .blob-2 {
            position: absolute;
            bottom: -80px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: rgba(59, 130, 246, 0.2);
            border-radius: 50%;
            filter: blur(40px);
        }

        .blob-3 {
            position: absolute;
            top: 40%;
            left: 50%;
            width: 160px;
            height: 160px;
            background: rgba(99, 102, 241, 0.15);
            border-radius: 50%;
            filter: blur(30px);
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <div class="w-full md:w-1/2 p-8 sm:p-10 md:p-12 flex flex-col justify-center">

            <div class="flex items-center gap-3 mb-8">
                <img src="https://yt3.googleusercontent.com/aqwnd_6PPBpG0PqWP1QMcBjJZX0GwVYQCmJ0_r0pdJPrAgiqjH3TaxhHCF9a-oHRbhk90Bpz=s900-c-k-c0x00ffffff-no-rj"
                    class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="Logo">
                <div>
                    <div class="text-xs font-semibold text-gray-800 leading-tight">SMA Plus Asthahannas</div>
                    <div class="text-[10px] text-gray-400 leading-tight">Pengumuman Kelulusan</div>
                </div>
            </div>

            <div class="mb-7">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[10px] font-semibold tracking-widest uppercase bg-blue-50 text-blue-600 border border-blue-100 mb-4">
                    <i class="fa-solid fa-shield-halved"></i>
                    Admin Panel
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-1">
                    Selamat Datang, <span class="gradient-text">Admin</span>
                </h1>
                <p class="text-sm text-gray-400">Masukkan kredensial untuk mengakses dashboard.</p>
            </div>

            @if ($errors->any())
                <div
                    class="flex items-center gap-2 px-4 py-3 rounded-xl bg-red-50 border border-red-100 text-red-500 text-sm font-medium mb-5">
                    <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="flex items-center gap-2 px-4 py-3 rounded-xl bg-red-50 border border-red-100 text-red-500 text-sm font-medium mb-5">
                    <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label
                        class="block text-[10px] sm:text-[11px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Email</label>
                    <div class="relative">
                        <i
                            class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="email" name="email" placeholder="admin@sekolah.sch.id" value="{{ old('email') }}"
                            class="input-focus w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 bg-slate-50 text-sm text-gray-800 placeholder-gray-300 transition-all"
                            required autocomplete="email">
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[10px] sm:text-[11px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Password</label>
                    <div class="relative">
                        <i
                            class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="password" name="password" id="passwordInput" placeholder="Masukkan password"
                            class="input-focus w-full pl-9 pr-10 py-2.5 rounded-xl border border-gray-200 bg-slate-50 text-sm text-gray-800 placeholder-gray-300 transition-all"
                            required autocomplete="current-password">
                        <button type="button" onclick="togglePw()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 text-xs transition-colors bg-transparent border-none cursor-pointer">
                            <i class="fa-regular fa-eye" id="pwIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="btn-gradient w-full py-3 rounded-xl text-white text-sm font-semibold flex items-center justify-center gap-2 mt-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk ke Dashboard
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} · Sistem Pengumuman Kelulusan
            </p>

        </div>

        <div
            class="hidden md:flex w-full md:w-1/2 relative bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 flex-col items-center justify-center p-12 overflow-hidden">
            <div class="blob-1"></div>
            <div class="blob-2"></div>
            <div class="blob-3"></div>

            <div class="relative z-10 text-center text-white">
                <div
                    class="w-20 h-20 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <img src="https://yt3.googleusercontent.com/aqwnd_6PPBpG0PqWP1QMcBjJZX0GwVYQCmJ0_r0pdJPrAgiqjH3TaxhHCF9a-oHRbhk90Bpz=s900-c-k-c0x00ffffff-no-rj"
                        class="w-12 h-12 rounded-xl object-cover" alt="Logo">
                </div>

                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-[10px] font-semibold tracking-widest uppercase text-white/80 mb-5 backdrop-blur-sm">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Tahun Pelajaran {{ date('Y') - 1 }}/{{ date('Y') }}
                </div>

                <h2 class="text-2xl md:text-3xl font-bold leading-tight mb-3">
                    Sistem Pengumuman<br>Kelulusan Siswa
                </h2>
                <p class="text-sm text-white/70 leading-relaxed max-w-xs mx-auto">
                    Kelola data siswa, atur tanggal pengumuman, dan pantau hasil kelulusan secara terpusat.
                </p>
            </div>
        </div>

    </div>

    <script>
        function togglePw() {
            const inp = document.getElementById('passwordInput');
            const icon = document.getElementById('pwIcon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.className = 'fa-regular fa-eye-slash';
            } else {
                inp.type = 'password';
                icon.className = 'fa-regular fa-eye';
            }
        }
    </script>

</body>

</html>