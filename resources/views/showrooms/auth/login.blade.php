<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Showroom - Gratama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-[#f4f6f8] text-slate-800 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-[72px] w-full max-w-6xl items-center justify-between px-5 sm:px-8">
            <a href="{{ route('portal.index') }}" class="inline-flex items-center" aria-label="Gratama Finance, kembali ke beranda">
                <img src="{{ asset('images/LogoG.png') }}" alt="Gratama Finance" class="h-9 w-36 object-contain">
            </a>
            <a href="{{ route('portal.index') }}" class="text-xs font-semibold text-slate-600 transition hover:text-[#800000] sm:text-sm">
                Kembali ke beranda
            </a>
        </div>
    </header>

    <main class="flex flex-1 items-center px-5 py-10 sm:px-8 sm:py-14">
        <div class="mx-auto grid w-full max-w-5xl items-center gap-8 lg:grid-cols-[1fr_420px] lg:gap-16">
            <section class="max-w-xl">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#800000]/10 bg-white px-3 py-1.5 text-[11px] font-bold text-[#800000]">
                    <span class="h-2 w-2 rounded-full bg-[#800000]"></span>
                    PORTAL SHOWROOM
                </div>
                <h1 class="max-w-lg text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">
                    Semua kebutuhan showroom, dalam satu tempat.
                </h1>
                <p class="mt-4 max-w-lg text-sm leading-6 text-slate-600 sm:text-base">
                    Masuk untuk mengelola inventori kendaraan, melengkapi foto unit, dan memperbarui profil showroom.
                </p>

                <div class="mt-8 grid max-w-lg grid-cols-3 border-y border-slate-200 py-4">
                    <div class="pr-3">
                        <span class="block text-xs font-bold text-slate-900 sm:text-sm">Inventori</span>
                        <span class="mt-1 block text-[11px] text-slate-500 sm:text-xs">Kelola unit</span>
                    </div>
                    <div class="border-l border-slate-200 px-3">
                        <span class="block text-xs font-bold text-slate-900 sm:text-sm">Foto unit</span>
                        <span class="mt-1 block text-[11px] text-slate-500 sm:text-xs">Lengkapi galeri</span>
                    </div>
                    <div class="border-l border-slate-200 pl-3">
                        <span class="block text-xs font-bold text-slate-900 sm:text-sm">Profil</span>
                        <span class="mt-1 block text-[11px] text-slate-500 sm:text-xs">Perbarui data</span>
                    </div>
                </div>
            </section>

            <section class="w-full rounded-2xl border border-slate-200 bg-white p-6 shadow-[0_12px_40px_rgba(15,23,42,0.07)] sm:p-8">
                <div class="mb-6">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#800000]">Akun partner</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-slate-900">Selamat datang</h2>
                    <p class="mt-1 text-sm text-slate-500">Masuk ke portal showroom Gratama.</p>
                </div>

                @if(session('error') || $errors->any())
                    <div role="alert" class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') ?? $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('showrooms.login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="clprnoktp" class="mb-2 block text-sm font-semibold text-slate-700">Nomor KTP pemilik</label>
                        <input id="clprnoktp" type="text" name="clprnoktp" value="{{ old('clprnoktp') }}" inputmode="numeric" autocomplete="username" required
                               placeholder="Masukkan nomor KTP"
                               class="w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#800000] focus:bg-white focus:ring-4 focus:ring-[#800000]/10">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                        <input id="password" type="password" name="password" autocomplete="current-password" required
                               placeholder="Masukkan password"
                               class="w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#800000] focus:bg-white focus:ring-4 focus:ring-[#800000]/10">
                        <p class="mt-2 text-xs leading-5 text-slate-500">Login pertama kali? Gunakan nomor KTP sebagai password.</p>
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-[#800000] px-4 py-3.5 text-sm font-bold text-white transition hover:bg-[#650000] focus:outline-none focus:ring-4 focus:ring-[#800000]/20">
                        Masuk ke dashboard
                    </button>
                </form>
            </section>
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex min-h-[82px] w-full max-w-6xl flex-col items-center justify-between gap-3 px-5 py-4 sm:flex-row sm:px-8">
            <div>
                <span class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="h-8 w-8 shrink-0 rounded-md object-contain">
                    <span>
                    <span class="block text-sm font-black uppercase tracking-[0.08em] text-slate-900">Gratama Finance</span>
                    <span class="block text-[10px] text-slate-500">Gratama Showroom Partners</span>
                    </span>
                </span>
            </div>
            <p class="text-[11px] text-slate-500">&copy; {{ date('Y') }} Gratama Showroom Partners</p>
        </div>
    </footer>
</body>
</html>