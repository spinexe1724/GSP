@extends('layouts.app')

@section('title', 'Gratama Showroom Partners')

@section('content')

<div class="w-full min-h-screen overflow-x-clip bg-slate-50 font-['Plus_Jakarta_Sans'] text-slate-800 antialiased">

    {{-- =========================================================
         1. HERO
    ========================================================== --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#4a0000] via-[#800000] to-[#a31a1a]">
        <div class="absolute -top-24 -right-24 h-64 w-64 sm:h-80 sm:w-80 rounded-full bg-red-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 sm:h-80 sm:w-80 rounded-full bg-black/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 mx-auto w-full max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8 lg:py-16">
            <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12 lg:gap-10">

                {{-- Text Header & Search --}}
                <div class="space-y-5 text-white lg:col-span-7">
                    <div class="inline-flex max-w-full items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 backdrop-blur-md">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-red-300"></span>
                        <span class="truncate text-[9px] font-bold uppercase tracking-[0.16em] sm:text-[10px] sm:tracking-widest">
                            Gratama Showroom Partners
                        </span>
                    </div>

                    <h1 class="max-w-3xl text-2xl font-black leading-tight tracking-tight sm:text-3xl md:text-4xl lg:text-5xl">
                        Temukan Mobil Impian
                        <span class="block bg-gradient-to-r from-red-100 via-slate-100 to-white bg-clip-text text-transparent">
                            Dengan Transaksi Aman & Transparan
                        </span>
                    </h1>

                    <p class="max-w-2xl text-xs leading-relaxed text-slate-200 sm:text-sm md:text-base">
                        Jelajahi ratusan unit mobil bekas & baru terverifikasi dari jaringan showroom mitra terpercaya kami di seluruh Indonesia.
                    </p>

                    {{-- Quick Search --}}
                    <form
                        action="{{ route('cars.index') }}"
                        method="GET"
                        class="flex w-full max-w-2xl flex-col gap-2 rounded-2xl bg-white p-2 shadow-2xl shadow-black/30 sm:flex-row sm:rounded-full"
                    >
                        <div class="flex min-w-0 flex-1 items-center gap-2.5 px-2 sm:pl-4">
                            <svg class="h-4 w-4 shrink-0 text-slate-400 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari tipe mobil, brand, atau kota..."
                                class="min-w-0 w-full border-none bg-transparent py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0 sm:text-sm"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full shrink-0 rounded-xl bg-[#800000] px-6 py-3 text-[10px] font-bold uppercase tracking-wider text-white shadow-md transition hover:bg-[#600000] sm:w-auto sm:rounded-full sm:text-xs"
                        >
                            Cari Mobil
                        </button>
                    </form>
                </div>

                {{-- Featured Image --}}
                <div class="lg:col-span-5">
                    <div class="relative mx-auto w-full max-w-lg">
                        <div class="absolute -inset-1 rounded-3xl bg-white/20 blur-md"></div>

                        <div class="relative overflow-hidden rounded-2xl border border-white/40 bg-white p-2.5 shadow-2xl sm:rounded-3xl sm:p-3">
                            <img
                                src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000"
                                alt="Car Showcase"
                                class="h-52 w-full rounded-xl object-cover sm:h-64 md:h-72"
                            >

                            <div class="flex items-center justify-between gap-3 bg-white px-2 pt-3 sm:p-4">
                                <div class="min-w-0">
                                    <p class="text-[9px] font-bold uppercase tracking-wider text-[#800000]">
                                        Unit Unggulan
                                    </p>
                                    <p class="truncate text-xs font-bold text-slate-900 sm:text-sm">
                                        Kondisi OKE
                                    </p>
                                </div>

                                <span class="shrink-0 rounded-lg border border-slate-200 bg-slate-100 px-2 py-1 text-[9px] font-bold text-slate-700 sm:px-3 sm:text-xs">
                                    Garansi 1 Thn
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- =========================================================
         2. POPULAR BRANDS
    ========================================================== --}}
    <section class="border-b border-slate-200/80 bg-white py-7 sm:py-9">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-4 flex items-center justify-between gap-4 sm:mb-6">
                <div class="min-w-0">
                    <h2 class="text-sm font-extrabold tracking-tight text-slate-900 sm:text-base">
                        Merek Populer
                    </h2>
                    <p class="text-[10px] text-slate-500 sm:text-xs">
                        Pilih brand sesuai preferensi Anda
                    </p>
                </div>

                <a
                    href="{{ route('cars.index') }}"
                    class="inline-flex shrink-0 items-center gap-1 text-[10px] font-bold text-[#800000] transition-colors hover:underline sm:text-xs"
                >
                    Lihat Semua
                    <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

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

            {{-- Horizontal scroll only when the screen is too narrow --}}
            <div class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1 scrollbar-hide sm:grid sm:grid-cols-4 sm:overflow-visible md:grid-cols-6 lg:grid-cols-12">
                @foreach($popularBrands as $brand)
                    <a
                        href="{{ route('cars.index', ['brand' => $brand['name']]) }}"
                        class="flex min-w-[82px] shrink-0 flex-col items-center justify-center rounded-xl border border-slate-200/80 bg-slate-50 p-2.5 transition-all hover:border-[#800000] hover:bg-white hover:shadow-md sm:min-w-0 sm:rounded-2xl sm:p-3"
                    >
                        <div class="mb-1 flex h-7 w-7 items-center justify-center opacity-70 transition-opacity group-hover:opacity-100 sm:h-8 sm:w-8">
                            <img
                                src="{{ $brand['logo'] }}"
                                alt="{{ $brand['name'] }}"
                                class="max-h-full max-w-full object-contain grayscale transition-all hover:grayscale-0"
                            >
                        </div>

                        <span class="w-full truncate text-center text-[9px] font-bold text-slate-700 sm:text-[10px]">
                            {{ $brand['name'] }}
                        </span>
                    </a>
                @endforeach
            </div>

        </div>
    </section>


    {{-- =========================================================
         3. MAIN CATALOG
    ========================================================== --}}
    <section class="bg-slate-50 py-7 sm:py-10 lg:py-12">
        <div class="mx-auto w-full max-w-[1400px] px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-12 lg:gap-8">

                {{-- =====================================================
                     FILTER
                ====================================================== --}}
                <aside class="self-start lg:col-span-3 lg:sticky lg:top-24">

                    {{-- Mobile filter --}}
                    <details class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:hidden">
                        <summary class="flex cursor-pointer list-none items-center justify-between px-4 py-3.5">
                            <span class="flex items-center gap-2 text-sm font-extrabold text-slate-900">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 text-[#800000]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </span>
                                Filter Pencarian
                            </span>

                            <span class="text-[10px] font-bold text-[#800000]">
                                Buka
                            </span>
                        </summary>

                        <div class="border-t border-slate-100 p-4">
                            <form action="{{ route('cars.index') }}" method="GET" class="space-y-3.5">

    {{-- Keyword --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Kata Kunci
        </label>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Tipe, nopol, showroom..."
            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 placeholder-slate-400 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10"
        >
    </div>

    {{-- Cabang --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Cabang
        </label>

        <select name="branch" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Cabang</option>

            @if(isset($branches))
                @foreach($branches as $branch)
                    <option
                        value="{{ is_object($branch) ? $branch->id : $branch }}"
                        {{ request('branch') == (is_object($branch) ? $branch->id : $branch) ? 'selected' : '' }}
                    >
                        {{ is_object($branch) ? ($branch->nama_cabang ?? $branch->name ?? $branch) : $branch }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    {{-- Lokasi --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Lokasi (Wilayah)
        </label>

        <select name="location" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Wilayah</option>

            @if(isset($locations))
                @foreach($locations as $loc)
                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                        {{ $loc }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    {{-- Merek --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            Merek
        </label>

        <select name="brand" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Merek</option>

            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                    {{ $brand }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Transmisi --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            Transmisi
        </label>

        <select name="transmission" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Transmisi</option>
            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
        </select>
    </div>

    {{-- Tahun --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Tahun Kendaraan
        </label>

        <select name="year" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Pilih Tahun</option>

            @for($y = date('Y'); $y >= 2010; $y--)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="grid grid-cols-2 gap-2 pt-1">
        <a
            href="{{ route('cars.index') }}"
            class="flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-[10px] font-bold text-slate-600 transition hover:bg-slate-50"
        >
            Reset
        </a>

        <button
            type="submit"
            class="flex items-center justify-center gap-1.5 rounded-xl bg-[#800000] px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-md transition hover:bg-[#600000]"
        >
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter
        </button>
    </div>

</form>
                        </div>
                    </details>

                    {{-- Desktop filter --}}
                    <div class="hidden rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm lg:block">
                        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2">
                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 text-[#800000]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </div>

                                <h3 class="text-sm font-extrabold tracking-tight text-slate-900">
                                    Filter Pencarian
                                </h3>
                            </div>

                            <a
                                href="{{ route('cars.index') }}"
                                class="rounded-lg bg-red-50 px-2.5 py-1 text-[10px] font-bold text-[#800000] transition-colors hover:underline"
                            >
                                Reset
                            </a>
                        </div>

                        <form action="{{ route('cars.index') }}" method="GET" class="space-y-3.5">

    {{-- Keyword --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Kata Kunci
        </label>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Tipe, nopol, showroom..."
            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 placeholder-slate-400 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10"
        >
    </div>

    {{-- Cabang --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Cabang
        </label>

        <select name="branch" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Cabang</option>

            @if(isset($branches))
                @foreach($branches as $branch)
                    <option
                        value="{{ is_object($branch) ? $branch->id : $branch }}"
                        {{ request('branch') == (is_object($branch) ? $branch->id : $branch) ? 'selected' : '' }}
                    >
                        {{ is_object($branch) ? ($branch->nama_cabang ?? $branch->name ?? $branch) : $branch }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    {{-- Lokasi --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Lokasi (Wilayah)
        </label>

        <select name="location" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Wilayah</option>

            @if(isset($locations))
                @foreach($locations as $loc)
                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                        {{ $loc }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    {{-- Merek --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            Merek
        </label>

        <select name="brand" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Merek</option>

            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                    {{ $brand }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Transmisi --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            Transmisi
        </label>

        <select name="transmission" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Semua Transmisi</option>
            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
        </select>
    </div>

    {{-- Tahun --}}
    <div class="space-y-1.5">
        <label class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">
            <svg class="h-3.5 w-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Tahun Kendaraan
        </label>

        <select name="year" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 transition-all focus:border-[#800000] focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/10">
            <option value="">Pilih Tahun</option>

            @for($y = date('Y'); $y >= 2010; $y--)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="grid grid-cols-2 gap-2 pt-1">
        <a
            href="{{ route('cars.index') }}"
            class="flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-[10px] font-bold text-slate-600 transition hover:bg-slate-50"
        >
            Reset
        </a>

        <button
            type="submit"
            class="flex items-center justify-center gap-1.5 rounded-xl bg-[#800000] px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-md transition hover:bg-[#600000]"
        >
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter
        </button>
    </div>

</form>
                    </div>

                </aside>


                {{-- =====================================================
                     CATALOG
                ====================================================== --}}
                <main class="min-w-0 space-y-4 lg:col-span-9">

                    {{-- Catalog Header --}}
                    <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-5">
                        <div class="min-w-0">
                            <h2 class="text-sm font-extrabold text-slate-900 sm:text-base">
                                Katalog Unit Tersedia
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-500 sm:text-xs">
                                Menampilkan hasil sesuai dengan preferensi filter Anda.
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-medium text-slate-500 sm:text-xs">
                                Total:
                            </span>

                            <span class="rounded-lg bg-[#800000] px-2.5 py-1 text-[10px] font-black text-white sm:text-xs">
                                {{ method_exists($cars, 'total') ? $cars->total() : $cars->count() }} Unit
                            </span>
                        </div>
                    </div>


                    {{-- Product Grid --}}
                    @if($cars->count() > 0)

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">

                            @foreach ($cars as $car)

                                <div class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg">

                                    {{-- Image --}}
                                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">

                                        @if($car->foto_depan)

                                            <img
                                                src="{{ asset($car->foto_depan) }}"
                                                alt="{{ $car->nama_merk }} {{ $car->tipe_kend }}"
                                                class="h-full w-full select-none object-cover transition-transform duration-500 group-hover:scale-105"
                                                oncontextmenu="return false;"
                                                ondragstart="return false;"
                                            >

                                            {{-- Watermark --}}
                                            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                                                <div class="absolute inset-0 flex items-center justify-center -rotate-[25deg]">
                                                    <div class="rounded-xl border border-white/10 bg-black/10 px-5 py-3 text-center backdrop-blur-[1px]">
                                                        <span class="block whitespace-nowrap text-base font-black uppercase tracking-[0.18em] text-white/50 drop-shadow-[0_1px_3px_rgba(0,0,0,0.8)] sm:text-xl">
                                                            GRATAMA FINANCE
                                                        </span>

                                                        <span class="mt-0.5 block text-[6px] font-bold uppercase tracking-[0.22em] text-white/40 sm:text-[8px] sm:tracking-[0.35em]">
                                                            PROPERTY OF GRATAMA FINANCE
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="absolute left-1/2 top-1/2 h-full w-full -translate-x-1/2 -translate-y-1/2 opacity-20">
                                                    <div class="absolute left-[-30px] top-5 rotate-[-25deg] whitespace-nowrap text-[8px] font-bold uppercase tracking-[0.25em] text-white/30">
                                                        GRATAMA FINANCE
                                                    </div>

                                                    <div class="absolute bottom-5 right-[-30px] rotate-[-25deg] whitespace-nowrap text-[8px] font-bold uppercase tracking-[0.25em] text-white/30">
                                                        GRATAMA FINANCE
                                                    </div>
                                                </div>
                                            </div>

                                        @else

                                            <div class="flex h-full w-full flex-col items-center justify-center bg-slate-100 text-slate-400">
                                                <svg class="mb-1 h-7 w-7 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>

                                                <span class="text-[9px] font-medium uppercase tracking-wider">
                                                    Gambar Tidak Tersedia
                                                </span>
                                            </div>

                                        @endif


                                        {{-- Year --}}
                                        <div class="absolute right-2.5 top-2.5">
                                            <span class="rounded-md bg-white/95 px-2 py-1 text-[9px] font-bold text-slate-800 shadow-sm backdrop-blur-md sm:text-[10px]">
                                                {{ $car->tahun_buat ?? '-' }}
                                            </span>
                                        </div>


                                        {{-- Label --}}
                                        @if($car->foto_depan)
                                            <div class="absolute bottom-2.5 left-2.5">
                                                <span class="inline-flex items-center rounded-md border border-white/20 bg-[#800000]/80 px-2 py-1 text-[7px] font-black uppercase tracking-widest text-white shadow-lg backdrop-blur-md sm:text-[8px]">
                                                    Gratama Finance
                                                </span>
                                            </div>
                                        @endif

                                    </div>


                                    {{-- Body --}}
                                    <div class="flex flex-1 flex-col justify-between p-4">

                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest text-[#800000]">
                                                {{ $car->nama_merk ?? 'Mobil' }}
                                            </p>

                                            <h3 class="mt-0.5 line-clamp-2 text-xs font-extrabold text-slate-900 transition-colors group-hover:text-[#800000] sm:text-sm">
                                                {{ $car->tipe_kend ?? '-' }}
                                            </h3>

                                            {{-- Specifications --}}
                                            <div class="mt-3 grid grid-cols-2 gap-2 border-t border-slate-100 pt-3">

                                                <div class="flex min-w-0 items-center gap-1.5 text-[10px] text-slate-600">
                                                    <svg class="h-3.5 w-3.5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31.07-2.37-2.37a1.724 1.724 0 001.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543-.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    </svg>

                                                    <span class="truncate font-medium">
                                                        {{ $car->transmisi ?? 'N/A' }}
                                                    </span>
                                                </div>

                                                <div class="flex min-w-0 items-center gap-1.5 text-[10px] text-slate-600">
                                                    <svg class="h-3.5 w-3.5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                                    </svg>

                                                    <span class="truncate font-medium">
                                                        {{ $car->warna_kend ?? 'N/A' }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>


                                        {{-- Showroom + Button --}}
                                        <div class="mt-3 flex items-center justify-between gap-2 border-t border-slate-100 pt-3">

                                            <div class="min-w-0 max-w-[55%]">
                                                <p class="text-[8px] font-bold uppercase text-slate-400">
                                                    Showroom Partner
                                                </p>

                                                <p class="truncate text-[10px] font-bold text-slate-700 sm:text-[11px]">
                                                    {{ $car->showroom->nmdealer ?? 'Showroom Rekanan' }}
                                                </p>
                                            </div>

                                            <a
                                                href="{{ route('cars.show', $car->id) }}"
                                                class="shrink-0 rounded-lg bg-[#800000] px-3 py-1.5 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-[#600000] sm:text-xs"
                                            >
                                                Detail Unit
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- Pagination --}}
                        @if(method_exists($cars, 'links'))
                            <div class="overflow-x-auto pt-4">
                                {{ $cars->links() }}
                            </div>
                        @endif

                    @else

                        <div class="rounded-2xl border border-slate-200/80 bg-white p-10 text-center sm:p-12">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>

                            <h3 class="mt-3 text-sm font-bold text-slate-800">
                                Unit Tidak Ditemukan
                            </h3>

                            <p class="mx-auto mt-1 max-w-sm text-[10px] text-slate-500 sm:text-xs">
                                Coba atur ulang kata kunci atau filter pencarian Anda untuk melihat pilihan unit kendaraan lainnya.
                            </p>

                            <a
                                href="{{ route('cars.index') }}"
                                class="inline-block pt-2 text-[10px] font-bold text-[#800000] hover:underline sm:text-xs"
                            >
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


{{-- =========================================================
     RESPONSIVE HELPERS
========================================================= --}}
<style>
    html,
    body {
        max-width: 100%;
        overflow-x: clip;
    }

    summary::-webkit-details-marker {
        display: none;
    }

    summary::marker {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    @media (max-width: 639px) {
        input,
        select,
        button {
            max-width: 100%;
        }
    }
</style>

@endsection