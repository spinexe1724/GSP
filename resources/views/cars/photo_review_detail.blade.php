@extends('layouts.admin')
@section('title', 'Detail Review - ' . $nopol_detected)
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="min-h-screen bg-[#f8fafc] font-['Plus_Jakarta_Sans'] text-slate-800">
    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-3 space-y-4">

        {{-- TOMBOL KEMBALI & HEADER --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.cars.photo_review.index') }}" class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-slate-900 hover:border-slate-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    Review Nopol: <span class="text-[#800000] uppercase">{{ $nopol_detected }}</span>
                </h1>
                <p class="text-[11px] text-slate-400">Pilih slot untuk {{ $photos->count() }} foto yang tersedia.</p>
            </div>
        </div>

        {{-- FORM ASSIGN FOTO --}}
        <form action="{{ route('admin.cars.photo_review.assign', ['id' => $nopol_detected]) }}" method="POST" class="space-y-4 bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            @csrf

            {{-- PILIH UNIT --}}
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-4">
                <label class="block text-[10px] uppercase tracking-wide font-bold text-slate-500 mb-2">Unit Mobil Tujuan</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <select name="car_id" id="car_id" class="w-full border-slate-300 rounded-lg shadow-sm text-sm" required>
    <option value="" disabled selected>-- Cari dan Pilih Unit Berdasarkan Nopol / Merk --</option>
    @foreach($carsNeedingPhotos as $car)
        <option value="{{ $car->id }}">
            {{ $car->no_polisi }} - {{ $car->nama_merk }} {{ $car->tipe_kend }}
        </option>
    @endforeach
</select>
                    </div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#800000] hover:bg-red-900 text-white text-[10px] font-black px-6 py-2.5 rounded-lg uppercase tracking-wide transition">
                        Simpan ke Unit
                    </button>
                </div>
            </div>

            {{-- GALERI --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                @foreach($photos as $photo)
                    <div class="bg-white border border-slate-200 rounded-lg p-2 hover:border-slate-300 transition">
                        <input type="hidden" name="photos[{{ $photo->id }}][id]" value="{{ $photo->id }}">
                        
                        @if($photo->file_path)
                            <a href="{{ asset($photo->file_path) }}" target="_blank" class="block mb-2 overflow-hidden rounded-lg">
                                <img src="{{ asset($photo->file_path) }}" class="w-full h-32 object-cover rounded-lg hover:scale-[1.03] transition-transform duration-200">
                            </a>
                        @else
                            <div class="w-full h-32 bg-slate-100 rounded-lg flex items-center justify-center text-[9px] text-slate-400 mb-2">
                                Tidak ada foto
                            </div>
                        @endif

                        <div class="text-[9px] font-mono bg-slate-50 border border-slate-100 px-1.5 py-1 w-full text-center truncate rounded-md mb-2 text-slate-500" title="{{ $photo->file_name }}">
                            {{ $photo->file_name }}
                        </div>

                        <select name="photos[{{ $photo->id }}][slot]" class="w-full min-h-[34px] border border-slate-200 rounded-lg bg-slate-50 text-slate-600 text-[10px] font-bold px-2 outline-none focus:border-[#800000]">
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
</div>

<script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown dengan ID car_id
            $('#car_id').select2({
                placeholder: "-- Cari dan Pilih Unit Berdasarkan Nopol / Merk --",
                allowClear: true,
                width: '100%', // Agar lebarnya menyesuaikan container Tailwind
            });
        });
    </script>
    
    {{-- Opsional: Sedikit CSS tambahan agar tampilan Select2 cocok dengan Tailwind --}}
    <style>
        .select2-container .select2-selection--single {
            height: 42px;
            border-color: #cbd5e1; /* slate-300 */
            border-radius: 0.5rem; /* rounded-lg */
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        .select2-container--default .select2-selection--single:focus {
            border-color: #800000;
            outline: none;
        }
    </style>
@endsection