@extends('layouts.admin')

@section('title', 'Admin Dashboard - Kelola Data')

@section('content')
<div class="space-y-8">
    {{-- Header Bar --}}
    <div class="bg-white p-6 md:p-8 rounded-[28px] border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="bg-red-50 text-[#800000] text-[10px] font-black px-3 py-1 rounded-xl uppercase tracking-wider">
                Administrator Workspace
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-2">Dashboard Pengelolaan Data</h1>
            <p class="text-xs text-slate-500 mt-1">Pusat sinkronisasi data showroom, unit mobil, dan galeri foto 3 sisi.</p>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 text-xs rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl font-semibold">
            {{ session('error') }}
        </div>
    @endif

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total Showroom</p>
            <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($totalShowrooms) }}</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total Unit Mobil</p>
            <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($totalCars) }}</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Unit Memiliki Foto</p>
            <p class="text-3xl font-black text-[#800000] mt-1">{{ number_format($carsWithPhotos) }}</p>
        </div>
    </div>

    {{-- Grid 3 Panel Import Terpadu --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 md:p-8 rounded-[28px] border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
            <div class="space-y-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 1</span>
                <h3 class="text-lg font-black text-slate-900">1. Import Showroom</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Upload file Excel master showroom (kolom CNO, nama dealer, alamat, kota, dan KTP).
                </p>
            </div>
            <form action="{{ route('showrooms.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                       class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl p-2 bg-slate-50">
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-3 rounded-xl text-xs uppercase tracking-wider transition-all">
                    Upload Excel Showroom
                </button>
            </form>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-[28px] border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
            <div class="space-y-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 2</span>
                <h3 class="text-lg font-black text-slate-900">2. Import Unit Mobil</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Upload data mobil harian. Sistem mencocokkan kolom <b class="text-slate-800">no_cif</b> ke CNO showroom.
                </p>
            </div>
            <form action="{{ route('cars.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                       class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl p-2 bg-slate-50">
                <button type="submit" class="w-full bg-[#800000] hover:bg-red-900 text-white font-black py-3 rounded-xl text-xs uppercase tracking-wider transition-all">
                    Upload Excel Mobil
                </button>
            </form>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-[28px] border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
            <div class="space-y-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 3</span>
                <h3 class="text-lg font-black text-slate-900">3. Import Foto Massal</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Upload file <b class="text-slate-800">.ZIP</b> berisi folder nopol mobil. Sistem otomatis mengekstrak foto depan, samping, dan belakang.
                </p>
            </div>
            <form action="{{ route('cars.photos.zip') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="file" name="zip_file" accept=".zip" required
                       class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl p-2 bg-slate-50">
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-3 rounded-xl text-xs uppercase tracking-wider transition-all">
                    Ekstrak & Sinkron Foto ZIP
                </button>
            </form>
        </div>
    </div>
</div>
@endsection