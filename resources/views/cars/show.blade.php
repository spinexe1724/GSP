@extends('layouts.app')

@section('title', $car->brand . ' ' . $car->model . ' - Gratama Dealer')

@section('content')
<div class="pt-32 pb-20 bg-white font-['Plus_Jakarta_Sans']">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-12">
            {{-- Foto Mobil --}}
            <div class="w-full lg:w-2/3">
                <img src="{{ asset('storage/' . $car->image) }}" class="w-full rounded-[40px] shadow-2xl object-cover h-[500px]" alt="Unit Image">
            </div>

            {{-- Detail & Harga --}}
            <div class="w-full lg:w-1/3 space-y-6">
                <div>
                    <h1 class="text-4xl font-black text-slate-900">{{ $car->brand }} {{ $car->model }}</h1>
                    <p class="text-red-700 text-2xl font-black mt-2">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-100">
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase">Tahun</p>
                        <p class="text-slate-900 font-bold">{{ $car->year }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase">Transmisi</p>
                        <p class="text-slate-900 font-bold">{{ $car->transmission }}</p>
                    </div>
                </div>

                <div class="pt-8">
                    <button class="w-full bg-[#800000] text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-xl">
                        Hubungi Showroom
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection