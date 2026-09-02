@extends('layouts.app')

@section('title', 'Profil Showroom - ' . ($showroom->nmdealer ?? 'Showroom'))

@section('content')
<div class="pt-28 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="max-w-6xl mx-auto px-6 space-y-8">

        {{-- Notifikasi Sukses / Error --}}
        @if (session('success'))
            <div class="p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- ================= KARTU INFORMASI SHOWROOM ================= --}}
        <div class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="bg-red-50 text-red-800 text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">
                            Kode CIF / CNO: {{ $showroom->cno ?? '-' }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight mt-3">
                        {{ $showroom->nmdealer ?? 'Nama Dealer Belum Diatur' }}
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">
                        Pemilik / Penanggung Jawab: <span class="font-bold text-slate-700">{{ $showroom->cnm ?? '-' }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Counter Unit Mobil --}}
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-right min-w-[140px]">
                        <p class="text-[11px] font-black uppercase tracking-wider text-slate-400">Total Mobil</p>
                        <p class="text-2xl font-black text-[#800000] mt-0.5">
                            {{ $showroom->cars->count() }} <span class="text-xs font-bold text-slate-500">Unit</span>
                        </p>
                    </div>

                    {{-- Tombol Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin keluar?')"
                                class="flex items-center gap-2 px-5 py-3.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-2xl font-black text-xs uppercase tracking-wider transition-all active:scale-95 cursor-pointer shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Detail Alamat & Info Tambahan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <p class="text-[11px] font-black uppercase text-slate-400 tracking-wider">Alamat Showroom</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1">
                        {{ $showroom->ad1 ?? $showroom->alamat ?? '-' }}
                        @if(!empty($showroom->ad2))
                            <br>{{ $showroom->ad2 }}
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase text-slate-400 tracking-wider">Kota / Wilayah</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1">
                        {{ $showroom->kota ?? '-' }} (Cabang: {{ $showroom->kdcab ?? '-' }})
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase text-slate-400 tracking-wider">Nomor KTP Rekanan</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1">
                        {{ $showroom->clprnoktp ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ================= DAFTAR UNIT MOBIL DI SHOWROOM ================= --}}
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Daftar Unit Mobil Tersedia</h2>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Mobil yang terdaftar di showroom ini berdasarkan sinkronisasi CIF.</p>
                </div>
                <span class="text-xs font-bold text-slate-400">
                    Menampilkan {{ $showroom->cars->count() }} unit
                </span>
            </div>

            @if($showroom->cars->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($showroom->cars as $car)
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="bg-slate-100 text-slate-700 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg">
                                        Tahun {{ $car->tahun ?? '-' }}
                                    </span>
                                    <span class="bg-red-50 text-red-700 font-mono text-xs font-bold px-2.5 py-1 rounded-lg uppercase">
                                        {{ $car->nopol ?? '-' }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-black text-slate-900">
                                    {{ $car->merk ?? 'Mobil' }} {{ $car->type ?? '' }}
                                </h3>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-semibold">CIF Unit:</span>
                                <span class="font-mono font-bold text-slate-600">{{ $car->cif_dealer }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Tampilan Ketika Belum Ada Mobil --}}
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100">
                    <div class="w-16 h-16 bg-red-50 text-red-800 rounded-full flex items-center justify-center mx-auto mb-4 font-black text-2xl">
                        !
                    </div>
                    <h3 class="text-base font-black text-slate-800">Belum Ada Unit Mobil Terdaftar</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">
                        Data mobil untuk nomor CIF/CNO <span class="font-mono font-bold text-slate-600">{{ $showroom->cno ?? '-' }}</span> belum tersedia pada pembaruan data mobil harian.
                    </p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection