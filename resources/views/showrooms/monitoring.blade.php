@extends('layouts.app')

@section('title', 'Monitoring Showroom & Unit Mobil')

@section('content')
<div class="pt-28 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="max-w-7xl mx-auto px-6 space-y-6">

        {{-- Header & Statistik Singkat --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Monitoring Showroom & Unit Mobil</h1>
                <p class="text-xs text-slate-500 mt-1">Pengecekan integrasi relasi CIF / CNO dan ketersediaan foto 3 sisi unit mobil.</p>
            </div>

            {{-- Filter & Search Form --}}
            <form action="{{ route('showrooms.monitoring') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari CNO, Dealer, Nopol, KTP..." 
                       class="px-4 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:border-red-800 bg-slate-50">

                <select name="has_cars" onchange="this.form.submit()" class="px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none bg-slate-50 text-slate-700">
                    <option value="">Semua Showroom</option>
                    <option value="1" {{ request('has_cars') === '1' ? 'selected' : '' }}>Hanya yang Memiliki Mobil</option>
                </select>

                <button type="submit" class="bg-[#800000] text-white text-xs font-bold px-4 py-2 rounded-xl uppercase tracking-wider">
                    Filter
                </button>
            </form>
        </div>

        {{-- Tabel Monitoring Showroom --}}
        <div class="bg-white rounded-[28px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-6 w-1/4">Informasi Dealer</th>
                            <th class="py-4 px-6 w-1/6">CNO / Pemilik</th>
                            <th class="py-4 px-6 text-center w-24">Jml Unit</th>
                            <th class="py-4 px-6">Daftar Mobil & Foto (Depan, Samping, Belakang)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($showrooms as $showroom)
                            <tr class="hover:bg-slate-50/50 align-top">
                                {{-- Info Dealer --}}
                                <td class="py-4 px-6">
                                    <div class="font-black text-slate-900 text-sm">
                                        {{ $showroom->nmdealer ?? 'Tanpa Nama Dealer' }}
                                    </div>
                                    <div class="text-[11px] font-mono text-slate-400 mt-0.5">
                                        KTP: {{ $showroom->clprnoktp ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        Cabang: {{ $showroom->kdcab ?? '-' }}
                                    </div>
                                </td>

                                {{-- CNO & Pemilik --}}
                                <td class="py-4 px-6">
                                    @if($showroom->cno)
                                        <span class="bg-red-50 text-red-800 font-mono font-bold px-2 py-0.5 rounded text-[11px]">
                                            CNO: {{ $showroom->cno }}
                                        </span>
                                    @else
                                        <span class="text-rose-500 font-semibold italic text-[11px] bg-rose-50 px-2 py-0.5 rounded">
                                            CNO Kosong
                                        </span>
                                    @endif
                                    <div class="font-semibold text-slate-800 mt-1.5">{{ $showroom->cnm ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $showroom->kota ?? '-' }}</div>
                                </td>

                                {{-- Total Mobil --}}
                                <td class="py-4 px-6 text-center">
                                    @if($showroom->cars->count() > 0)
                                        <span class="bg-emerald-50 text-emerald-700 font-black px-2.5 py-1 rounded-xl text-xs">
                                            {{ $showroom->cars->count() }} Unit
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-400 font-bold px-2 py-1 rounded-xl text-[10px]">
                                            0
                                        </span>
                                    @endif
                                </td>

                                {{-- Rincian Unit Mobil & Foto --}}
                                <td class="py-4 px-6">
                                    @if($showroom->cars->isNotEmpty())
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($showroom->cars as $car)
                                                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3.5 space-y-3">
                                                    {{-- Info Text Mobil --}}
                                                    <div class="flex items-start justify-between gap-2 border-b border-slate-200/60 pb-2">
                                                        <div>
                                                            <div class="font-black text-slate-900 text-xs">
                                                                {{ $car->merk }} {{ $car->type }}
                                                            </div>
                                                            <div class="text-[10px] text-slate-400">
                                                                Tahun {{ $car->tahun ?? '-' }} | CIF: <span class="font-mono">{{ $car->no_cif }}</span>
                                                            </div>
                                                        </div>
                                                        <span class="bg-red-100 text-red-800 font-mono text-[10px] font-black px-2 py-0.5 rounded uppercase">
                                                            {{ $car->nopol ?? '-' }}
                                                        </span>
                                                    </div>

                                                    {{-- Baris Galeri 3 Sisi Foto --}}
                                                    <div class="grid grid-cols-3 gap-2">
                                                        {{-- Tampak Depan --}}
                                                        <div class="space-y-1">
                                                            <p class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Depan</p>
                                                            @if($car->foto_depan)
                                                                <a href="{{ asset('storage/' . $car->foto_depan) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $car->foto_depan) }}" 
                                                                         alt="Depan" 
                                                                         class="w-full h-14 object-cover rounded-lg border border-slate-200 hover:scale-105 transition-all cursor-pointer">
                                                                </a>
                                                            @else
                                                                <div class="w-full h-14 bg-slate-200/60 rounded-lg flex items-center justify-center text-[9px] text-slate-400 font-bold italic">
                                                                    Kosong
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Tampak Samping --}}
                                                        <div class="space-y-1">
                                                            <p class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Samping</p>
                                                            @if($car->foto_samping)
                                                                <a href="{{ asset('storage/' . $car->foto_samping) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $car->foto_samping) }}" 
                                                                         alt="Samping" 
                                                                         class="w-full h-14 object-cover rounded-lg border border-slate-200 hover:scale-105 transition-all cursor-pointer">
                                                                </a>
                                                            @else
                                                                <div class="w-full h-14 bg-slate-200/60 rounded-lg flex items-center justify-center text-[9px] text-slate-400 font-bold italic">
                                                                    Kosong
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Tampak Belakang --}}
                                                        <div class="space-y-1">
                                                            <p class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Belakang</p>
                                                            @if($car->foto_belakang)
                                                                <a href="{{ asset('storage/' . $car->foto_belakang) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $car->foto_belakang) }}" 
                                                                         alt="Belakang" 
                                                                         class="w-full h-14 object-cover rounded-lg border border-slate-200 hover:scale-105 transition-all cursor-pointer">
                                                                </a>
                                                            @else
                                                                <div class="w-full h-14 bg-slate-200/60 rounded-lg flex items-center justify-center text-[9px] text-slate-400 font-bold italic">
                                                                    Kosong
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-slate-300 italic text-[11px]">Belum ada unit mobil terkait</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    Tidak ada data showroom ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-6 border-t border-slate-100">
                {{ $showrooms->links() }}
            </div>
        </div>

    </div>
</div>
@endsection