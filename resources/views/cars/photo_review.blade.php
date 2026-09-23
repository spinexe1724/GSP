@extends('layouts.admin')

@section('title', 'Review Foto Unit')

@section('content')

<div class="min-h-screen bg-[#f8fafc] font-['Plus_Jakarta_Sans'] text-slate-800">

```
<div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-3 space-y-3">

    @php
        // Pagination berada di level folder/nopol, bukan per foto.
        $perPage = 10;
        $currentPage = max(1, (int) request()->query('page', 1));
        $totalFolders = $groupedPhotos->count();
        $totalPages = max(1, (int) ceil($totalFolders / $perPage));
        $currentPage = min($currentPage, $totalPages);
        $pagedPhotos = $groupedPhotos->forPage($currentPage, $perPage);
    @endphp

    {{-- HEADER --}}
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-3">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div class="min-w-0">

                <div class="flex items-center gap-2 mb-1">

                    <h1 class="text-lg font-black text-slate-900">
                        Review Foto Unit
                    </h1>

                    @if($groupedPhotos->count() > 0)
                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[9px] font-bold">
                            {{ $totalFolders }} Folder
                        </span>
                    @endif

                </div>

                <p class="text-[11px] text-slate-400">
                    Kelola foto unit yang belum terpetakan ke kendaraan.
                </p>

            </div>


            <form
                action="{{ route('admin.cars.photo_review.clear') }}"
                method="POST"
                class="w-full sm:w-auto"
                onsubmit="return confirm('Peringatan: Apakah Anda yakin ingin menghapus SEMUA data foto review ini beserta file aslinya dari server? Tindakan ini tidak dapat dibatalkan.');"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                           bg-[#800000] hover:bg-red-900
                           text-white text-[10px] font-black
                           px-4 py-2.5 rounded-lg
                           uppercase tracking-wide transition"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>

                    Bersihkan Semua
                </button>

            </form>

        </div>

    </div>


    {{-- FLASH MESSAGE --}}
    @if(session('success'))

        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3">

            <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">

                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

            </div>

            <div>
                <p class="text-[10px] font-black uppercase tracking-wide">
                    Berhasil
                </p>

                <p class="text-[11px]">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    @endif


    @if(session('error'))

        <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-4 py-3">

            <div class="w-7 h-7 rounded-lg bg-rose-100 flex items-center justify-center flex-shrink-0">

                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

            </div>

            <div>
                <p class="text-[10px] font-black uppercase tracking-wide">
                    Error
                </p>

                <p class="text-[11px]">
                    {{ session('error') }}
                </p>
            </div>

        </div>

    @endif


    {{-- STATISTIK --}}
    <div class="grid grid-cols-3 gap-2">

        <div class="bg-white border border-slate-200 rounded-lg px-4 py-2.5">
            <p class="text-[9px] uppercase tracking-wide font-bold text-slate-400">
                Folder Review
            </p>

            <p class="text-xl font-black text-slate-900 mt-1">
                {{ $groupedPhotos->count() }}
            </p>
        </div>


        <div class="bg-white border border-slate-200 rounded-lg px-4 py-2.5">
            <p class="text-[9px] uppercase tracking-wide font-bold text-slate-400">
                Total Foto
            </p>

            <p class="text-xl font-black text-slate-900 mt-1">
                {{ collect($groupedPhotos)->flatten()->count() }}
            </p>
        </div>


        <div class="bg-white border border-slate-200 rounded-lg px-4 py-2.5">
            <p class="text-[9px] uppercase tracking-wide font-bold text-slate-400">
                Unit Kandidat
            </p>

            <p class="text-xl font-black text-slate-900 mt-1">
                {{ $carsNeedingPhotos->count() }}
            </p>
        </div>

    </div>


    {{-- DAFTAR FOLDER --}}
    <div class="space-y-2">

        @forelse($pagedPhotos as $nopol => $photos)

            <details
                class="review-folder group bg-white border border-slate-200 rounded-xl overflow-hidden"
            >

                {{-- FOLDER HEADER --}}
                <summary
                    class="flex items-center justify-between gap-3 px-3.5 py-2
                           cursor-pointer list-none
                           hover:bg-slate-50 transition"
                >

                    <div class="flex items-center gap-3 min-w-0">

                        <div
                            class="w-6 h-6 rounded-md bg-slate-100
                                   flex items-center justify-center flex-shrink-0
                                   transition-transform duration-200
                                   group-open:rotate-90"
                        >
                            <svg
                                class="w-3.5 h-3.5 text-slate-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </div>


                        <div class="min-w-0">

                            <div class="flex items-center gap-2 min-w-0">

                                <span class="text-[11px] font-bold text-slate-500">
                                    Nopol
                                </span>

                                <span class="text-[11px] font-black text-[#800000] uppercase truncate">
                                    {{ $nopol }}
                                </span>

                            </div>

                            <p class="text-[9px] text-slate-400">
                                {{ $photos->count() }} foto perlu ditinjau
                            </p>

                        </div>

                    </div>


                    <span
                        class="flex-shrink-0 text-[9px] font-bold
                               px-2 py-1 rounded-md
                               bg-rose-50 text-rose-600"
                    >
                        Review
                    </span>

                </summary>


                {{-- FOLDER CONTENT --}}
                <div class="border-t border-slate-100 bg-slate-50 p-4">

                    <form
                        action="{{ route('admin.cars.photo_review.assign', ['id' => $nopol]) }}"
                        method="POST"
                        class="space-y-4"
                    >

                        @csrf


                        {{-- PILIH UNIT --}}
                        <div class="bg-white border border-slate-200 rounded-xl p-3">

                            <div class="flex flex-col md:flex-row md:items-end gap-3">

                                <div class="flex-1 min-w-0">

                                    <label class="block text-[9px] uppercase tracking-wide font-bold text-slate-500 mb-1.5">
                                        Unit Mobil Tujuan
                                    </label>

                                    <select
                                        name="car_id"
                                        class="select2-car w-full"
                                        required
                                    >
                                        <option value="">
                                            -- Cari Nopol / Merk / Tipe --
                                        </option>

                                        @foreach($carsNeedingPhotos as $car)

                                            <option value="{{ $car->id }}">
                                                {{ $car->no_polisi }}
                                                -
                                                {{ $car->nama_merk }}
                                                {{ $car->tipe_kend }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <button
                                    type="submit"
                                    class="w-full md:w-auto inline-flex items-center justify-center gap-2
                                           bg-[#800000] hover:bg-red-900
                                           text-white text-[10px] font-black
                                           px-4 py-2.5 rounded-lg
                                           uppercase tracking-wide transition"
                                >

                                    <svg
                                        class="w-3.5 h-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>

                                    Simpan

                                </button>

                            </div>

                        </div>


                        {{-- GALERI HEADER --}}
                        <div class="flex items-center justify-between">

                            <div>
                                <h3 class="text-[10px] font-black text-slate-700 uppercase tracking-wide">
                                    Foto
                                </h3>

                                <p class="text-[9px] text-slate-400">
                                    Pilih slot foto
                                </p>
                            </div>

                            <span class="text-[9px] font-bold bg-white border border-slate-200 text-slate-500 px-2 py-1 rounded-md">
                                {{ $photos->count() }} File
                            </span>

                        </div>


                        {{-- GALERI --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-2.5">

                            @foreach($photos as $photo)

                                <div
                                    class="bg-white border border-slate-200 rounded-lg p-2 hover:border-slate-300 hover:shadow-sm transition"
                                >

                                    <input
                                        type="hidden"
                                        name="photos[{{ $photo->id }}][id]"
                                        value="{{ $photo->id }}"
                                    >


                                    {{-- FOTO --}}
                                    @if($photo->file_path)

                                        <a
                                            href="{{ asset($photo->file_path) }}"
                                            target="_blank"
                                            class="block mb-2 overflow-hidden rounded-lg"
                                        >

                                            <img
                                                src="{{ asset($photo->file_path) }}"
                                                alt="{{ $photo->file_name }}"
                                                class="w-full h-24 object-cover rounded-lg
                                                       hover:scale-[1.03]
                                                       transition-transform duration-200"
                                            >

                                        </a>

                                    @else

                                        <div class="w-full h-24 bg-slate-100 rounded-lg flex items-center justify-center text-[9px] text-slate-400">
                                            Tidak ada foto
                                        </div>

                                    @endif


                                    {{-- FILE NAME --}}
                                    <div
                                        class="text-[8px] font-mono bg-slate-50
                                               border border-slate-100
                                               px-1.5 py-1
                                               w-full text-center truncate
                                               rounded-md mb-2 text-slate-500"
                                        title="{{ $photo->file_name }}"
                                    >
                                        {{ $photo->file_name }}
                                    </div>


                                    {{-- SLOT --}}
                                    <label class="block text-[8px] uppercase tracking-wide font-bold text-slate-400 mb-1">
                                        Slot
                                    </label>

                                    <select
                                        name="photos[{{ $photo->id }}][slot]"
                                        class="review-slot-select w-full"
                                    >
                                        <option value="ignore">Abaikan File Ini</option>
                                        <option value="foto_depan">Foto Depan</option>
                                        <option value="foto_belakang">Foto Belakang</option>
                                        <option value="foto_samping">Foto Samping</option>
                                        <option value="foto_odometer">Foto Odometer</option>
                                    </select>
                                </div>

                            @endforeach

                        </div>

                    </form>

                </div>

            </details>

        @empty

            {{-- EMPTY STATE --}}
            <div class="bg-white border border-emerald-200 rounded-xl p-10 text-center">

                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-50 flex items-center justify-center mb-3">

                    <svg
                        class="w-6 h-6 text-emerald-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

                <h2 class="text-sm font-black text-slate-900">
                    Semua Foto Sudah Terpetakan
                </h2>

                <p class="text-[10px] text-slate-400 mt-1">
                    Tidak ada foto yang menunggu proses review.
                </p>

            </div>

        @endforelse

    </div>

</div>
```

