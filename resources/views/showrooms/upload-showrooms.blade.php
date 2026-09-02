@extends('layouts.app')

@section('title', 'Upload Master Showroom - Gratama Finance')

@section('content')
<div class="pt-32 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="max-w-4xl mx-auto px-6 space-y-8">
        
        {{-- Card Upload --}}
        <div class="bg-white p-8 md:p-10 rounded-[32px] shadow-sm border border-slate-100">
            <div class="mb-6">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Upload Master Showroom</h1>
                <p class="text-slate-500 text-sm mt-1">Unggah file Excel master data showroom untuk sinkronisasi akun partner.</p>
            </div>

            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-2xl flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    @if(session('totalSkipped') > 0)
                        <span class="bg-rose-100 text-rose-800 text-xs font-bold px-3 py-1 rounded-xl">
                            {{ session('totalSkipped') }} data dilewati
                        </span>
                    @endif
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-200 rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('showrooms.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-wider mb-2">Pilih File Excel (.xlsx / .xls / .csv)</label>
                    <input type="file" 
                           name="file" 
                           accept=".xlsx,.xls,.csv" 
                           required 
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-2xl p-2 bg-slate-50">
                </div>

                <button type="submit" 
                        class="w-full bg-[#800000] hover:bg-red-900 text-white font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] shadow-xl shadow-red-900/20 transition-all transform active:scale-95">
                    Mulai Upload & Validasi
                </button>
            </form>
        </div>

        {{-- ================= TABEL ALASAN DATA DILEWATI ================= --}}
        @if (session('skippedDetails') && count(session('skippedDetails')) > 0)
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-900">Rincian Data yang Tidak Masuk (Dilewati)</h2>
                        <p class="text-xs text-slate-500">Daftar baris Excel yang tidak memenuhi syarat validasi KTP 16 digit.</p>
                    </div>
                    <span class="bg-rose-50 text-rose-700 text-xs font-black px-3 py-1.5 rounded-xl">
                        Total: {{ session('totalSkipped') }} Baris
                    </span>
                </div>

                <div class="overflow-x-auto max-h-96 border border-slate-100 rounded-2xl">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-wider sticky top-0">
                            <tr>
                                <th class="py-3 px-4">Baris Excel</th>
                                <th class="py-3 px-4">Nama Dealer</th>
                                <th class="py-3 px-4">Nilai KTP Terbaca</th>
                                <th class="py-3 px-4">Alasan Ditolak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach (session('skippedDetails') as $item)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="py-3 px-4 font-bold text-slate-900">Baris {{ $item['row'] }}</td>
                                    <td class="py-3 px-4">{{ $item['dealer'] }}</td>
                                    <td class="py-3 px-4 font-mono font-bold text-slate-700">{{ $item['ktp'] }}</td>
                                    <td class="py-3 px-4 text-rose-600 font-semibold">{{ $item['reason'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection