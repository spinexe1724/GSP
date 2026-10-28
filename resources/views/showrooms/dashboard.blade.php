<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Showroom - Gratama</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F3F4F6] min-h-screen text-slate-800 antialiased">

    {{-- ================= NAVBAR ================= --}}
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <!-- Brand logo -->
            <a href="{{ route('showrooms.dashboard') }}" aria-label="Gratama Finance, dashboard showroom" class="inline-flex shrink-0 items-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000]">
                <img src="{{ asset('images/LogoG.png') }}" alt="Gratama Finance" class="h-9 w-36 object-contain sm:h-10 sm:w-40">
            </a>

            <!-- User Menu & Logout -->
            <div class="flex items-center gap-4">
                <div class="hidden text-right sm:block">
                    <div class="text-sm font-bold text-slate-900">
                        {{ $showroom->nmdealer ?? Auth::user()->name }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-semibold">
                        CNO: {{ $showroom->cno ?? '-' }}
                    </div>
                </div>
                
                <div class="h-8 w-px bg-slate-200 mx-2"></div>

                <form action="{{ route('showrooms.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 rounded-lg bg-red-50 px-4 py-2 text-sm font-bold text-red-600 transition hover:bg-red-100 hover:text-red-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- ================= MAIN CONTENT ================= --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-6">
@if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200 text-sm font-bold text-green-700">
        {{ session('success') }}
    </div>
@endif
        <!-- Welcome Banner -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900">Selamat datang, {{ $showroom->nmdealer ?? Auth::user()->name }}!</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola inventori unit mobil Anda dan lengkapi foto kendaraan untuk menarik lebih banyak pembeli.</p>
            </div>
            <!-- Tombol ke halaman ubah password (opsional untuk nanti) -->
            <a href="{{ route('showrooms.settings.edit_profile') }}" class="shrink-0 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800 shadow-md">
                Pengaturan Akun
            </a>
        </div>

        <!-- Statistik Cards (Placeholder) -->
       <!-- Statistik Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Total Unit Anda</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $totalCars }}</h3>
            </div>
            <div class="rounded-2xl bg-green-50 p-6 shadow-sm border border-green-100">
                <p class="text-sm font-bold text-green-600 uppercase tracking-wider mb-1">Foto Lengkap</p>
                <h3 class="text-3xl font-black text-green-700">{{ $fotoLengkap }}</h3>
            </div>
            <div class="rounded-2xl bg-amber-50 p-6 shadow-sm border border-amber-100">
                <p class="text-sm font-bold text-amber-600 uppercase tracking-wider mb-1">Perlu Upload Foto</p>
                <h3 class="text-3xl font-black text-amber-700">{{ $perluFoto }}</h3>
            </div>
        </div>

        <!-- Tabel Daftar Unit -->
        <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-5 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-900">Daftar Unit Kendaraan</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Merek & Tipe</th>
                            <th scope="col" class="px-6 py-4 font-bold">Tahun</th>
                            <th scope="col" class="px-6 py-4 font-bold">Harga</th>
                            <th scope="col" class="px-6 py-4 font-bold">Status Foto</th>
                            <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        
                        @forelse($cars as $car)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-base">
                                        {{ $car->nama_merk ?? 'Merk' }} {{ $car->tipe_kend ?? 'Tipe' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">Nopol: {{ $car->no_polisi ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $car->tahun_buat ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-[#800000]">
                                    Rp {{ number_format($car->harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Logika Pengecekan Foto -->
                                    @if(!empty($car->foto_depan))
                                        <span class="inline-flex items-center gap-1.5 rounded-md bg-green-100 px-2 py-1 text-xs font-bold text-green-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                            Foto Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-md bg-amber-100 px-2 py-1 text-xs font-bold text-amber-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Belum Ada Foto
                                        </span>
                                    @endif
                                </td>
                               <td class="px-6 py-4 text-right">
    @if(empty($car->foto_depan))
        <!-- Tombol Upload -->
        <a href="{{ route('showrooms.cars.foto.edit', $car->id) }}" class="inline-flex items-center justify-center rounded-lg bg-[#800000] px-4 py-2 text-xs font-bold text-white transition hover:bg-red-900 shadow-sm">
            + Upload Foto
        </a>
    @else
        <!-- Tombol Edit -->
        <a href="{{ route('showrooms.cars.foto.edit', $car->id) }}" class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-50 shadow-sm">
            Edit Foto
        </a>
    @endif
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data unit mobil untuk showroom ini.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Bawaan Laravel -->
            @if($cars->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $cars->links() }}
                </div>
            @endif
        </div>
        </div>

    </main>

</body>
</html>