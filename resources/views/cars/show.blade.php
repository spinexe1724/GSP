@extends('layouts.app')

@section('title', ($car->nama_merk ?? 'Mobil') . ' ' . ($car->tipe_kend ?? '') . ' - Detail Unit')

@section('content')
<div class="pt-24 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="max-w-6xl mx-auto px-6 space-y-8">

        {{-- Navigasi Balik --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('cars.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-[#800000] transition-colors">
                ← Kembali ke Katalog
            </a>
            <span class="text-xs font-mono bg-slate-100 text-slate-600 px-3 py-1 rounded-xl">
                CIF: {{ $car->no_cif }}
            </span>
        </div>

        {{-- Galeri 3 Sisi Foto (Depan, Samping, Belakang) --}}
        <div class="bg-white p-6 md:p-8 rounded-[32px] border border-slate-100 shadow-sm space-y-4">
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-wider">Dokumentasi 3 Sisi Unit</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Foto Depan --}}
                <div class="space-y-2">
                    <span class="text-[11px] font-bold text-slate-700">1. Tampak Depan</span>
                    <div class="aspect-[4/3] rounded-2xl bg-slate-100 overflow-hidden border border-slate-200">
                        @if($car->foto_depan)
                            <a href="{{ asset('storage/' . $car->foto_depan) }}" target="_blank">
                                <img src="{{ asset('storage/' . $car->foto_depan) }}" alt="Tampak Depan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic font-semibold">
                                Belum ada foto depan
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Foto Samping --}}
                <div class="space-y-2">
                    <span class="text-[11px] font-bold text-slate-700">2. Tampak Samping</span>
                    <div class="aspect-[4/3] rounded-2xl bg-slate-100 overflow-hidden border border-slate-200">
                        @if($car->foto_samping)
                            <a href="{{ asset('storage/' . $car->foto_samping) }}" target="_blank">
                                <img src="{{ asset('storage/' . $car->foto_samping) }}" alt="Tampak Samping" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic font-semibold">
                                Belum ada foto samping
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Foto Belakang --}}
                <div class="space-y-2">
                    <span class="text-[11px] font-bold text-slate-700">3. Tampak Belakang</span>
                    <div class="aspect-[4/3] rounded-2xl bg-slate-100 overflow-hidden border border-slate-200">
                        @if($car->foto_belakang)
                            <a href="{{ asset('storage/' . $car->foto_belakang) }}" target="_blank">
                                <img src="{{ asset('storage/' . $car->foto_belakang) }}" alt="Tampak Belakang" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic font-semibold">
                                Belum ada foto belakang
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 italic text-center md:text-right">* Klik pada foto untuk melihat ukuran penuh</p>
        </div>

        {{-- Detail Spesifikasi Mobil & Info Showroom --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Spesifikasi Mobil --}}
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
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Jenis Kendaraan</span>
                        <span class="font-black text-slate-800 text-sm mt-0.5 block">{{ $car->jenis_kend ?? '-' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Transmisi</span>
                        <span class="font-black text-slate-800 text-sm mt-0.5 block">{{ $car->transmisi ?? '-' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Warna</span>
                        <span class="font-black text-slate-800 text-sm mt-0.5 block">{{ $car->warna_kend ?? '-' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Tahun Pembuatan</span>
                        <span class="font-black text-slate-800 text-sm mt-0.5 block">{{ $car->tahun_buat ?? '-' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Plat Nomor</span>
                        <span class="font-black text-slate-800 text-sm mt-0.5 block font-mono uppercase">{{ $car->no_polisi ?? '-' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor CIF</span>
                        <span class="font-black text-slate-800 text-sm mt-0.5 block font-mono">{{ $car->no_cif ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Info Showroom Pemilik --}}
            <div class="bg-white p-6 md:p-8 rounded-[32px] border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider">Showroom Pemilik Unit</h3>

                    @if($car->showroom)
                        <div class="space-y-3">
                            <h4 class="text-lg font-black text-slate-900">
                                {{ $car->showroom->nmdealer ?? 'Showroom Tanpa Nama' }}
                            </h4>
                            
                            <div class="text-xs text-slate-600 space-y-1.5 leading-relaxed">
                                <p><span class="font-semibold text-slate-800">Pemilik:</span> {{ $car->showroom->cnm ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Kota / Wilayah:</span> {{ $car->showroom->kota ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Alamat:</span> {{ $car->showroom->ad1 ?? $car->showroom->alamat ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Kode Cabang:</span> {{ $car->showroom->kdcab ?? '-' }}</p>
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
                        <p class="text-[11px] font-bold text-slate-400 uppercase">Unit Lain Showroom Ini:</p>
                        <div class="space-y-2">
                            @foreach($relatedCars as $rel)
                                <a href="{{ route('cars.show', $rel->id) }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-colors text-xs">
                                    <span class="font-bold text-slate-800 truncate">{{ $rel->nama_merk }} {{ $rel->tipe_kend }}</span>
                                    <span class="font-mono text-[10px] text-slate-400 uppercase">{{ $rel->no_polisi }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection