@extends('layouts.admin')

@section('title', 'Admin Dashboard - Kelola Data')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Showroom & Unit Mobil - Gratama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-slate-800 antialiased min-h-screen">

    {{-- Top Navbar --}}
    <nav class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="bg-[#800000] text-white font-black text-sm px-3 py-1.5 rounded-xl uppercase tracking-wider">
                    GSP Admin
                </span>
                <span class="text-xs font-semibold text-slate-400">| Monitoring Unit</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-[#800000] transition">
                    ← Kembali ke Dashboard
                </a>
                <a href="{{ route('portal.index') }}" target="_blank" class="text-xs font-bold text-slate-600 hover:text-[#800000] transition">
                    Katalog Unit ↗
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Container Konten --}}
    <main class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl font-bold">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl font-bold">
                {{ session('error') }}
            </div>
        @endif

        {{-- Header & Bar Pencarian --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Monitoring Showroom & Unit Mobil</h1>
                <p class="text-xs text-slate-500 mt-1">Verifikasi relasi no_cif / CNO, foto 3 sisi, serta status unit mobil rekanan.</p>
            </div>

            {{-- Form Pencarian --}}
            <form action="{{ route('showrooms.monitoring') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari Plat, No CIF, Merk, Tipe, Warna, Showroom..." 
                       class="px-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:border-[#800000] bg-slate-50 w-full sm:w-80">

                <select name="has_cars" onchange="this.form.submit()" class="px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none bg-slate-50 text-slate-700">
                    <option value="">Semua Showroom</option>
                    <option value="1" {{ request('has_cars') === '1' ? 'selected' : '' }}>Hanya Memiliki Unit</option>
                </select>

                <button type="submit" class="bg-[#800000] hover:bg-red-900 text-white text-xs font-bold px-5 py-2.5 rounded-xl uppercase tracking-wider transition-all">
                    Cari
                </button>

                @if(request('search') || request('has_cars'))
                    <a href="{{ route('showrooms.monitoring') }}" class="text-slate-400 hover:text-slate-600 text-xs px-2 py-2">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel Data Monitoring --}}
        <div class="bg-white rounded-[28px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 w-1/4">Informasi Dealer</th>
                            <th class="py-4 px-6 w-1/6">CNO / Pemilik</th>
                            <th class="py-4 px-6 text-center w-24">Jml Unit</th>
                            <th class="py-4 px-6">Daftar Mobil & Foto 3 Sisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($showrooms as $showroom)
                            <tr class="hover:bg-slate-50/50 align-top">
                                
                                {{-- Kolom Info Dealer --}}
                                <td class="py-4 px-6">
                                    <div class="font-black text-slate-900 text-sm">
                                        {{ $showroom->nmdealer ?? 'Tanpa Nama Dealer' }}
                                    </div>
                                    <div class="text-[11px] font-mono text-slate-400 mt-0.5">
                                        KTP: {{ $showroom->clprnoktp ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        Cabang: <span class="font-semibold text-slate-600">{{ $showroom->kdcab ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Kolom CNO & Pemilik --}}
                                <td class="py-4 px-6">
                                    @if($showroom->cno)
                                        <span class="bg-red-50 text-[#800000] font-mono font-bold px-2 py-0.5 rounded text-[11px]">
                                            CNO: {{ $showroom->cno }}
                                        </span>
                                    @else
                                        <span class="text-rose-500 font-semibold italic text-[11px] bg-rose-50 px-2 py-0.5 rounded">
                                            CNO Kosong
                                        </span>
                                    @endif
                                    <div class="font-semibold text-slate-800 mt-1.5">{{ $showroom->cnm ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $showroom->kota ?? '-' }}</div>
                                </td>

                                {{-- Kolom Jumlah Mobil --}}
                                <td class="py-4 px-6 text-center">
                                    @if($showroom->cars->count() > 0)
                                        <span class="bg-emerald-50 text-emerald-700 font-black px-2.5 py-1 rounded-xl text-xs">
                                            {{ $showroom->cars->count() }} Unit
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-400 font-bold px-2 py-1 rounded-xl text-[10px]">
                                            0
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom Daftar Mobil & Galeri Foto --}}
                                <td class="py-4 px-6">
                                    @if($showroom->cars->isNotEmpty())
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($showroom->cars as $car)
                                                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3.5 space-y-3">
                                                    
                                                    {{-- Info Header Unit & Tombol Hapus --}}
                                                    <div class="flex items-start justify-between gap-2 border-b border-slate-200/60 pb-2">
                                                        <div>
                                                            <div class="font-black text-slate-900 text-xs">
                                                                {{ $car->nama_merk }} {{ $car->tipe_kend }}
                                                            </div>
                                                            <div class="text-[10px] text-slate-500 mt-0.5">
                                                                {{ $car->jenis_kend ?? '-' }} • {{ $car->transmisi ?? '-' }} • {{ $car->warna_kend ?? '-' }} • Thn {{ $car->tahun_buat ?? '-' }}
                                                            </div>
                                                            <div class="text-[10px] text-slate-400">
                                                                No CIF: <span class="font-mono text-slate-700 font-bold">{{ $car->no_cif }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-1.5 flex-shrink-0">
                                                            <span class="bg-red-100 text-[#800000] font-mono text-[10px] font-black px-2 py-0.5 rounded uppercase">
                                                                {{ $car->no_polisi ?? '-' }}
                                                            </span>

                                                            {{-- Tombol Hapus Mobil --}}
                                                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Hapus permanen unit mobil {{ $car->no_polisi }} beserta seluruh fotonya?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" title="Hapus Unit" class="p-1 rounded-md text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    {{-- Galeri 3 Sisi Foto (Depan, Samping, Belakang) --}}
                                                    <div class="grid grid-cols-3 gap-2">
                                                        
                                                        {{-- Tampak Depan --}}
                                                        <div class="space-y-1">
                                                            <p class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Depan</p>
                                                            @if($car->foto_depan)
                                                                <a href="{{ asset('storage/' . $car->foto_depan) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $car->foto_depan) }}" 
                                                                         alt="Depan" 
                                                                         class="w-full h-14 object-cover rounded-lg border border-slate-200 hover:scale-105 transition-all">
                                                                </a>
                                                            @else
                                                                <div class="w-full h-14 bg-slate-200/60 rounded-lg flex items-center justify-center text-[9px] text-slate-400 font-bold italic">
                                                                    Kosong
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Tampak Samping --}}
                                                        <div class="space-y-1">
                                                            <p class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Samping</p>
                                                            @if($car->foto_samping)
                                                                <a href="{{ asset('storage/' . $car->foto_samping) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $car->foto_samping) }}" 
                                                                         alt="Samping" 
                                                                         class="w-full h-14 object-cover rounded-lg border border-slate-200 hover:scale-105 transition-all">
                                                                </a>
                                                            @else
                                                                <div class="w-full h-14 bg-slate-200/60 rounded-lg flex items-center justify-center text-[9px] text-slate-400 font-bold italic">
                                                                    Kosong
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Tampak Belakang --}}
                                                        <div class="space-y-1">
                                                            <p class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Belakang</p>
                                                            @if($car->foto_belakang)
                                                                <a href="{{ asset('storage/' . $car->foto_belakang) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $car->foto_belakang) }}" 
                                                                         alt="Belakang" 
                                                                         class="w-full h-14 object-cover rounded-lg border border-slate-200 hover:scale-105 transition-all">
                                                                </a>
                                                            @else
                                                                <div class="w-full h-14 bg-slate-200/60 rounded-lg flex items-center justify-center text-[9px] text-slate-400 font-bold italic">
                                                                    Kosong
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-slate-300 italic text-[11px]">Belum ada unit mobil terkait</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400 text-xs">
                                    Tidak ada data showroom atau unit mobil yang cocok dengan kriteria pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Bar --}}
            <div class="p-6 border-t border-slate-100">
                {{ $showrooms->links() }}
            </div>
        </div>

    </main>

</body>
</html>
@endsection