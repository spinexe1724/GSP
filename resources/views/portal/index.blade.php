@extends('layouts.app')

@section('title', 'Gratama Showroom Partners')

@section('content')
<div class="w-full bg-slate-50 font-['Plus_Jakarta_Sans'] min-h-screen text-slate-800 antialiased">

    {{-- 1. HERO SECTION (TETAP GRADIEN MAROON MEWAH) --}}
    <section class="relative bg-gradient-to-br from-[#4a0000] via-[#800000] to-[#a31a1a] pt-20 pb-24 md:pt-28 md:pb-32 overflow-hidden">
        {{-- Pattern Aksen Glow & Lingkaran Transparan --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-black/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- Text Header & Search --}}
                <div class="lg:col-span-7 space-y-6 text-white">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                        <span class="text-[11px] font-bold text-white uppercase tracking-widest">Gratama Showroom Partners</span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight drop-shadow-md">
                        Temukan Mobil Impian <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-100 via-slate-100 to-white">Dengan Transaksi Aman & Transparan</span>
                    </h1>
                    
                    <p class="text-sm md:text-base text-slate-200 max-w-xl leading-relaxed">
                        Jelajahi ratusan unit mobil bekas & baru terverifikasi dari jaringan showroom mitra terpercaya kami di seluruh Indonesia.
                    </p>

                    {{-- Quick Search Form (Floating White Card) --}}
                    <form action="{{ route('cars.index') }}" method="GET" class="p-2.5 bg-white shadow-2xl shadow-black/30 rounded-2xl md:rounded-full flex flex-col md:flex-row items-center gap-2 max-w-2xl">
                        <div class="flex-1 flex items-center gap-3 pl-4 w-full">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tipe mobil, brand, atau kota..." class="w-full bg-transparent border-none text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0 py-2">
                        </div>
                        <button type="submit" class="w-full md:w-auto px-8 py-3.5 bg-[#800000] hover:bg-[#600000] text-white text-xs font-bold uppercase tracking-wider rounded-xl md:rounded-full shadow-md transition-all shrink-0">
                            Cari Mobil
                        </button>
                    </form>
                </div>

                {{-- Featured Image Card --}}
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md">
                        <div class="absolute -inset-1 rounded-3xl bg-white/20 blur-md"></div>
                        <div class="relative bg-white p-3 rounded-3xl shadow-2xl overflow-hidden border border-white/40">
                            <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000" alt="Car Showcase" class="w-full h-64 md:h-72 object-cover rounded-2xl">
                            <div class="p-4 bg-white flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] uppercase tracking-wider font-bold text-[#800000]">Unit Unggulan</p>
                                    <p class="text-sm font-bold text-slate-900">Kondisi Mulus & Terinspeksi</p>
                                </div>
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold rounded-lg">Garansi 1 Thn</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 2. POPULAR BRANDS SECTION (PURE WHITE BACKGROUND) --}}
    <section class="py-10 bg-white border-b border-slate-200/80">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 tracking-tight">Merek Populer</h2>
                    <p class="text-xs text-slate-500">Pilih brand sesuai preferensi Anda</p>
                </div>
                <a href="{{ route('cars.index') }}" class="text-xs font-bold text-[#800000] hover:underline transition-colors flex items-center gap-1">
                    Lihat Semua 
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-12 gap-3">
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
                       class="flex flex-col items-center justify-center p-3.5 bg-slate-50 hover:bg-white hover:shadow-md border border-slate-200/80 hover:border-[#800000] rounded-2xl transition-all group">
                        <div class="w-8 h-8 flex items-center justify-center mb-1.5 opacity-70 group-hover:opacity-100 transition-opacity">
                            <img src="{{ $brand['logo'] }}" alt="{{ $brand['name'] }}" class="max-w-full max-h-full object-contain filter grayscale group-hover:grayscale-0 transition-all">
                        </div>
                        <span class="text-[11px] font-bold text-slate-700 group-hover:text-[#800000] truncate w-full text-center">{{ $brand['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. MAIN CATALOG & SIDEBAR FILTER (CLEAN SLATE & WHITE) --}}
    <section class="py-12 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- SIDEBAR FILTER --}}
                <aside class="lg:col-span-3 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm sticky top-6">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            <h3 class="font-extrabold text-slate-900 text-sm">Filter Pencarian</h3>
                        </div>
                        <a href="{{ route('cars.index') }}" class="text-[11px] font-bold text-[#800000] hover:underline">Reset</a>
                    </div>

                    <form action="{{ route('cars.index') }}" method="GET" class="space-y-4">
                        {{-- Keyword --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Kata Kunci</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tipe, nopol, showroom..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#800000] focus:bg-white transition-colors">
                        </div>

                        {{-- Brand --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Merek</label>
                            <select name="brand" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#800000] focus:bg-white transition-colors">
                                <option value="">Semua Merek</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Transmisi --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Transmisi</label>
                            <select name="transmission" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#800000] focus:bg-white transition-colors">
                                <option value="">Semua Transmisi</option>
                                <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Rentang Harga</label>
                            <select name="price" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#800000] focus:bg-white transition-colors">
                                <option value="">Semua Harga</option>
                                <option value="0-100">< Rp 100 Juta</option>
                                <option value="100-200">Rp 100 - 200 Juta</option>
                                <option value="200-300">Rp 200 - 300 Juta</option>
                                <option value="300+">> Rp 300 Juta</option>
                            </select>
                        </div>

                        {{-- Tahun --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tahun Kendaraan</label>
                            <select name="year" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#800000] focus:bg-white transition-colors">
                                <option value="">Pilih Tahun</option>
                                @for($y = date('Y'); $y >= 2010; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="w-full mt-2 bg-[#800000] hover:bg-[#600000] text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 uppercase tracking-wider">
                            Terapkan Filter
                        </button>
                    </form>
                </aside>

                {{-- KATALOG PRODUCT GRID --}}
                <main class="lg:col-span-9 space-y-6">
                    
                    {{-- Catalog Header Bar --}}
                    <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Katalog Unit Tersedia</h2>
                            <p class="text-xs text-slate-500">Menampilkan hasil sesuai dengan preferensi filter Anda.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-slate-500">Total:</span>
                            <span class="px-3 py-1 bg-[#800000] text-white text-xs font-black rounded-lg shadow-sm">{{ $cars->total() }} Unit</span>
                        </div>
                    </div>

                    {{-- Card Grid --}}
                    @if($cars->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($cars as $car)
                                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-slate-300 hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                                    
                                    {{-- Image Header & Badges --}}
                                    <div class="aspect-[16/10] bg-slate-100 relative overflow-hidden">
                                        @if($car->foto_depan)
                                            <img src="{{ asset('storage/' . $car->foto_depan) }}" alt="{{ $car->nama_merk }} {{ $car->tipe_kend }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100">
                                                <svg class="w-8 h-8 mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="text-[10px] font-medium tracking-wider uppercase text-slate-400">Gambar Tidak Tersedia</span>
                                            </div>
                                        @endif

                                        {{-- Top Plate & Year Badges --}}
                                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                            <span class="bg-slate-900/80 backdrop-blur-md text-white font-mono text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">
                                                {{ $car->no_polisi ?? 'N/A' }}
                                            </span>
                                            <span class="bg-white/95 backdrop-blur-md text-slate-800 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                                {{ $car->tahun_buat ?? '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Product Body Info --}}
                                    <div class="p-4 flex-1 flex flex-col justify-between space-y-4">
                                        <div>
                                            <p class="text-[10px] font-black text-[#800000] uppercase tracking-widest">{{ $car->nama_merk ?? 'Mobil' }}</p>
                                            <h3 class="font-extrabold text-slate-900 text-sm mt-0.5 group-hover:text-[#800000] transition-colors line-clamp-1">
                                                {{ $car->tipe_kend ?? '-' }}
                                            </h3>

                                            {{-- Specifications Badges --}}
                                            <div class="grid grid-cols-2 gap-2 mt-3 pt-3 border-t border-slate-100">
                                                <div class="flex items-center gap-1.5 text-slate-600 text-[11px]">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                                    <span class="truncate font-medium">{{ $car->transmisi ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center gap-1.5 text-slate-600 text-[11px]">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                                    <span class="truncate font-medium">{{ $car->warna_kend ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Showroom & Action Button --}}
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                            <div class="truncate max-w-[120px]">
                                                <p class="text-[9px] uppercase font-bold text-slate-400">Showroom Partner</p>
                                                <p class="text-[11px] font-bold text-slate-700 truncate">
                                                    {{ $car->showroom->nmdealer ?? 'Showroom Rekanan' }}
                                                </p>
                                            </div>

                                            <a href="{{ route('cars.show', $car->id) }}" class="px-3.5 py-1.5 bg-[#800000] hover:bg-[#600000] text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                                Detail Unit
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="pt-6">
                            {{ $cars->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center mx-auto text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">Unit Tidak Ditemukan</h3>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto">Coba atur ulang kata kunci atau filter pencarian Anda untuk melihat pilihan unit kendaraan lainnya.</p>
                            <a href="{{ route('cars.index') }}" class="inline-block text-xs font-bold text-[#800000] hover:underline pt-2">
                                Reset Filter Pencarian
                            </a>
                        </div>
                    @endif

                </main>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    @include('layouts.footer')
</div>
@endsection