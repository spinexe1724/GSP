<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Katalog Unit Mobil - Gratama</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-[#F4F6F8] text-slate-800 antialiased">

    {{-- =========================================================
         NAVBAR STANDALONE — SELARAS DENGAN HOMEPAGE
    ========================================================== --}}
    <header class="sticky top-0 z-[100] border-b border-slate-200/80 bg-white/95 backdrop-blur-xl shadow-[0_4px_20px_rgba(15,23,42,0.06)]">
    <div class="mx-auto flex h-[72px] w-full max-w-7xl items-center justify-between px-5 sm:px-6 lg:px-8">
        <a href="{{ route('portal.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <span class="text-xl font-extrabold tracking-tight text-slate-900">Gratama</span>
        </a>
       
    </div>
</header>

<main class="relative flex-1 min-h-0 overflow-x-hidden bg-[#F4F6F8] py-8 sm:py-10 lg:py-12 font-['Plus_Jakarta_Sans']">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-40 top-20 h-[430px] w-[430px] rounded-full bg-[#800000]/[0.045] blur-[110px]"></div>
        <div class="absolute -right-40 bottom-[-100px] h-[500px] w-[500px] rounded-full bg-[#800000]/[0.035] blur-[120px]"></div>
        <div class="absolute inset-x-[12%] top-10 h-px bg-gradient-to-r from-transparent via-[#800000]/15 to-transparent"></div>
    </div>
    <div class="relative z-10 mx-auto max-w-7xl px-5 sm:px-6 lg:px-8 space-y-8">

        {{-- Header & Pencarian --}}
        <div class="bg-white p-6 md:p-8 rounded-[28px] border border-slate-100 shadow-sm space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                        Katalog Unit Mobil
                    </h1>

                    <p class="text-xs text-slate-500 mt-1">
                        Daftar unit mobil dari jaringan showroom rekanan terdaftar.
                    </p>
                </div>

                <div class="text-xs font-bold text-slate-500 bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl">
                    Total:
                    <span class="text-[#800000]">
                        {{ $cars->total() }} Unit
                    </span>
                </div>
            </div>


            {{-- Form Filter & Search --}}
            <form
                action="{{ route('cars.index') }}"
                method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-3"
            >

                <div class="md:col-span-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari merk, tipe, nopol, atau showroom..."
                        class="w-full px-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:border-[#800000] bg-slate-50"
                    >
                </div>


                <div>
                    <select
                        name="merk"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none bg-slate-50 text-slate-700"
                    >
                        <option value="">Semua Merk</option>

                        @foreach($brands as $brand)
                            <option
                                value="{{ $brand }}"
                                {{ request('merk') == $brand ? 'selected' : '' }}
                            >
                                {{ $brand }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="flex gap-2">

                    <select
                        name="transmisi"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none bg-slate-50 text-slate-700"
                    >
                        <option value="">Semua Transmisi</option>

                        <option
                            value="Manual"
                            {{ request('transmisi') == 'Manual' ? 'selected' : '' }}
                        >
                            Manual
                        </option>

                        <option
                            value="Automatic"
                            {{ request('transmisi') == 'Automatic' ? 'selected' : '' }}
                        >
                            Automatic
                        </option>
                    </select>


                    <button
                        type="submit"
                        class="bg-[#800000] hover:bg-red-900 text-white text-xs font-bold px-5 py-2.5 rounded-xl uppercase tracking-wider transition-all"
                    >
                        Cari
                    </button>

                </div>

            </form>
        </div>



        {{-- Grid Kartu Mobil --}}
        @if($cars->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @foreach ($cars as $car)

                    <div
                        class="bg-white rounded-[24px] border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col overflow-hidden group"
                    >

                        {{-- =================================================
                            THUMBNAIL FOTO DEPAN + WATERMARK
                        ================================================== --}}
                        <div class="aspect-[16/10] bg-slate-100 relative overflow-hidden select-none">

                            @if($car->foto_depan)

                                {{-- FOTO --}}
                                <img
                                    src="{{ asset($car->foto_depan) }}"
                                    alt="{{ $car->nama_merk }} {{ $car->tipe_kend }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 pointer-events-none select-none"
                                    draggable="false"
                                >


                                {{-- =================================================
                                    WATERMARK
                                ================================================== --}}
                                <div class="absolute inset-0 pointer-events-none overflow-hidden">

                                    {{-- Watermark utama --}}
                                    <div class="absolute inset-0 flex items-center justify-center -rotate-[20deg]">

                                        <span
                                            class="whitespace-nowrap text-white/70 text-xl md:text-2xl font-black tracking-[0.20em] drop-shadow-[0_2px_3px_rgba(0,0,0,0.85)]"
                                        >
                                            GRATAMA FINANCE
                                        </span>

                                    </div>


                                    {{-- Watermark tambahan atas --}}
                                    <div
                                        class="absolute top-[22%] left-[-30%] w-[160%] -rotate-[20deg] text-center"
                                    >
                                        <span
                                            class="text-white/40 text-[9px] md:text-[10px] font-black tracking-[0.25em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]"
                                        >
                                            PROPERTY OF GRATAMA FINANCE
                                        </span>
                                    </div>


                                    {{-- Watermark tambahan bawah --}}
                                    <div
                                        class="absolute top-[65%] left-[-30%] w-[160%] -rotate-[20deg] text-center"
                                    >
                                        <span
                                            class="text-white/40 text-[9px] md:text-[10px] font-black tracking-[0.25em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]"
                                        >
                                            PROPERTY OF GRATAMA FINANCE
                                        </span>
                                    </div>

                                </div>


                                {{-- Label Gratama Finance --}}
                                <div class="absolute bottom-3 left-3 pointer-events-none">

                                    <span
                                        class="bg-[#800000] text-white text-[9px] font-black px-2.5 py-1 rounded-lg shadow-lg uppercase tracking-wider"
                                    >
                                        GRATAMA FINANCE
                                    </span>

                                </div>
                            @else

                                {{-- FOTO DEFAULT — SELARAS DENGAN HALAMAN DETAIL UNIT --}}
                                <div class="relative w-full h-full overflow-hidden bg-gradient-to-br from-slate-950 via-slate-800 to-[#800000]">

                                    <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full border border-white/10 bg-white/5"></div>
                                    <div class="absolute -left-14 bottom-[-35px] h-36 w-36 rounded-full bg-[#800000]/40 blur-2xl"></div>
                                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/30 to-transparent"></div>

                                    {{-- Watermark halus --}}
                                    <div class="absolute inset-0 flex items-center justify-center -rotate-[18deg] pointer-events-none">
                                        <span class="whitespace-nowrap text-white/[0.10] text-2xl font-black tracking-[0.18em]">
                                            PROPERTY OF GRATAMA FINANCE
                                        </span>
                                    </div>

                                    {{-- Siluet mobil --}}
                                    <div class="absolute inset-x-0 top-[17%] flex justify-center">
                                        <svg viewBox="0 0 260 120" class="w-[68%] max-w-[220px] h-auto text-white/80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M43 72L54 48C58 39 66 33 76 31L102 25H166C177 25 187 30 194 39L210 59L222 64C229 67 233 73 233 80V86H27V79C27 75 33 72 43 72Z" fill="currentColor"/>
                                            <path d="M80 34L103 29H164C174 29 181 33 187 41L196 54H69L77 38C78 36 79 35 80 34Z" fill="#1F2937"/>
                                            <path d="M109 30L104 52H147L143 30H109Z" fill="#CBD5E1" opacity=".45"/>
                                            <path d="M75 59H193" stroke="#0F172A" stroke-width="3" opacity=".35"/>
                                            <rect x="37" y="66" width="18" height="7" rx="3.5" fill="#800000"/>
                                            <rect x="205" y="66" width="18" height="7" rx="3.5" fill="#800000"/>
                                            <circle cx="65" cy="86" r="16" fill="#111827" stroke="#E5E7EB" stroke-width="5"/>
                                            <circle cx="195" cy="86" r="16" fill="#111827" stroke="#E5E7EB" stroke-width="5"/>
                                        </svg>
                                    </div>

                                    <div class="absolute inset-x-0 bottom-[16%] text-center text-white">
                                        <div class="text-[17px] sm:text-lg font-black tracking-[0.10em]">GRATAMA FINANCE</div>
                                        <div class="mt-1 text-[8px] sm:text-[9px] font-bold tracking-[0.28em] text-white/60 uppercase">Foto Unit Belum Tersedia</div>
                                    </div>

                                    <div class="absolute bottom-2.5 left-2.5">
                                        <span class="bg-[#800000] text-white text-[8px] font-black px-2 py-1 rounded-md shadow-lg uppercase tracking-wider">
                                            GRATAMA FINANCE
                                        </span>
                                    </div>

                                </div>

                            @endif

                        </div>



                        {{-- =================================================
                            KONTEN RINGKAS
                        ================================================== --}}
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">

                            <div>

                                {{-- Merk + Tahun --}}
                                <div class="text-[10px] font-bold text-[#800000] uppercase tracking-wider">

                                    {{ $car->nama_merk ?? 'Mobil' }}

                                    •
                                    
                                    {{ $car->tahun_buat ?? '-' }}

                                </div>


                                {{-- Nama Tipe --}}
                                <h3
                                    class="font-black text-slate-900 text-sm mt-0.5 group-hover:text-[#800000] transition-colors line-clamp-1"
                                >
                                    {{ $car->tipe_kend ?? '-' }}
                                </h3>


                                {{-- Spesifikasi Singkat --}}
                                <div class="flex flex-wrap gap-1.5 mt-3">

                                    @if($car->transmisi)

                                        <span
                                            class="text-[10px] bg-slate-50 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-medium"
                                        >
                                            {{ $car->transmisi }}
                                        </span>

                                    @endif


                                    @if($car->warna_kend)

                                        <span
                                            class="text-[10px] bg-slate-50 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-medium"
                                        >
                                            {{ $car->warna_kend }}
                                        </span>

                                    @endif


                                    @if($car->jenis_kend)

                                        <span
                                            class="text-[10px] bg-slate-50 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-medium"
                                        >
                                            {{ $car->jenis_kend }}
                                        </span>

                                    @endif

                                </div>

                            </div>



                            {{-- =================================================
                                SHOWROOM + DETAIL
                            ================================================== --}}
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">

                                <div class="truncate max-w-[150px]">

                                    <p class="text-[10px] text-slate-400 uppercase font-bold">
                                        Showroom
                                    </p>

                                    <p class="text-xs font-bold text-slate-700 truncate">
                                        {{ $car->showroom->nmdealer ?? 'Showroom Rekanan' }}
                                    </p>

                                </div>


                                <a
                                    href="{{ route('cars.show', $car->id) }}"
                                    class="px-3.5 py-2 bg-[#800000] hover:bg-red-900 text-white rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all"
                                >
                                    Detail
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- =================================================
                PAGINATION
            ================================================== --}}
            <div class="pt-4">
                {{ $cars->links() }}
            </div>


        @else

            {{-- Tidak Ada Data --}}
            <div class="bg-white rounded-[24px] border border-slate-100 p-12 text-center space-y-3">

                <p class="text-slate-400 text-sm">
                    Tidak ada unit mobil yang cocok dengan kriteria pencarian.
                </p>

                <a
                    href="{{ route('cars.index') }}"
                    class="inline-block text-xs font-bold text-[#800000] underline"
                >
                    Reset Filter
                </a>

            </div>

        @endif

    </div>
</div>






</main>


    {{-- =========================================================
         FOOTER STANDALONE — MINIMALIS
    ========================================================== --}}
    <footer class="relative z-10 mt-auto border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-5 md:px-10">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#800000]">
                        <span class="text-xs font-black text-white">G</span>
                    </div>

                    <div>
                        <div class="text-xs font-bold text-slate-900">GSP</div>
                        <div class="text-[10px] text-slate-400">
                            Gratama Showroom Partners
                        </div>
                    </div>
                </div>

                <div class="text-[10px] text-slate-400">
                    © 2026 GSP
                </div>
            </div>
        </div>
    </footer>

{{-- =============================================================
    PROTEKSI FOTO / KLIK KANAN
============================================================= --}}
<script>

    // Disable klik kanan
    document.addEventListener('contextmenu', function (event) {

        event.preventDefault();

        return false;

    });


    // Disable drag gambar
    document.addEventListener('dragstart', function (event) {

        if (event.target && event.target.tagName === 'IMG') {

            event.preventDefault();

            return false;

        }

    });


    // Mencegah drag pada gambar
    document.addEventListener('mousedown', function (event) {

        if (
            event.target &&
            event.target.tagName === 'IMG' &&
            event.button === 2
        ) {

            event.preventDefault();

        }

    });

</script>

</body>
</html>
