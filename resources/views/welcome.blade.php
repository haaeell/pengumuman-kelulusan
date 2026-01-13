<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Pengumuman Siswa Eligible</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            background-image: radial-gradient(circle, rgba(200, 200, 200, 0.05) 1px, transparent 1px);
            background-size: 60px 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .fade-in {
            animation: fadeIn 0.35s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-card {
            border-radius: 1rem;
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .status-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 10px;
        }

        /* Decorative blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
            z-index: 0;
            filter: blur(80px);
            animation: blobMove 20s infinite alternate;
        }

        .blob1 {
            width: 220px;
            height: 220px;
            background: #6366f1;
            top: -60px;
            left: -60px;
        }

        .blob2 {
            width: 300px;
            height: 300px;
            background: #3b82f6;
            bottom: -80px;
            right: -80px;
            animation-delay: 5s;
        }

        .confetti-piece {
            position: fixed;
            pointer-events: none;
            z-index: 50;
            top: -10px;
            opacity: 0.9;
            transform: rotate(0deg);
            animation: confetti-fall linear forwards;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .sparkle {
            position: fixed;
            width: 6px;
            height: 6px;
            background: radial-gradient(circle, #facc15, #f59e0b);
            border-radius: 50%;
            opacity: 0.8;
            pointer-events: none;
            z-index: 55;
            animation: sparkle-fade 0.6s ease-out forwards;
        }

        @keyframes sparkle-fade {
            0% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        @keyframes blobMove {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -20px) scale(1.1);
            }

            100% {
                transform: translate(0, 20px) scale(0.95);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-slow {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        .animate-spin-slow {
            animation: spin-slow 1.5s linear infinite;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-6px);
            }

            40% {
                transform: translateX(6px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* RESPONSIVE */
        @media(max-width:640px) {

            .blob1,
            .blob2 {
                width: 150px;
                height: 150px;
                filter: blur(60px);
            }

            .icon-circle {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }
        }

        @media(min-width:768px) {
            .max-w-md {
                max-width: 480px;
            }
        }

        @media(min-width:1024px) {
            .max-w-md {
                max-width: 540px;
            }
        }
    </style>
</head>

<body>
    <span class="blob blob1"></span>
    <span class="blob blob2"></span>

    <div class="w-full max-w-md fade-in relative z-10">
        <div class="bg-white shadow-2xl rounded-2xl p-6 sm:p-8 md:p-10 border border-gray-100 relative z-10">
            <div class="text-center mb-6 relative z-10">
                <img src="https://yt3.googleusercontent.com/aqwnd_6PPBpG0PqWP1QMcBjJZX0GwVYQCmJ0_r0pdJPrAgiqjH3TaxhHCF9a-oHRbhk90Bpz=s900-c-k-c0x00ffffff-no-rj"
                    alt="Logo Sekolah" class="mx-auto w-20 h-20 sm:w-24 sm:h-24 rounded-full shadow-md mb-3">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">Pengumuman Kelulusan</h2>
                <div class="w-16 sm:w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded mx-auto my-2"></div>
                <p class="text-gray-500 text-sm sm:text-sm">Masukkan NIS untuk melihat status kelulusan siswa.</p>
            </div>

            <form id="cekForm" class="mb-4 relative z-10">
                @csrf
                <!-- Input NIS -->
                <div class="relative mb-4">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <input type="text" id="nis" name="nis" placeholder="Masukkan NIS"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-300 text-center shadow-sm text-sm sm:text-base">
                </div>

                <!-- Input Password -->
                <div class="relative mb-4">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-300 text-center shadow-sm text-sm sm:text-base">
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold hover:from-blue-600 hover:to-indigo-600 shadow-md hover:shadow-lg transition duration-300 text-sm sm:text-base">
                    Cek Hasil
                </button>
            </form>


            <div id="loading" class="text-center mt-4 hidden relative">
                <div class="relative w-14 h-14 mx-auto">
                    <div class="absolute inset-0 rounded-full border-4 border-blue-300 border-t-blue-500 animate-spin">
                    </div>
                    <div
                        class="absolute inset-2 rounded-full border-2 border-blue-200 border-t-blue-400 animate-spin-slow">
                    </div>
                </div>
                <div class="text-gray-400 text-sm mt-2">Memeriksa data...</div>
            </div>

            <div id="result" class="mt-4 hidden"></div>

            <div class="text-center mt-6 text-gray-400 text-xs sm:text-sm relative z-10">
                © {{ date('Y') }} Pengumuman
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.getElementById('cekForm');
        const loading = document.getElementById('loading');
        const result = document.getElementById('result');
        const submitBtn = form.querySelector('button[type="submit"]');

        function celebrate() {
            const colors = ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#a855f7'];
            for (let i = 0; i < 150; i++) {
                const confetti = document.createElement('div');
                confetti.classList.add('confetti-piece');
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.width = confetti.style.height = (Math.random() * 8 + 4) + 'px';
                confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                document.body.appendChild(confetti);
                setTimeout(() => confetti.remove(), 3000);
            }

            const sparkleCount = 30;
            for (let i = 0; i < sparkleCount; i++) {
                const sparkle = document.createElement('div');
                sparkle.classList.add('sparkle');
                sparkle.style.left = (window.innerWidth / 2 + (Math.random() - 0.5) * 200) + 'px';
                sparkle.style.top = (window.innerHeight / 2 + (Math.random() - 0.5) * 200) + 'px';
                sparkle.style.animationDuration = (Math.random() * 0.6 + 0.4) + 's';
                document.body.appendChild(sparkle);
                setTimeout(() => sparkle.remove(), 600);
            }
            const audio = new Audio('https://freesound.org/data/previews/414/414209_5121236-lq.mp3');
            audio.volume = 0.5;
            audio.play().catch(() => { });
        }

        function sadEffect(card) {
            card.classList.add('shake');
            setTimeout(() => card.classList.remove('shake'), 500);
        }

        function confirmStatus(nis, statusValue) {
            Swal.fire({
                title: `Yakin ingin memilih "${statusValue}"?`,
                text: "Perubahan ini akan langsung disimpan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-green-500 text-white hover:bg-green-600 py-2 px-4 rounded',
                    cancelButton: 'bg-gray-300 text-gray-800 hover:bg-gray-400 py-2 px-4 rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(nis, statusValue);
                }
            });
        }


        function updateStatus(nis, statusValue) {
            fetch("{{ route('student.updateStatus') }}", {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ nis, status: statusValue })
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Status siswa diubah menjadi "${statusValue}"`,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        form.dispatchEvent(new Event('submit'));
                    } else {
                        Swal.fire('Gagal', 'Tidak bisa memperbarui status.', 'error');
                    }
                })
                .catch(() => Swal.fire('Error', 'Terjadi kesalahan saat mengubah status.', 'error'));
        }



        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const nis = document.getElementById('nis').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!nis || !password) {
                result.classList.remove('hidden');
                result.innerHTML = `
                    <div class="status-card bg-yellow-100 text-yellow-600 text-center">
                        <div class="icon-circle bg-yellow-600 text-white">
                            <i class="bi bi-exclamation-lg"></i>
                        </div>
                        <h6 class="font-bold mb-1">Input Kosong</h6>
                        <small>Silakan masukkan NIS dan Password terlebih dahulu.</small>
                    </div>`;
                return;
            }

            loading.classList.remove('hidden');
            result.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            fetch("{{ route('student.check') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ nis, password }),
            })
                .then(res => res.json())
                .then(res => {
                    loading.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    result.classList.remove('hidden');

                    if (res.status === 'not_found') {
                        result.innerHTML = `
            <div id="failCard" class="status-card bg-red-100 text-red-600 text-center">
                <div class="icon-circle bg-red-600 text-white">
                    <i class="bi bi-x-lg"></i>
                </div>
                <h6 class="font-bold mb-1">Data Tidak Ditemukan</h6>
                <small>NIS tidak terdaftar.</small>
            </div>`;
                        sadEffect(document.getElementById('failCard'));
                        return;
                    }

                    if (res.status === 'wrong_password') {
                        result.innerHTML = `
            <div id="failCard" class="status-card bg-red-100 text-red-600 text-center">
                <div class="icon-circle bg-red-600 text-white">
                    <i class="bi bi-lock-fill"></i>
                </div>
                <h6 class="font-bold mb-1">Password Salah</h6>
                <small>Password yang Anda masukkan tidak sesuai.</small>
            </div>`;
                        sadEffect(document.getElementById('failCard'));
                        return;
                    }

                    let status = 'info';
                    const infoText = (res.data.information || '').toLowerCase();

                    if (infoText.includes('tidak eligible')) {
                        status = 'danger';
                    } else if (infoText.includes('eligible')) {
                        status = 'success';
                    }

                    const map = {
                        success: {
                            card: 'bg-green-100 text-green-600',
                            iconBg: 'bg-green-600',
                            icon: 'bi-check-lg',
                            title: 'Selamat!',
                            definition: 'Yeay, kamu lolos! Siap lanjut ke tahap berikutnya 😊'
                        },
                        danger: {
                            card: 'bg-red-100 text-red-600',
                            iconBg: 'bg-red-600',
                            icon: 'bi-x-lg',
                            title: 'Mohon Maaf',
                            definition: 'Ups, belum berhasil kali ini 😢 Tapi jangan menyerah ya!'
                        },
                        info: {
                            card: 'bg-blue-100 text-blue-600',
                            iconBg: 'bg-blue-600',
                            icon: 'bi-info-lg',
                            title: 'Cadangan',
                            definition: 'Kamu masuk daftar cadangan, siapa tahu ada yang mengundurkan diri ✨'
                        }
                    };


                    const cfg = map[status];

                    let actionButtons = '';

                    // Tampilkan tombol hanya jika status masih null / kosong / cadangan / eligible
                    if ((status === 'success' || status === 'info') && (!res.data.status || res.data.status
                        .toLowerCase() == 'pending')) {
                        actionButtons = `
       <div class="flex gap-2 mt-3">
    <button class="w-1/2 py-2 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 transition"
        onclick="confirmStatus('${res.data.nis}', 'diterima')">Terima</button>
    <button class="w-1/2 py-2 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transition"
        onclick="confirmStatus('${res.data.nis}', 'ditolak')">Tolak</button>
</div>`;
                    } else if (res.data.status && status != 'danger') {
                        actionButtons = `
        <div class="mt-3 text-center text-gray-700 font-semibold">
            Status siswa: <span class="text-blue-600">${res.data.status}</span>
        </div>`;
                    }

                    let waLink = '';
                    if (status === 'success' && res.data.status == 'diterima' && res.data.wa_link_eligible) {
                        waLink = `<div class="mt-3 text-center">
        <a href="${res.data.wa_link_eligible}" target="_blank"
            class="inline-block px-4 py-2 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 transition">
            <i class="bi bi-whatsapp me-1"></i> Join Grup WA Eligible
        </a>
    </div>`;
                    } else if (status === 'info' && res.data.status == 'diterima' && res.data.wa_link_cadangan) {
                        waLink = `<div class="mt-3 text-center">
        <a href="${res.data.wa_link_cadangan}" target="_blank"
            class="inline-block px-4 py-2 rounded-xl bg-blue-500 text-white font-semibold hover:bg-blue-600 transition">
            <i class="bi bi-whatsapp me-1"></i> Join Grup WA Cadangan
        </a>
    </div>`;
                    }



                    result.innerHTML = `
        <div id="card" class="status-card ${cfg.card}">
            <div class="icon-circle ${cfg.iconBg} text-white">
                <i class="bi ${cfg.icon}"></i>
            </div>

            <div class="text-center mb-4 px-2">
                <h5 class="font-bold text-sm sm:text-base">${cfg.title}</h5>
                <p class="text-xs sm:text-sm mt-1 leading-relaxed">
                    ${res.data.information}
                </p>
                <p class="text-xs sm:text-sm mt-1 leading-relaxed">
                    ${cfg.definition}
                </p>
            </div>

            <div class="border-2 rounded-xl p-3 bg-white text-gray-800 text-xs sm:text-sm shadow-sm
                ${status === 'success' ? 'border-green-500' : status === 'danger' ? 'border-red-500' : 'border-blue-500'}">
                <dl class="grid grid-cols-2 gap-2">
                    <dt class="text-gray-400"><i class="bi bi-person-fill me-1"></i> Nama</dt>
                    <dd class="font-semibold">: ${res.data.nama}</dd>

                    <dt class="text-gray-400"><i class="bi bi-mortarboard-fill me-1"></i> Kelas</dt>
                    <dd class="font-semibold">: ${res.data.kelas}</dd>

                    <dt class="text-gray-400"><i class="bi bi-bar-chart-fill me-1"></i> Total Nilai</dt>
                    <dd class="font-semibold">: ${res.data.total_score}</dd>

                    <dt class="text-gray-400"><i class="bi bi-star-fill me-1"></i> Nilai Rata-rata</dt>
                    <dd class="font-semibold">: ${res.data.average_score}</dd>

                    <dt class="text-gray-400"><i class="bi bi-trophy-fill me-1"></i> Ranking</dt>
                    <dd class="font-semibold">: ${res.data.ranking}</dd>
                </dl>
            </div>
                  ${actionButtons}
                  ${waLink}
        </div>`;

                    const card = document.getElementById('card');
                    if (status === 'success') celebrate();
                    if (status === 'danger') sadEffect(card);
                })
                .catch(() => {
                    loading.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    result.classList.remove('hidden');
                    result.innerHTML = `<p class="text-red-500 text-center">Terjadi kesalahan.</p>`;
                });
        });
    </script>
</body>

</html>