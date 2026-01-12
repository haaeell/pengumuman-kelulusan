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
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">Pengumuman Kelulusan</h2>
                <div class="w-16 sm:w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded mx-auto my-2"></div>
                <p class="text-gray-500 text-sm sm:text-sm">Masukkan NIS untuk melihat status kelulusan siswa.</p>
            </div>

            <form id="cekForm" class="mb-4 relative z-10">
                @csrf
                <div class="relative mb-4">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <input type="text" id="nis" name="nis" placeholder="Masukkan NIS"
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
                © {{ date('Y') }} Sistem Informasi Sekolah
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('cekForm');
        const loading = document.getElementById('loading');
        const result = document.getElementById('result');
        const submitBtn = form.querySelector('button[type="submit"]');

        function celebrate() {
            const confettiColors = ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#a855f7'];
            for (let i = 0; i < 150; i++) {
                const confetti = document.createElement('div');
                confetti.classList.add('confetti-piece');
                confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.width = confetti.style.height = (Math.random() * 8 + 4) + 'px';
                confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
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
            const audio = new Audio('https://freesound.org/data/previews/341/341695_62492-lq.mp3');
            audio.volume = 0.4;
            audio.play().catch(() => { });
            setTimeout(() => card.classList.remove('shake'), 500);
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const nisInput = document.getElementById('nis');
            const nis = nisInput.value.trim();

            if (!nis) {
                result.classList.remove('hidden');
                result.innerHTML = `<div class="status-card bg-yellow-100 text-yellow-600 text-center">
        <div class="icon-circle bg-yellow-600 text-white"><i class="bi bi-exclamation-lg"></i></div>
        <h6 class="font-bold mb-1">Input Kosong</h6>
        <small>Silakan masukkan NIS sebelum mengecek.</small>
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
                body: JSON.stringify({ nis }),
            })
                .then(res => res.json())
                .then(res => {
                    loading.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    result.classList.remove('hidden');

                    if (res.status === 'not_found') {
                        result.innerHTML = `<div id="failCard" class="status-card bg-red-100 text-red-600 text-center">
                <div class="icon-circle bg-red-600 text-white"><i class="bi bi-x-lg"></i></div>
                <h6 class="font-bold mb-1">Data Tidak Ditemukan</h6>
                <small>NIS tidak terdaftar. Periksa kembali atau hubungi sekolah.</small>
            </div>`;
                        const failCard = document.getElementById('failCard');
                        sadEffect(failCard);
                    } else {
                        const eligible = res.data.is_eligible;
                        result.innerHTML = `<div id="card" class="status-card ${eligible ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'}">
                <div class="icon-circle ${eligible ? 'bg-green-600' : 'bg-red-600'} text-white">
                <i class="bi ${eligible ? 'bi-check-lg' : 'bi-x-lg'}"></i></div>
                <div class="text-center mb-4 px-2">
                    <h5 class="font-bold text-sm sm:text-base">${eligible ? 'Selamat!' : 'Mohon Maaf'}</h5>
                    <p class="text-xs sm:text-sm mt-1 leading-relaxed">
                    ${eligible ? 'Anda dinyatakan <strong>ELIGIBLE</strong> dan berhak melanjutkan ke tahap berikutnya.' : 'Anda saat ini <strong>belum memenuhi kriteria kelulusan</strong>. Jangan berkecil hati dan tetap semangat.'}
                    </p>
                </div>
                <div class="border-2 border-${eligible ? 'green' : 'red'} rounded-xl p-3 bg-white text-gray-800 text-xs sm:text-sm shadow-sm">
                    <dl class="grid grid-cols-2 gap-2 mb-0">
                        <dt class="text-gray-400 text-xs sm:text-sm"><i class="bi bi-person-fill me-1"></i> Nama</dt>
                        <dd class="font-semibold text-xs sm:text-sm">: ${res.data.nama}</dd>
                        <dt class="text-gray-400 text-xs sm:text-sm"><i class="bi bi-mortarboard-fill me-1"></i> Kelas</dt>
                        <dd class="font-semibold text-xs sm:text-sm">: ${res.data.kelas}</dd>
                        <dt class="text-gray-400 text-xs sm:text-sm"><i class="bi bi-bar-chart-fill me-1"></i> Nilai Akhir</dt>
                        <dd class="font-semibold text-xs sm:text-sm">: ${res.data.final_score}</dd>
                    </dl>
                </div>
                ${eligible ? `<form method="POST" action="{{ route('student.print') }}" class="mt-3 text-center">
                    @csrf
                    <input type="hidden" name="nis" value="${res.data.nis}">
                    <button type="submit" class="w-full py-2 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold hover:from-blue-600 hover:to-indigo-600 shadow transition duration-300 text-sm sm:text-base">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                    </button>
                </form>`: ''}
            </div>`;
                        const card = document.getElementById('card');
                        eligible ? celebrate() : sadEffect(card);
                    }
                })
                .catch(err => {
                    loading.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    result.classList.remove('hidden');
                    result.innerHTML = `<p class="text-red-500 text-center">Terjadi kesalahan. Silakan coba lagi.</p>`;
                    console.error(err);
                });
        });
    </script>
</body>

</html>