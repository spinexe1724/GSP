@extends('layouts.app')

@section('title', 'Katalog Unit Mobil')

@section('content')
<div class="pt-24 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="max-w-7xl mx-auto px-6 space-y-8">

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

                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">

                                    <svg
                                        class="w-10 h-10 mb-1 opacity-40"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        ></path>
                                    </svg>

                                    <span class="text-[10px] font-bold uppercase tracking-wider">
                                        Foto Belum Tersedia
                                    </span>

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

@endsection