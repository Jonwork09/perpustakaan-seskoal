<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERPUSESKOAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <nav class="fixed w-full z-50 glass border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                    PS</div>
                <span class="text-xl font-bold tracking-tight">PERPUSESKOAL</span>
            </div>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 text-slate-600 font-semibold hover:text-blue-600 transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-5 py-2.5 bg-slate-900 text-white rounded-full font-semibold hover:bg-slate-800 transition">Daftar
                                Siswa</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span
                    class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-bold mb-6">Sistem
                    Perpustakaan Seskoal</span>
                <h1 class="text-5xl lg:text-7xl font-extrabold leading-relaxed mb-6">
                    Pinjam <span class="text-blue-600">Buku</span> Jadi Praktis & Mudah
                </h1>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-lg">
                    Cari buku online, ambil di perpustakaan.
                    Kelola pinjaman dan pantau jadwal pengembalian langsung dari akunmu.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold text-lg hover:scale-105 transition shadow-xl shadow-blue-200">Mulai
                        Membaca</a>
                    <div class="flex items-center gap-3 px-6 py-4 border border-slate-200 rounded-2xl">
                        <span class="font-bold">1.2k+</span>
                        <span class="text-slate-500 text-sm">Buku Tersedia</span>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -z-10 top-0 right-0 w-72 h-72 bg-blue-400 rounded-full blur-[120px] opacity-20">
                </div>
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop"
                    alt="Library" class="rounded-[2.5rem] shadow-2xl border-8 border-white">
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="p-8 rounded-3xl bg-slate-50 hover:bg-blue-50 transition border border-transparent hover:border-blue-100 group">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition">
                        📚</div>
                    <h3 class="text-xl font-bold mb-3">Mudah dan Cepat</h3>
                    <p class="text-slate-600">Cari buku favoritmu dengan fitur filter kategori yang intuitif dan
                        real-time.</p>
                </div>
                <div
                    class="p-8 rounded-3xl bg-slate-50 hover:bg-blue-50 transition border border-transparent hover:border-blue-100 group">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition">
                        🆔</div>
                    <h3 class="text-xl font-bold mb-3">Pengambilan Cerdas</h3>
                    <p class="text-slate-600">Ambil buku dengan verifikasi ID unik tanpa perlu antre lama di meja
                        pustakawan.</p>
                </div>
                <div
                    class="p-8 rounded-3xl bg-slate-50 hover:bg-blue-50 transition border border-transparent hover:border-blue-100 group">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition">
                        ⚡</div>
                    <h3 class="text-xl font-bold mb-3">Up to Date</h3>
                    <p class="text-slate-600">Sistem terintegrasi yang siap mengikuti perkembangan teknologi dunia.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-10 text-center text-slate-500 border-t border-slate-200">
        <p>2026 &copy; Sistem Perpustakaan Seskoal</p>
    </footer>

</body>

</html>
