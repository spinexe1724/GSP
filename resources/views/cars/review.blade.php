@extends('layouts.app')

@section('title', 'Review Data Unit Pending')

@section('content')
<div class="container mx-auto px-4 py-8 font-['Plus_Jakarta_Sans'] text-slate-800">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h1 class="text-xl font-black text-slate-900">Review Data Unit Tidak Cocok (CIF)</h1>
                <p class="text-xs text-slate-500 mt-0.5">Daftar unit mobil dari Excel yang CNO Showroom-nya belum terdaftar. Silakan pilih showroom secara manual.</p>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-lg">
                Pending: {{ $unmatchedCars->total() }} Unit
            </span>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-[11px] uppercase font-bold text-slate-400 bg-slate-50">
                        <th class="p-3">No. Polisi</th>
                        <th class="p-3">Merk & Tipe</th>
                        <th class="p-3">CIF Excel (Gagal)</th>
                        <th class="p-3">Pilih Showroom Benar</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-slate-100">
                    @forelse($unmatchedCars as $car)
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-3 font-bold font-mono text-slate-900">{{ $car->no_polisi }}</td>
                            <td class="p-3">
                                <div class="font-bold text-slate-900">{{ $car->nama_merk }}</div>
                                <div class="text-slate-500">{{ $car->tipe_kend }} ({{ $car->tahun_buat }})</div>
                            </td>
                            <td class="p-3 font-mono text-rose-600 font-bold">{{ $car->no_cif ?? 'Kosong' }}</td>
                            
                            {{-- Form Assign Showroom Manual --}}
                            <td class="p-3">
                                <form action="{{ route('admin.cars.review.approve', $car->id) }}" method="POST" id="approve-form-{{ $car->id }}" class="flex items-center gap-2">
                                    @csrf
                                    <select name="showroom_id" required class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#800000]">
                                        <option value="">-- Pilih Showroom --</option>
                                        @foreach($showrooms as $sh)
                                            <option value="{{ $sh->id }}">{{ $sh->nmdealer }} (CNO: {{ $sh->cno }})</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            <td class="p-3 text-center space-x-2">
                                <button type="submit" form="approve-form-{{ $car->id }}" class="px-3 py-1.5 bg-[#800000] hover:bg-[#600000] text-white font-bold rounded-lg shadow-sm transition-all">
                                    Tautkan & Masukkan
                                </button>
                                
                                <form action="{{ route('admin.cars.review.destroy', $car->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data unit gantung ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-700 font-bold rounded-lg transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">
                                Tidak ada data unit pending. Semua data CIF cocok dengan showroom!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $unmatchedCars->links() }}
        </div>

    </div>
</div>
@endsection