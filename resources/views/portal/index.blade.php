@extends('layouts.app')

@section('title', 'Gratama Showroom Partners')

@section('content')
<div class="w-full bg-[#f8f9fa] font-['Plus_Jakarta_Sans'] min-h-screen text-slate-800">

    {{-- HERO SECTION --}}
    <div class="relative bg-gradient-to-br from-[#fef2f2] via-[#fcf0f0] to-[#f4e8e8] pt-24 pb-16 md:pt-28 md:pb-20 overflow-hidden">
        {{-- Aksen Dekorasi Lingkaran Pink Background --}}
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[350px] h-[350px] md:w-[550px] md:h-[550px] bg-red-500/20 rounded-full blur-3xl -mr-20 pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                
                {{-- Bagian Teks Hero (Kiri) --}}
                <div class="md:col-span-6 space-y-4">
                    <p class="text-red-600 text-xs md:text-sm font-bold tracking-[0.2em] uppercase">
                        WELCOME TO <br class="hidden sm:inline"> GRATAMA SHOWROOM PARTNERS
                    </p>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">
                        Cara Terbaik <br> 
                        Menemukan Mobil <br> 
                        <span class="text-red-500">Impian Anda</span>
                    </h1>
                </div>

                {{-- Gambar Mobil (Kanan) --}}
                <div class="md:col-span-6 relative flex justify-center md:justify-end">
                    <div class="relative w-full max-w-lg">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 w-64 h-64 md:w-80 md:h-80 bg-red-200/60 rounded-full -z-10"></div>
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000" 
                             alt="Yellow Car" 
                             class="w-full h-auto object-contain drop-shadow-2xl transform hover:scale-105 transition-transform duration-500">
                    </div>
                </div>

            </div>
        </div>
    </div>
{{-- POPULAR BRANDS SECTION --}}
    <div class="container mx-auto px-4 md:px-6 pt-10 pb-4">
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm text-center">
            
            {{-- Header Title --}}
            <div class="flex items-center justify-center gap-2 mb-6">
                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2-6-4.8-6 4.8 2.4-7.2-6-4.8h7.6z"/>
                </svg>
                <h2 class="text-xs font-bold text-red-600 uppercase tracking-[0.2em]">Popular Brands</h2>
            </div>

            {{-- Grid Brand (2 Baris, 6 Kolom) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @php
    $popularBrands = [
        ['name' => 'Honda', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/honda.svg'],
        ['name' => 'Toyota', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/toyota.svg'],
        ['name' => 'Suzuki', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/suzuki.svg'],
        ['name' => 'Nissan', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/nissan.svg'],
        ['name' => 'Mitsubishi', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/mitsubishi.svg'],
        ['name' => 'Daihatsu', 'logo' => 'https://raw.githubusercontent.com/benjamim-san/logos/main/daihatsu.svg'],
        ['name' => 'Chevrolet', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/chevrolet.svg'],
        ['name' => 'Hyundai', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/hyundai.svg'],
        ['name' => 'Isuzu', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/isuzu.svg'],
        ['name' => 'Mazda', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/mazda.svg'],
        ['name' => 'Subaru', 'logo' => 'https://unpkg.com/simple-icons@v11/icons/subaru.svg'],
        ['name' => 'Wuling', 'logo' => 'https://raw.githubusercontent.com/benjamim-san/logos/main/wuling.svg'],
    ];
@endphp

                @foreach($popularBrands as $brand)
                    <a href="{{ route('cars.index', ['brand' => $brand['name']]) }}" 
                       class="flex flex-col items-center justify-center p-4 bg-slate-50/70 hover:bg-red-50/50 border border-slate-100 hover:border-red-200 rounded-2xl transition-all group">
                        <div class="w-10 h-10 flex items-center justify-center mb-2">
                            <img src="{{ $brand['logo'] }}" alt="{{ $brand['name'] }}" class="max-w-full max-h-full object-contain filter grayscale group-hover:grayscale-0 transition-all">
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-red-600 transition-colors">{{ $brand['name'] }}</span>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
    {{-- MAIN SECTION: SIDEBAR FILTER & KATALOG MOBIL --}}
    <div class="container mx-auto px-4 md:px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- SIDEBAR FILTER (KIRI) - MODEL OLX --}}
            <aside class="lg:col-span-3 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm sticky top-6 max-h-[calc(100vh-3rem)] overflow-y-auto">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <h3 class="font-black text-slate-900 text-base">Filter Pencarian</h3>
                    <a href="{{ route('cars.index') }}" class="text-xs text-red-600 font-bold hover:underline">Reset</a>
                </div>

                <form action="{{ route('cars.index') }}" method="GET" class="space-y-4">
                    {{-- Search Keyword --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Kata Kunci</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari tipe, nopol, showroom..." 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all">
                    </div>

                    {{-- Merek --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Merek</label>
                        <select name="brand" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all">
                            <option value="">Semua Merek</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Transmisi --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Transmisi</label>
                        <select name="transmission" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all">
                            <option value="">Semua Transmisi</option>
                            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    {{-- Range Harga --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Harga</label>
                        <select name="price" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all">
                            <option value="">Pilih Range Harga</option>
                            {{-- Tambahkan option range harga di sini jika diperlukan --}}
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Tahun</label>
                        <select name="year" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all">
                            <option value="">Pilih Tahun</option>
                        </select>
                    </div>

                    {{-- Warna --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Warna</label>
                        <select name="color" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all">
                            <option value="">Pilih Warna</option>
                        </select>
                    </div>

                    {{-- Tombol Terpeta --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-[#800000] hover:bg-red-900 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 0 0114 0z"></path>
                            </svg>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </aside>

            {{-- KATALOG MOBIL (KANAN) --}}
            <main class="lg:col-span-9 space-y-6">
                
                {{-- Header Katalog --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Katalog Unit Mobil</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar unit mobil dari jaringan showroom rekanan terdaftar.</p>
                    </div>
                    <div class="text-xs font-bold text-slate-600 bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl shrink-0 self-start sm:self-auto">
                        Total: <span class="text-[#800000] font-black">{{ $cars->total() }} Unit</span>
                    </div>
                </div>

                {{-- Grid Kartu Mobil --}}
                @if($cars->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($cars as $car)
                            <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col overflow-hidden group">
                                
                                {{-- Thumbnail Foto Depan --}}
                                <div class="aspect-[16/10] bg-slate-100 relative overflow-hidden">
                                    @if($car->foto_depan)
                                        <img src="{{ asset('storage/' . $car->foto_depan) }}" 
                                             alt="{{ $car->nama_merk }} {{ $car->tipe_kend }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-10 h-10 mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-[10px] font-bold uppercase tracking-wider">Foto Belum Tersedia</span>
                                        </div>
                                    @endif

                                    {{-- Badge Plat Nomor --}}
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-black/75 backdrop-blur-md text-white font-mono text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                            {{ $car->no_polisi ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Konten Ringkas --}}
                                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                    <div>
                                        <div class="text-[10px] font-bold text-[#800000] uppercase tracking-wider">
                                            {{ $car->nama_merk ?? 'Mobil' }} • {{ $car->tahun_buat ?? '-' }}
                                        </div>
                                        <h3 class="font-black text-slate-900 text-sm mt-0.5 group-hover:text-[#800000] transition-colors line-clamp-1">
                                            {{ $car->tipe_kend ?? '-' }}
                                        </h3>

                                        {{-- Spesifikasi Singkat --}}
                                        <div class="flex flex-wrap gap-1.5 mt-3">
                                            @if($car->transmisi)
                                                <span class="text-[10px] bg-slate-50 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-medium">
                                                    {{ $car->transmisi }}
                                                </span>
                                            @endif
                                            @if($car->warna_kend)
                                                <span class="text-[10px] bg-slate-50 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-medium">
                                                    {{ $car->warna_kend }}
                                                </span>
                                            @endif
                                            @if($car->jenis_kend)
                                                <span class="text-[10px] bg-slate-50 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-medium">
                                                    {{ $car->jenis_kend }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                        <div class="truncate max-w-[130px]">
                                            <p class="text-[10px] text-slate-400 uppercase font-bold">Showroom</p>
                                            <p class="text-xs font-bold text-slate-700 truncate">
                                                {{ $car->showroom->nmdealer ?? 'Showroom Rekanan' }}
                                            </p>
                                        </div>

                                        <a href="{{ route('cars.show', $car->id) }}" 
                                           class="px-3.5 py-2 bg-[#800000] hover:bg-red-900 text-white rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all">
                                            Detail
                                        </a>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="pt-4">
                        {{ $cars->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-[24px] border border-slate-100 p-12 text-center space-y-3">
                        <p class="text-slate-400 text-sm">Tidak ada unit mobil yang cocok dengan kriteria pencarian.</p>
                        <a href="{{ route('cars.index') }}" class="inline-block text-xs font-bold text-[#800000] underline">
                            Reset Filter
                        </a>
                    </div>
                @endif

            </main>
        </div>
    </div>

    {{-- FOOTER SECTION --}}
    @include('layouts.footer')
</div>
@endsection