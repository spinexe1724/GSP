<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gratama Showroom Partner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="h-screen overflow-hidden bg-[#F4F6F8] text-slate-800 antialiased">

<header class="sticky top-0 z-[100] border-b border-slate-200/80 bg-white/95 backdrop-blur-xl shadow-[0_4px_20px_rgba(15,23,42,0.06)]">
    <div class="mx-auto flex h-[72px] w-full max-w-7xl items-center justify-between px-5 sm:px-6 lg:px-8">
        <a href="{{ route('portal.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <span class="text-xl font-extrabold tracking-tight text-slate-900">Gratama</span>
        </a>
       
    </div>
</header>

<main class="relative isolate h-[calc(100vh-154px)] min-h-0 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2000"
         class="absolute inset-0 h-full w-full object-cover" alt="Showroom mobil">

    <div class="absolute inset-0 bg-slate-950/75"></div>
    <div class="absolute -left-32 top-1/4 h-[500px] w-[500px] rounded-full bg-[#800000]/25 blur-[130px]"></div>
    <div class="absolute -right-40 bottom-0 h-[520px] w-[520px] rounded-full bg-[#800000]/20 blur-[140px]"></div>

    <div class="relative z-10 mx-auto flex h-full w-full max-w-7xl items-center px-5 py-6 sm:px-6 lg:px-8">
        <div class="grid w-full items-center gap-12 lg:grid-cols-[1fr_430px]">

            <section class="hidden max-w-2xl text-white lg:block">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[0.18em] text-white/90">Gratama Showroom Partner</span>
                </div>

                <h1 class="text-5xl font-black leading-[1.03] tracking-[-0.04em] xl:text-6xl">
                    Kelola showroom,
                    <span class="block text-red-500">lebih praktis.</span>
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-200/75">
                    Masuk ke panel Gratama untuk mengelola unit, data showroom, foto kendaraan,
                    dan aktivitas partner dalam satu tempat.
                </p>

                <div class="mt-8 flex items-center gap-3 text-xs font-semibold text-white/55">
                    <span class="h-px w-10 bg-red-500/70"></span>
                    Gratama Showroom Partners
                </div>
            </section>

            <section class="w-full max-w-[430px] justify-self-center lg:justify-self-end">
                <div class="rounded-[26px] border border-white/15 bg-white/95 p-6 shadow-[0_30px_80px_rgba(0,0,0,0.35)] backdrop-blur-xl sm:p-7">

                    <div class="mb-5">
                        <div class="mb-3 flex h-10 w-11 items-center justify-center rounded-xl bg-[#800000] shadow-sm">
                            <span class="text-lg font-black text-white">G</span>
                        </div>
                        <h2 class="text-2xl font-black tracking-tight text-slate-900">Selamat datang.</h2>
                        <p class="mt-1 text-xs leading-5 text-slate-500">Masuk ke akun partner Gratama Anda.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-xs font-medium text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-[11px] font-bold uppercase tracking-wider text-slate-500">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="nama@perusahaan.com"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-800 outline-none transition focus:border-[#800000] focus:bg-white focus:ring-4 focus:ring-[#800000]/10">
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-[11px] font-bold uppercase tracking-wider text-slate-500">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   placeholder="Masukkan password"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-800 outline-none transition focus:border-[#800000] focus:bg-white focus:ring-4 focus:ring-[#800000]/10">
                        </div>

                        <button type="submit"
                                class="mt-2 w-full rounded-xl bg-[#800000] py-4 text-xs font-black uppercase tracking-[0.16em] text-white shadow-lg shadow-[#800000]/20 transition duration-200 hover:bg-[#650000] active:scale-[0.99]">
                            Masuk ke Sistem
                        </button>
                    </form>

                    
                </div>
            </section>
        </div>
    </div>
</main>

<footer class="h-[82px] border-t border-slate-200 bg-white">
    <div class="mx-auto flex h-full max-w-7xl items-center px-6 md:px-10">
        <div class="flex w-full flex-col items-center justify-between gap-3 sm:flex-row">

            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#800000]">
                    <span class="text-xs font-black text-white">G</span>
                </div>

                <div>
                    <div class="text-sm font-bold text-slate-900">
                        GSP
                    </div>
                    <div class="text-[10px] text-slate-400">
                        Gratama Showroom Partners
                    </div>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="text-[10px] text-slate-400">
                © 2026 Gratama Showroom Partners
            </div>

        </div>
    </div>
</footer>

</body>
</html>
