<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($car->nama_merk ?? 'Mobil') . ' ' . ($car->tipe_kend ?? '') }} - Gratama</title>

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
            background: #f3f4f6;
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="min-h-screen bg-[#F3F4F6] text-slate-800 antialiased">

    {{-- =========================================================
         NAVBAR STANDALONE
    ========================================================== --}}
    <header class="sticky top-0 z-[100] border-b border-slate-200/80 bg-white/95 backdrop-blur-xl shadow-[0_4px_20px_rgba(15,23,42,0.05)]">
        <div class="mx-auto flex h-[72px] w-full max-w-7xl items-center justify-between px-5 sm:px-6 lg:px-8">

            {{-- Logo --}}
            <a href="{{ route('portal.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
                

                <span class="text-xl font-extrabold tracking-tight text-slate-900">
                    Gratama
                </span>
            </a>

        </div>
    </header>
<div class="relative pt-8 sm:pt-10 pb-16 sm:pb-20 bg-[#F3F4F6] min-h-screen font-['Plus_Jakarta_Sans'] overflow-x-hidden">
    {{-- PREMIUM FINANCE V2: visible but elegant Gratama background --}}
    <div class="pointer-events-none absolute inset-0 -z-0 overflow-hidden">

        {{-- Base tonal layer --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#EEF1F4] via-[#F5F6F8] to-[#E8ECEF]"></div>

        {{-- Maroon ambient areas --}}
        <div class="absolute -left-24 top-24 h-[560px] w-[560px] rounded-full bg-[#800000]/[0.11] blur-[120px]"></div>
        <div class="absolute -right-28 bottom-[-120px] h-[620px] w-[620px] rounded-full bg-[#800000]/[0.085] blur-[130px]"></div>

        {{-- Large diagonal brand planes --}}
        <div
            class="absolute -right-[10%] top-[18%] h-[330px] w-[58%] rotate-[-7deg] rounded-[80px] bg-gradient-to-r from-[#800000]/[0.045] via-[#800000]/[0.075] to-transparent"
        ></div>

        <div
            class="absolute -left-[14%] bottom-[18%] h-[260px] w-[48%] rotate-[6deg] rounded-[70px] border border-[#800000]/[0.10] bg-white/25"
        ></div>

        {{-- Fine architectural lines --}}
        <div class="absolute left-[6%] right-[6%] top-24 h-px bg-gradient-to-r from-transparent via-[#800000]/25 to-transparent"></div>
        <div class="absolute left-[18%] right-[18%] bottom-24 h-px bg-gradient-to-r from-transparent via-slate-400/35 to-transparent"></div>

        {{-- Subtle oversized brand mark --}}
        <div class="absolute -right-8 top-1/2 -translate-y-1/2 select-none text-[240px] font-black leading-none tracking-[-0.09em] text-[#800000]/[0.035]">
            G
        </div>

        {{-- Small vertical identity accent --}}
        <div class="absolute left-[5%] top-1/2 h-28 w-1 -translate-y-1/2 rounded-full bg-gradient-to-b from-transparent via-[#800000]/45 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 space-y-8">

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
</div>


        {{-- =========================================================
            GALERI UNIT — MARKETPLACE STYLE
        ========================================================== --}}
        @php
            $galleryImages = collect([
                ['label' => 'Tampak Depan', 'path' => $car->foto_depan],
                ['label' => 'Tampak Samping', 'path' => $car->foto_samping],
                ['label' => 'Tampak Belakang', 'path' => $car->foto_belakang],
                ['label' => 'Tampak Odometer', 'path' => $car->foto_odometer],
            ])->filter(fn ($item) => !empty($item['path']))->values();
        @endphp

        <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            <div class="relative bg-[#101214]">
                <div id="mainGalleryStage" class="relative flex h-[360px] w-full items-center justify-center overflow-hidden sm:h-[450px] lg:h-[520px]">
                    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(128,0,0,0.10),transparent_55%)]"></div>

                    @if($galleryImages->isNotEmpty())
                        @foreach($galleryImages as $index => $image)
                            <img
                                id="galleryImage{{ $index }}"
                                src="{{ asset($image['path']) }}"
                                alt="{{ $image['label'] }}"
                                class="gallery-main-image absolute inset-0 mx-auto h-full w-full object-contain px-4 py-4 transition-opacity duration-300 {{ $index === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}"
                                draggable="false"
                                data-index="{{ $index }}"
                                data-src="{{ asset($image['path']) }}"
                                data-title="{{ $image['label'] }}"
                            >
                        @endforeach

                        {{-- Watermark tetap ada, tetapi jauh lebih pudar --}}
                        <div class="pointer-events-none absolute inset-0 overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center -rotate-[18deg]">
                                <span class="whitespace-nowrap text-white/[0.20] text-2xl sm:text-4xl lg:text-5xl font-black tracking-[0.28em]">
                                    GRATAMA FINANCE
                                </span>
                            </div>

                            <div class="absolute top-[25%] left-[-25%] w-[150%] -rotate-[18deg] text-center">
                                <span class="text-white/[0.12] text-[10px] sm:text-xs lg:text-sm font-bold tracking-[0.28em]">
                                    PROPERTY OF GRATAMA FINANCE
                                </span>
                            </div>

                            <div class="absolute top-[67%] left-[-25%] w-[150%] -rotate-[18deg] text-center">
                                <span class="text-white/[0.12] text-[10px] sm:text-xs lg:text-sm font-bold tracking-[0.28em]">
                                    PROPERTY OF GRATAMA FINANCE
                                </span>
                            </div>
                        </div>

                        <div class="absolute left-4 top-4 z-20 rounded-full bg-black/55 px-3 py-1.5 text-[10px] font-bold text-white backdrop-blur-md">
                            <span id="galleryCounter">1</span> / {{ $galleryImages->count() }}
                        </div>

                        <div class="absolute bottom-4 left-4 z-20 rounded-lg bg-black/55 px-3 py-1.5 text-[10px] font-semibold text-white backdrop-blur-md">
                            <span id="galleryTitle">{{ $galleryImages[0]['label'] }}</span>
                        </div>

                        <button type="button" onclick="openImageModalFromGallery()"
                            class="absolute right-4 top-4 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-md transition hover:bg-black/70"
                            aria-label="Perbesar foto">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 3H5a2 2 0 00-2 2v3m13-5h3a2 2 0 012 2v3M3 16v3a2 2 0 002 2h3m13-5v3a2 2 0 01-2 2h-3" />
                            </svg>
                        </button>

                        @if($galleryImages->count() > 1)
                            <button type="button" onclick="changeGalleryImage(-1)"
                                class="absolute left-4 top-1/2 z-20 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-md transition hover:bg-black/75"
                                aria-label="Foto sebelumnya">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button type="button" onclick="changeGalleryImage(1)"
                                class="absolute right-4 top-1/2 z-20 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-md transition hover:bg-black/75"
                                aria-label="Foto berikutnya">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center gap-3 text-slate-500">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                            </svg>
                            <span class="text-sm font-semibold">Foto unit belum tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($galleryImages->isNotEmpty())
                <div class="border-t border-slate-100 bg-white px-4 py-4 sm:px-5">
                    <div class="flex gap-3 overflow-x-auto pb-1">
                        @foreach($galleryImages as $index => $image)
                            <button type="button" onclick="selectGalleryImage({{ $index }})"
                                class="gallery-thumbnail group relative h-[76px] w-[100px] shrink-0 overflow-hidden rounded-xl border-2 {{ $index === 0 ? 'border-[#800000]' : 'border-transparent' }} bg-slate-100 transition sm:h-[86px] sm:w-[115px]"
                                data-thumb-index="{{ $index }}" aria-label="{{ $image['label'] }}">
                                <img src="{{ asset($image['path']) }}" alt="{{ $image['label'] }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105" draggable="false">
                                <span class="pointer-events-none absolute inset-0 flex items-center justify-center -rotate-[18deg]">
                                    <span class="whitespace-nowrap text-[7px] font-black tracking-[0.18em] text-white/[0.25]">GRATAMA</span>
                                </span>
                                <span class="absolute bottom-1 left-1 rounded-md bg-black/55 px-1.5 py-0.5 text-[8px] font-bold text-white">{{ $index + 1 }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

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

                            <a href="{{ route('cars.index', ['showroom_id' => $car->showroom->id]) }}" 
                               class="inline-block hover:text-green-600 hover:underline transition-colors duration-200">
                                
                                <h3 class="text-xl font-bold uppercase text-gray-900 hover:text-green-600">
                                    {{ $car->showroom->nmdealer ?? 'NAMA SHOWROOM' }}
                                </h3>
                                
                            </a>

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
                                         Cabang:
                                    </span>

                                    {{ $car->showroom->inisial ?? '-' }}
                                </p>

                            </div>

                        </div>
                        

                    @else

                        <div class="p-4 bg-amber-50 text-amber-800 rounded-2xl text-xs">
                            Data showroom belum terhubung dengan CIF ini.
                        </div>

                    @endif

                </div>

                @php
                    // 1. Ambil data dari kolom 'nopic' sesuai yang ada di database
                    $rawNoWa = $car->showroom->nopic ?? ''; 
                    
                    // 2. BERSIHKAN KARAKTER: Hapus semua karakter selain angka (menghapus spasi, strip, dll)
                    $cleanNoWa = preg_replace('/[^0-9]/', '', $rawNoWa);

                    // 3. Format nomor: Ubah angka 0 di depan menjadi 62
                    if (str_starts_with($cleanNoWa, '0')) {
                        $finalNoWa = '62' . substr($cleanNoWa, 1);
                    } else {
                        $finalNoWa = $cleanNoWa;
                    }

                    // Buat template pesan otomatis 
                    $pesan = urlencode("Halo, saya tertarik dengan unit " . $car->nama_merk . " " . $car->tipe_kend . " ");
                @endphp

                {{-- Pengecekan menggunakan variabel yang sudah dibersihkan ($finalNoWa) --}}
                @if($finalNoWa)
                    <a href="https://wa.me/{{ $finalNoWa }}?text={{ $pesan }}" target="_blank" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-md transition duration-200">
                        
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.12.549 4.14 1.59 5.945L.044 24l6.196-1.554a11.96 11.96 0 005.791 1.493h.004c6.645 0 12.031-5.385 12.031-12.031S18.676 0 12.031 0zm0 21.916h-.004a9.92 9.92 0 01-5.05-1.372l-.362-.214-3.754.94.957-3.662-.235-.374A9.924 9.924 0 012.031 12.03c0-5.518 4.49-10.007 10.005-10.007 2.673 0 5.184 1.042 7.073 2.932 1.89 1.89 2.93 4.4 2.93 7.075 0 5.517-4.49 10.006-10.008 10.006zm5.494-7.513c-.3-.15-1.782-.88-2.059-.98-.277-.101-.479-.15-.68.15-.202.301-.782.981-.958 1.182-.176.201-.353.226-.654.075-1.637-.818-2.736-1.523-3.805-3.376-.207-.358.204-.33.791-1.491.075-.15.038-.276-.019-.401-.056-.126-.68-1.637-.932-2.242-.246-.593-.496-.511-.68-.521h-.581c-.201 0-.528.075-.804.376-.277.301-1.056 1.03-1.056 2.511 0 1.48 1.082 2.91 1.233 3.111.15.2 2.121 3.238 5.14 4.542 2.213.953 2.909 1.033 3.992.87 1.2-.181 3.513-1.436 4.004-2.825.49-1.39.49-2.583.34-2.834-.151-.252-.554-.402-.855-.553z"></path>
                        </svg>
                        Chat Showroom
                    </a>
                @else
                    <span class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-300 text-gray-600 font-bold rounded-lg cursor-not-allowed">
                        Nomor WA Tidak Tersedia
                    </span>
                @endif

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
</a>

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

        </div>
     
    </div>
    
</div>

    </div>
@if($relatedCars->count() > 0)
<div class="relative w-full max-w-6xl mx-auto mt-10 px-4">
    <h2 class="text-xl font-bold text-slate-600 mb-4">Unit lain yang ada di Showroom ini</h2>
    
    <!-- Tombol Kiri -->
    <button onclick="scrollSlider('sellerSlider', -1)" class="absolute left-0 top-[55%] -translate-y-1/2 bg-white shadow-md rounded-full p-2 z-10 hidden md:block hover:bg-gray-100">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>

    <!-- Wrapper Slider -->
    <div id="sellerSlider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-4 scroll-smooth">
        @foreach($relatedCars as $item)
        <!-- Card Item -->
        <a href="{{ route('cars.show', $item->id) }}" class="min-w-[220px] md:min-w-[240px] bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm snap-start hover:shadow-md transition-shadow duration-300 relative group flex-shrink-0 block">
            <div class="relative h-40 bg-gray-100">
                <!-- Asumsi kolom gambar adalah $item->image, sesuaikan dengan nama kolom Anda -->
                <img src="{{ asset($item->foto_depan) }}" alt="{{ $item->merk }}" class="w-full h-full object-cover">
                
                <!-- Badge Super Dealer (Opsional) -->
                
            </div>
            
            <div class="p-3">
                <h3 class="font-bold text-[#004e7c] text-lg mb-1">{{$item->nama_merk}}</h3>
                <p class="text-sm text-gray-500 truncate">{{ $item->merk }} {{ $item->tipe_kend }}</p>
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
             <div class="absolute right-2.5 top-2.5">
                                            <span class="rounded-md bg-white/95 px-2 py-1 text-[9px] font-bold text-slate-800 shadow-sm backdrop-blur-md sm:text-[10px]">
                                                {{ $car->tahun_buat ?? '-' }}
                                            </span>
                                        </div>
                                        
                                        
        </a>
        
        @endforeach
    </div>

    <!-- Tombol Kanan -->
    <button onclick="scrollSlider('sellerSlider', 1)" class="absolute right-0 top-[55%] -translate-y-1/2 bg-white shadow-md rounded-full p-2 z-10 hidden md:block hover:bg-gray-100">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
</div>
@endif

<!-- SECTION 2: IKLAN TERKAIT (TIPE KENDARAAN SAMA) -->
@if($similarTypeCars->count() > 0)
<div class="relative w-full max-w-6xl mx-auto mt-8 mb-12 px-4">
    <h2 class="text-xl font-bold text-slate-600 mb-4">Tipe Unit yang terkait</h2>
    
    <!-- Tombol Kiri -->
    <button onclick="scrollSlider('similarSlider', -1)" class="absolute left-0 top-[55%] -translate-y-1/2 bg-white shadow-md rounded-full p-2 z-10 hidden md:block hover:bg-gray-100">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>

    <!-- Wrapper Slider -->
    <div id="similarSlider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-4 scroll-smooth">
        @foreach($similarTypeCars as $item)
        <!-- Card Item -->
        <a href="{{ route('cars.show', $item->id) }}" class="min-w-[220px] md:min-w-[240px] bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm snap-start hover:shadow-md transition-shadow duration-300 relative group flex-shrink-0 block">
            <div class="relative h-40 bg-gray-100">
                <img src="{{ asset($item->foto_depan) }}" alt="{{ $item->merk }}" class="w-full h-full object-cover">
            </div>
            <div class="p-3">
                <h3 class="font-bold text-[#004e7c] text-lg mb-1">{{$item->nama_merk}}</h3>
                <p class="text-sm text-gray-500 truncate">{{ $item->merk }} {{ $item->tipe_kend }}</p>
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
             <div class="absolute right-2.5 top-2.5">
                                            <span class="rounded-md bg-white/95 px-2 py-1 text-[9px] font-bold text-slate-800 shadow-sm backdrop-blur-md sm:text-[10px]">
                                                {{ $car->tahun_buat ?? '-' }}
                                            </span>
                                        </div>
        </a>
        @endforeach
    </div>

    <!-- Tombol Kanan -->
    <button onclick="scrollSlider('similarSlider', 1)" class="absolute right-0 top-[55%] -translate-y-1/2 bg-white shadow-md rounded-full p-2 z-10 hidden md:block hover:bg-gray-100">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
</div>
@endif
</div>




    {{-- =========================================================
         FOOTER STANDALONE — SELARAS DENGAN HOMEPAGE
    ========================================================== --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-6 md:px-10">
            <div class="flex flex-col items-center justify-between gap-4 md:flex-row">

                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#800000]">
                        <span class="text-sm font-black text-white">G</span>
                    </div>

                    <div>
                        <div class="text-sm font-bold text-slate-900">GSP</div>
                        <div class="text-[11px] text-slate-400">
                            Gratama Showroom Partners
                        </div>
                    </div>
                </div>

                <nav class="flex items-center gap-5 text-xs font-medium text-slate-500">
                    <a href="{{ route('portal.index') }}"
                       class="transition hover:text-[#800000]">
                        Beranda
                    </a>

                    <a href="{{ route('cars.index') }}"
                       class="transition hover:text-[#800000]">
                        Mobil
                    </a>

                    <a href="{{ route('portal.index') }}#brands"
                       class="transition hover:text-[#800000]">
                        Merek
                    </a>

                    <a href="{{ route('portal.index') }}#contact"
                       class="transition hover:text-[#800000]">
                        Kontak
                    </a>
                </nav>

                <div class="text-center text-[11px] text-slate-400 md:text-right">
                    © 2026 GSP
                </div>

            </div>
        </div>
    </footer>


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
                        class="whitespace-nowrap text-white/[0.28]
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
                        class="text-white/[0.16] text-sm md:text-lg
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
                        class="text-white/[0.16] text-sm md:text-lg
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
                    class="bg-[#800000]/80 text-white
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

    let currentGalleryIndex = 0;

    function getGalleryImages() {
        return Array.from(document.querySelectorAll('.gallery-main-image'));
    }

    function selectGalleryImage(index) {
        const images = getGalleryImages();
        const thumbs = Array.from(document.querySelectorAll('.gallery-thumbnail'));
        const title = document.getElementById('galleryTitle');
        const counter = document.getElementById('galleryCounter');

        if (!images.length || !images[index]) return;
        currentGalleryIndex = index;

        images.forEach((image, i) => {
            image.classList.toggle('opacity-100', i === index);
            image.classList.toggle('opacity-0', i !== index);
            image.classList.toggle('pointer-events-none', i !== index);
        });

        thumbs.forEach((thumb, i) => {
            thumb.classList.toggle('border-[#800000]', i === index);
            thumb.classList.toggle('border-transparent', i !== index);
        });

        if (title) title.textContent = images[index].dataset.title || 'Foto Unit';
        if (counter) counter.textContent = index + 1;
    }

    function changeGalleryImage(direction) {
        const images = getGalleryImages();
        if (images.length < 2) return;

        let nextIndex = currentGalleryIndex + direction;
        if (nextIndex < 0) nextIndex = images.length - 1;
        if (nextIndex >= images.length) nextIndex = 0;

        selectGalleryImage(nextIndex);
    }

    function openImageModalFromGallery() {
        const images = getGalleryImages();
        const activeImage = images[currentGalleryIndex];
        if (!activeImage) return;

        openImageModal(
            activeImage.dataset.src || activeImage.src,
            activeImage.dataset.title || 'Detail Foto'
        );
    }

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
function scrollSlider(sliderId, direction) {
        const slider = document.getElementById(sliderId);
        // Menggeser sebesar lebar kira-kira 1 card + gap (misal 260px)
        const scrollAmount = 260; 
        slider.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
    }
</script>

</body>
</html>