</div>


    {{-- PAGINATION --}}
    @if($totalPages > 1)
        <div class="sticky bottom-0 z-20 -mx-2 px-2 py-2 bg-[#f8fafc]/95 backdrop-blur-sm border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-[10px] text-slate-400">
                Menampilkan
                <span class="font-bold text-slate-600">
                    {{ (($currentPage - 1) * $perPage) + 1 }}
                    - {{ min($currentPage * $perPage, $totalFolders) }}
                </span>
                dari
                <span class="font-bold text-slate-600">{{ $totalFolders }}</span>
                folder
            </p>

            <div class="flex items-center gap-1">
                @if($currentPage > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}"
                       class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900 transition"
                       aria-label="Halaman sebelumnya">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @endif

                @for($page = 1; $page <= $totalPages; $page++)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page]) }}"
                       class="inline-flex items-center justify-center min-w-7 h-7 px-2 rounded-lg border text-[10px] font-bold transition
                       {{ $page === $currentPage
                            ? 'bg-[#800000] border-[#800000] text-white'
                            : 'bg-white border-slate-200 text-slate-500 hover:border-slate-300 hover:text-slate-900' }}">
                        {{ $page }}
                    </a>
                @endfor

                @if($currentPage < $totalPages)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}"
                       class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900 transition"
                       aria-label="Halaman berikutnya">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    @endif

