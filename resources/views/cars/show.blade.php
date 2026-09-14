@extends('layouts.app')

@section('title', ($car->nama_merk ?? 'Mobil') . ' ' . ($car->tipe_kend ?? '') . ' - Detail Unit')

@section('content')

<div class="pt-24 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">

    <div class="max-w-6xl mx-auto px-6 space-y-8">

        {{-- =========================================================
            NAVIGASI
        ========================================================== --}}
        <div class="flex items-center justify-between">

            <a
                href="{{ route('portal.index') }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-[#800000] transition-colors"
            >
                ← Kembali ke Katalog
            </a>

            <span class="text-xs font-mono bg-slate-100 text-slate-600 px-3 py-1 rounded-xl">
                CIF: {{ $car->no_cif }}
            </span>

        </div>


        {{-- =========================================================
            GALERI 3 SISI FOTO
        ========================================================== --}}
        <div class="bg-white p-6 md:p-8 rounded-[32px] border border-slate-100 shadow-sm space-y-4">

            <h2 class="text-xs font-black text-slate-400 uppercase tracking-wider">
                Dokumentasi 3 Sisi Unit
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                {{-- =====================================================
                    FOTO DEPAN
                ====================================================== --}}
                <div class="space-y-2">

                    <span class="text-[11px] font-bold text-slate-700">
                        1. Tampak Depan
                    </span>

                    <div
                        class="relative aspect-[4/3] rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 select-none cursor-zoom-in group"
                        @if($car->foto_depan)
                            onclick="openImageModal('{{ asset($car->foto_depan) }}', 'Tampak Depan')"
                        @endif
                    >

                        @if($car->foto_depan)

                            {{-- FOTO --}}
                            <img
                                src="{{ asset($car->foto_depan) }}"
                                alt="Tampak Depan"
                                class="w-full h-full object-cover pointer-events-none select-none group-hover:scale-105 transition-transform duration-300"
                                draggable="false"
                            >


                            {{-- OVERLAY WATERMARK --}}
                            <div class="absolute inset-0 pointer-events-none overflow-hidden">

                                {{-- Watermark utama --}}
                                <div class="absolute inset-0 flex items-center justify-center -rotate-[20deg]">

                                    <span
                                        class="whitespace-nowrap text-white/70 text-xl md:text-2xl font-black tracking-[0.25em] drop-shadow-[0_2px_3px_rgba(0,0,0,0.8)]"
                                    >
                                        GRATAMA FINANCE
                                    </span>

                                </div>


                                {{-- Watermark tambahan --}}
                                <div class="absolute top-[25%] left-[-30%] w-[160%] -rotate-[20deg] text-center">

                                    <span class="text-white/45 text-[10px] md:text-xs font-black tracking-[0.3em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        PROPERTY OF GRATAMA FINANCE
                                    </span>

                                </div>


                                <div class="absolute top-[65%] left-[-30%] w-[160%] -rotate-[20deg] text-center">

                                    <span class="text-white/45 text-[10px] md:text-xs font-black tracking-[0.3em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        PROPERTY OF GRATAMA FINANCE
                                    </span>

                                </div>

                            </div>


                            {{-- LABEL --}}
                            <div class="absolute bottom-3 left-3 pointer-events-none">

                                <span class="bg-[#800000] text-white text-[9px] md:text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg uppercase tracking-wider">
                                    GRATAMA FINANCE
                                </span>

                            </div>


                            {{-- ICON ZOOM --}}
                            <div class="absolute top-3 right-3 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">

                                <div class="w-9 h-9 rounded-full bg-black/60 backdrop-blur-sm text-white flex items-center justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg>

                                </div>

                            </div>

                        @else

                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic font-semibold">
                                Belum ada foto depan
                            </div>

                        @endif

                    </div>

                </div>



                {{-- =====================================================
                    FOTO SAMPING
                ====================================================== --}}
                <div class="space-y-2">

                    <span class="text-[11px] font-bold text-slate-700">
                        2. Tampak Samping
                    </span>

                    <div
                        class="relative aspect-[4/3] rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 select-none cursor-zoom-in group"
                        @if($car->foto_samping)
                            onclick="openImageModal('{{ asset($car->foto_samping) }}', 'Tampak Samping')"
                        @endif
                    >

                        @if($car->foto_samping)

                            {{-- FOTO --}}
                            <img
                                src="{{ asset($car->foto_samping) }}"
                                alt="Tampak Samping"
                                class="w-full h-full object-cover pointer-events-none select-none group-hover:scale-105 transition-transform duration-300"
                                draggable="false"
                            >


                            {{-- OVERLAY WATERMARK --}}
                            <div class="absolute inset-0 pointer-events-none overflow-hidden">

                                <div class="absolute inset-0 flex items-center justify-center -rotate-[20deg]">

                                    <span
                                        class="whitespace-nowrap text-white/70 text-xl md:text-2xl font-black tracking-[0.25em] drop-shadow-[0_2px_3px_rgba(0,0,0,0.8)]"
                                    >
                                        GRATAMA FINANCE
                                    </span>

                                </div>


                                <div class="absolute top-[25%] left-[-30%] w-[160%] -rotate-[20deg] text-center">

                                    <span class="text-white/45 text-[10px] md:text-xs font-black tracking-[0.3em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        PROPERTY OF GRATAMA FINANCE
                                    </span>

                                </div>


                                <div class="absolute top-[65%] left-[-30%] w-[160%] -rotate-[20deg] text-center">

                                    <span class="text-white/45 text-[10px] md:text-xs font-black tracking-[0.3em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        PROPERTY OF GRATAMA FINANCE
                                    </span>

                                </div>

                            </div>


                            {{-- LABEL --}}
                            <div class="absolute bottom-3 left-3 pointer-events-none">

                                <span class="bg-[#800000] text-white text-[9px] md:text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg uppercase tracking-wider">
                                    GRATAMA FINANCE
                                </span>

                            </div>


                            {{-- ICON ZOOM --}}
                            <div class="absolute top-3 right-3 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">

                                <div class="w-9 h-9 rounded-full bg-black/60 backdrop-blur-sm text-white flex items-center justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg>

                                </div>

                            </div>

                        @else

                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic font-semibold">
                                Belum ada foto samping
                            </div>

                        @endif

                    </div>

                </div>



                {{-- =====================================================
                    FOTO BELAKANG
                ====================================================== --}}
                <div class="space-y-2">

                    <span class="text-[11px] font-bold text-slate-700">
                        3. Tampak Belakang
                    </span>

                    <div
                        class="relative aspect-[4/3] rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 select-none cursor-zoom-in group"
                        @if($car->foto_belakang)
                            onclick="openImageModal('{{ asset($car->foto_belakang) }}', 'Tampak Belakang')"
                        @endif
                    >

                        @if($car->foto_belakang)

                            {{-- FOTO --}}
                            <img
                                src="{{ asset($car->foto_belakang) }}"
                                alt="Tampak Belakang"
                                class="w-full h-full object-cover pointer-events-none select-none group-hover:scale-105 transition-transform duration-300"
                                draggable="false"
                            >


                            {{-- OVERLAY WATERMARK --}}
                            <div class="absolute inset-0 pointer-events-none overflow-hidden">

                                <div class="absolute inset-0 flex items-center justify-center -rotate-[20deg]">

                                    <span
                                        class="whitespace-nowrap text-white/70 text-xl md:text-2xl font-black tracking-[0.25em] drop-shadow-[0_2px_3px_rgba(0,0,0,0.8)]"
                                    >
                                        GRATAMA FINANCE
                                    </span>

                                </div>


                                <div class="absolute top-[25%] left-[-30%] w-[160%] -rotate-[20deg] text-center">

                                    <span class="text-white/45 text-[10px] md:text-xs font-black tracking-[0.3em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        PROPERTY OF GRATAMA FINANCE
                                    </span>

                                </div>


                                <div class="absolute top-[65%] left-[-30%] w-[160%] -rotate-[20deg] text-center">

                                    <span class="text-white/45 text-[10px] md:text-xs font-black tracking-[0.3em] drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        PROPERTY OF GRATAMA FINANCE
                                    </span>

                                </div>

                            </div>


                            {{-- LABEL --}}
                            <div class="absolute bottom-3 left-3 pointer-events-none">

                                <span class="bg-[#800000] text-white text-[9px] md:text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg uppercase tracking-wider">
                                    GRATAMA FINANCE
                                </span>

                            </div>


                            {{-- ICON ZOOM --}}
                            <div class="absolute top-3 right-3 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">

                                <div class="w-9 h-9 rounded-full bg-black/60 backdrop-blur-sm text-white flex items-center justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg>

                                </div>

                            </div>

                        @else

                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic font-semibold">
                                Belum ada foto belakang
                            </div>

                        @endif

                    </div>

                </div>

            </div>


            <p class="text-[11px] text-slate-400 italic text-center md:text-right">
                * Klik foto untuk melihat ukuran lebih besar
            </p>

        </div>



        {{-- =========================================================
            DETAIL SPESIFIKASI MOBIL & INFO SHOWROOM
        ========================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- =====================================================
                KOLOM KIRI: SPESIFIKASI MOBIL
            ====================================================== --}}
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-[32px] border border-slate-100 shadow-sm space-y-6">

                <div>

                    <div class="flex items-center gap-3">

                        <span class="bg-[#800000] text-white text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider">
                            {{ $car->nama_merk ?? 'Unit' }}
                        </span>

                        <span class="font-mono text-xs font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-md uppercase">
                            {{ $car->no_polisi ?? '-' }}
                        </span>

                    </div>


                    <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-2">
                        {{ $car->nama_merk }} {{ $car->tipe_kend }} ({{ $car->tahun_buat ?? '-' }})
                    </h1>

                </div>


                {{-- Grid Rincian Spesifikasi --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-100 text-xs">

                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">
                            Jenis Kendaraan
                        </span>

                        <span class="font-black text-slate-800 text-sm mt-0.5 block">
                            {{ $car->jenis_kend ?? '-' }}
                        </span>
                    </div>


                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">
                            Transmisi
                        </span>

                        <span class="font-black text-slate-800 text-sm mt-0.5 block">
                            {{ $car->transmisi ?? '-' }}
                        </span>
                    </div>


                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">
                            Warna
                        </span>

                        <span class="font-black text-slate-800 text-sm mt-0.5 block">
                            {{ $car->warna_kend ?? '-' }}
                        </span>
                    </div>


                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">
                            Tahun Pembuatan
                        </span>

                        <span class="font-black text-slate-800 text-sm mt-0.5 block">
                            {{ $car->tahun_buat ?? '-' }}
                        </span>
                    </div>


                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">
                            Plat Nomor
                        </span>

                        <span class="font-black text-slate-800 text-sm mt-0.5 block font-mono uppercase">
                            {{ $car->no_polisi ?? '-' }}
                        </span>
                    </div>


                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">
                            Nomor CIF
                        </span>

                        <span class="font-black text-slate-800 text-sm mt-0.5 block font-mono">
                            {{ $car->no_cif ?? '-' }}
                        </span>
                    </div>

                </div>

            </div>



            {{-- =====================================================
                KOLOM KANAN: INFO SHOWROOM
            ====================================================== --}}
            <div class="bg-white p-6 md:p-8 rounded-[32px] border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">

                <div class="space-y-4">

                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider">
                        Showroom Pemilik Unit
                    </h3>


                    @if($car->showroom)

                        <div class="space-y-3">

                            <h4 class="text-lg font-black text-slate-900">
                                {{ $car->showroom->nmdealer ?? 'Showroom Tanpa Nama' }}
                            </h4>


                            <div class="text-xs text-slate-600 space-y-1.5 leading-relaxed">

                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Pemilik:
                                    </span>

                                    {{ $car->showroom->cnm ?? '-' }}
                                </p>


                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Kota / Wilayah:
                                    </span>

                                    {{ $car->showroom->kota ?? '-' }}
                                </p>


                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Alamat:
                                    </span>

                                    {{ $car->showroom->ad1 ?? $car->showroom->alamat ?? '-' }}
                                </p>


                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Kode Cabang:
                                    </span>

                                    {{ $car->showroom->kdcab ?? '-' }}
                                </p>

                            </div>

                        </div>

                    @else

                        <div class="p-4 bg-amber-50 text-amber-800 rounded-2xl text-xs">
                            Data showroom belum terhubung dengan CIF ini.
                        </div>

                    @endif

                </div>


                {{-- Unit Lain di Showroom Ini --}}
                @if($relatedCars->isNotEmpty())

                    <div class="pt-4 border-t border-slate-100 space-y-2">

                        <p class="text-[11px] font-bold text-slate-400 uppercase">
                            Unit Lain Showroom Ini:
                        </p>


                        <div class="space-y-2">

                            @foreach($relatedCars as $rel)

                                <a
                                    href="{{ route('cars.show', $rel->id) }}"
                                    class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-colors text-xs"
                                >

                                    <span class="font-bold text-slate-800 truncate">
                                        {{ $rel->nama_merk }} {{ $rel->tipe_kend }}
                                    </span>

                                    <span class="font-mono text-[10px] text-slate-400 uppercase">
                                        {{ $rel->no_polisi }}
                                    </span>

                                </a>

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
    IMAGE POPUP / MODAL
============================================================== --}}
<div
    id="imageModal"
    class="fixed inset-0 z-[9999] hidden bg-black/90 backdrop-blur-sm"
    aria-hidden="true"
