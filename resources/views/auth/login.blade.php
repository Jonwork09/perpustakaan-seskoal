<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERPUSESKOAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md">
        <a href="/" class="flex items-center gap-2 justify-center mb-8">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                PS</div>
            <span class="text-2xl font-bold tracking-tight text-slate-900">PERPUSESKOAL</span>
        </a>

        <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-slate-900">Selamat Datang 👋</h1>
                <p class="text-slate-500 mt-1">Silakan masuk ke akun perpustakaanmu.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition"
                        placeholder="email@seskoal.id">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-slate-600">
                        <input type="checkbox" name="remember"
                            class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 mr-2"> Ingatkan
                        saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 transition-all">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-slate-600">Belum punya akun? <a href="{{ route('register') }}"
                        class="text-blue-600 font-semibold hover:underline">Daftar Siswa</a></p>
            </div>
        </div>
    </div>
</body>

</html>