{{-- SELECT2 --}}

<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
/>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>

    /* SELECT2 */
    .select2-container {
        width: 100% !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 9px !important;
        background: #f8fafc !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container .select2-selection--single:hover {
        border-color: #cbd5e1 !important;
    }

    .select2-container--focus .select2-selection--single,
    .select2-container--open .select2-selection--single {
        border-color: #800000 !important;
        box-shadow: 0 0 0 2px rgba(128, 0, 0, 0.07) !important;
    }

    .select2-container .select2-selection__rendered {
        color: #334155 !important;
        font-size: 10px !important;
        font-weight: 600 !important;
        padding-left: 11px !important;
        padding-right: 30px !important;
        line-height: 36px !important;
    }

    .select2-container .select2-selection__placeholder {
        color: #94a3b8 !important;
    }

    .select2-container .select2-selection__arrow {
        height: 36px !important;
        width: 28px !important;
        right: 3px !important;
    }

    .select2-container .select2-selection__arrow b {
        border-color: #94a3b8 transparent transparent transparent !important;
        border-width: 4px 3px 0 3px !important;
    }

    .select2-container--open .select2-selection__arrow b {
        border-color: transparent transparent #800000 transparent !important;
        border-width: 0 3px 4px 3px !important;
    }

    /* DROPDOWN */
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.10) !important;
        margin-top: 3px;
    }

    .select2-search--dropdown {
        padding: 8px !important;
    }

    .select2-search--dropdown .select2-search__field {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 7px 9px !important;
        font-size: 10px !important;
        outline: none !important;
    }

    .select2-search--dropdown .select2-search__field:focus {
        border-color: #800000 !important;
    }

    .select2-results__option {
        font-size: 10px !important;
        color: #475569 !important;
        padding: 8px 10px !important;
    }

    .select2-results__option--highlighted {
        background: #800000 !important;
        color: white !important;
    }

    .select2-results__option[aria-selected="true"] {
        background: #fef2f2 !important;
        color: #800000 !important;
        font-weight: 700 !important;
    }

    /* SLOT */
    .review-slot-select {
        width: 100%;
        min-height: 34px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f8fafc;
        color: #475569;
        font-size: 9px;
        font-weight: 600;
        padding: 0 7px;
        outline: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .review-slot-select:hover {
        border-color: #cbd5e1;
    }

    .review-slot-select:focus {
        border-color: #800000;
        box-shadow: 0 0 0 2px rgba(128, 0, 0, 0.07);
    }


    /* MINIMAL PHOTO REVIEW */
    .review-folder {
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .review-folder[open] {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .04);
    }

    .review-folder summary {
        min-height: 46px;
    }

    .review-folder summary:focus-visible,
    .review-folder a:focus-visible,
    .review-slot-select:focus-visible {
        outline: 2px solid rgba(128, 0, 0, .25);
        outline-offset: 2px;
    }

    @media (max-width: 640px) {
        .review-folder summary {
            min-height: 44px;
        }
    }

    /* DETAILS */
    summary::-webkit-details-marker {
        display: none;
    }

    summary::marker {
        display: none;
    }

</style>

<script>

    $(document).ready(function () {

        /*
         * SELECT2 UNIT MOBIL
         */
        $('.select2-car').select2({
            width: '100%',
            placeholder: '-- Ketik Nopol atau Merk Mobil di sini --',
            allowClear: true,
            language: {
                noResults: function () {
                    return 'Unit tidak ditemukan';
                },
                searching: function () {
                    return 'Mencari...';
                }
            }
        });


        /*
         * OPEN FOLDER TERAKHIR SETELAH VALIDASI ERROR
         */
        @if(session('error'))

            const firstFolder = document.querySelector('.review-folder');

            if (firstFolder) {
                firstFolder.open = true;
            }

        @endif


        /*
         * PREVENT DOUBLE SUBMIT
         */
        $('form').on('submit', function () {

            const button = $(this).find('button[type="submit"]');

            if (button.length && !button.data('confirmed')) {

                button.data('confirmed', true);

                const originalHtml = button.html();

                button.html(`
                    <svg
                        class="w-3.5 h-3.5 animate-spin"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                        ></path>
                    </svg>

                    Memproses...
                `);

                button.prop('disabled', true);

                setTimeout(function () {

                    button.prop('disabled', false);
                    button.data('confirmed', false);
                    button.html(originalHtml);

                }, 10000);

            }

        });

    });

</script>

@endsection