>

    {{-- Tombol Close --}}
    <button
        type="button"
        onclick="closeImageModal()"
        class="absolute top-5 right-5 z-[10001] w-11 h-11 rounded-full
               bg-white/10 hover:bg-white/20 border border-white/20
               text-white text-3xl leading-none flex items-center justify-center
               transition-all duration-200"
        aria-label="Tutup"
    >
        &times;
    </button>


    {{-- Judul Foto --}}
    <div class="absolute top-6 left-6 z-[10001]">

        <span
            id="modalTitle"
            class="bg-[#800000] text-white text-[10px] md:text-xs
                   font-black px-4 py-2 rounded-xl shadow-lg uppercase tracking-wider"
        >
            Detail Foto
        </span>

    </div>


    {{-- Area Popup --}}
    <div
        class="w-full h-full flex items-center justify-center p-4 md:p-10"
        onclick="closeImageModal()"
    >

        <div
            class="relative max-w-7xl max-h-full"
            onclick="event.stopPropagation()"
        >

            {{-- Foto Besar --}}
            <img
                id="modalImage"
                src=""
                alt="Detail Foto Unit"
                class="max-w-full max-h-[88vh] object-contain rounded-xl
                       select-none shadow-2xl"
                draggable="false"
            >


            {{-- =====================================================
                WATERMARK DI DALAM POPUP
            ====================================================== --}}
            <div
                class="absolute inset-0 pointer-events-none overflow-hidden rounded-xl"
            >

                {{-- Watermark Utama --}}
                <div class="absolute inset-0 flex items-center justify-center -rotate-[20deg]">

                    <span
                        class="whitespace-nowrap text-white/65
                               text-3xl sm:text-4xl md:text-5xl lg:text-6xl
                               font-black tracking-[0.3em]
                               drop-shadow-[0_2px_5px_rgba(0,0,0,0.9)]"
                    >
                        GRATAMA FINANCE
                    </span>

                </div>


                {{-- Watermark 1 --}}
                <div
                    class="absolute top-[22%] left-[-25%] w-[150%]
                           -rotate-[20deg] text-center"
                >

                    <span
                        class="text-white/40 text-sm md:text-lg
                               font-black tracking-[0.3em]
                               drop-shadow-[0_2px_3px_rgba(0,0,0,0.8)]"
                    >
                        PROPERTY OF GRATAMA FINANCE
                    </span>

                </div>


                {{-- Watermark 2 --}}
                <div
                    class="absolute top-[70%] left-[-25%] w-[150%]
                           -rotate-[20deg] text-center"
                >

                    <span
                        class="text-white/40 text-sm md:text-lg
                               font-black tracking-[0.3em]
                               drop-shadow-[0_2px_3px_rgba(0,0,0,0.8)]"
                    >
                        PROPERTY OF GRATAMA FINANCE
                    </span>

                </div>

            </div>


            {{-- Label Watermark --}}
            <div class="absolute bottom-4 left-4 pointer-events-none">

                <span
                    class="bg-[#800000]/90 text-white
                           text-[9px] md:text-[11px]
                           font-black px-4 py-2 rounded-lg
                           uppercase tracking-wider shadow-lg"
                >
                    GRATAMA FINANCE
                </span>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
    JAVASCRIPT
============================================================== --}}
<script>

    /**
     * Membuka popup foto
     */
    function openImageModal(imageUrl, title) {

        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');

        if (!modal || !image) {
            return;
        }

        image.src = imageUrl;

        if (modalTitle && title) {
            modalTitle.textContent = title;
        }

        modal.classList.remove('hidden');

        modal.setAttribute('aria-hidden', 'false');

        // Disable scroll halaman ketika popup terbuka
        document.body.classList.add('overflow-hidden');
    }


    /**
     * Menutup popup foto
     */
    function closeImageModal() {

        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');

        modal.setAttribute('aria-hidden', 'true');

        // Kosongkan source agar gambar tidak tetap aktif
        if (image) {
            image.src = '';
        }

        // Kembalikan scroll halaman
        document.body.classList.remove('overflow-hidden');
    }


    /**
     * Tombol ESC untuk menutup popup
     */
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeImageModal();
        }

    });


    /**
     * Disable klik kanan
     *
     * Berlaku untuk seluruh halaman Detail Unit.
     */
    document.addEventListener('contextmenu', function (event) {

        event.preventDefault();

        return false;

    });


    /**
     * Disable drag pada gambar
     */
    document.addEventListener('dragstart', function (event) {

        if (event.target && event.target.tagName === 'IMG') {

            event.preventDefault();

            return false;

        }

    });


    /**
     * Mencegah gambar diseret pada browser tertentu
     */
    document.addEventListener('mousedown', function (event) {

        if (event.target && event.target.tagName === 'IMG') {

            if (event.button === 2) {
                event.preventDefault();
            }

        }

    });


    /**
     * Pastikan popup tidak terbuka ketika halaman baru selesai dimuat.
     */
    document.addEventListener('DOMContentLoaded', function () {

        const modal = document.getElementById('imageModal');

        if (modal) {

            modal.classList.add('hidden');

        }

    });

</script>

@endsection