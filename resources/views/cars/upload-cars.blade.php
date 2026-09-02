@extends('layouts.app')

@section('title', 'Upload Data Mobil - Gratama Dealer')

@section('content')
<div class="pt-32 pb-20 bg-[#F8F9FA] min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="max-w-xl mx-auto px-6">
        
        <div class="bg-white p-8 md:p-10 rounded-[32px] shadow-sm border border-slate-100">
            <div class="mb-6">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Upload Data Mobil</h1>
                <p class="text-slate-500 text-sm mt-1">Unggah file Excel unit mobil untuk disinkronisasikan dengan dealer.</p>
            </div>

            {{-- Pesan Notifikasi Sukses --}}
            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pesan Notifikasi Error --}}
            @if (session('error'))
                <div class="p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-200 rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- List Validasi Gagal --}}
            @if ($errors->any())
                <div class="p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-200 rounded-2xl">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cars.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-wider mb-2">Pilih File Excel Mobil (.xlsx / .xls / .csv)</label>
                    <input type="file" 
                           name="file" 
                           accept=".xlsx,.xls,.csv" 
                           required 
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-2xl p-2 bg-slate-50">
                </div>

                <button type="submit" 
                        class="w-full bg-[#800000] hover:bg-red-900 text-white font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] shadow-xl shadow-red-900/20 transition-all transform active:scale-95">
                    Proses & Update Data Mobil
                </button>
            </form>
        </div>
{{-- CARD UPLOAD MASSAL FOTO MOBIL (ZIP) --}}
<div class="bg-white p-8 md:p-10 rounded-[32px] shadow-sm border border-slate-100 mt-8">
    <div class="mb-6">
        <span class="bg-blue-50 text-blue-700 text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">
            Fitur Praktis
        </span>
        <h2 class="text-xl font-black text-slate-900 tracking-tight mt-2">Upload Massal Foto Unit (File ZIP)</h2>
        <p class="text-slate-500 text-xs mt-1 leading-relaxed">
            Satukan semua folder mobil (yang bernama <b>Nopol</b>) ke dalam 1 file <b>.zip</b>, lalu upload di sini. Sistem akan otomatis mengekstrak dan memasangkan foto ke mobil yang sesuai.
        </p>
    </div>

    {{-- Info Ketentuan Nama File --}}
    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl mb-6 text-xs text-slate-600 space-y-1">
        <p class="font-bold text-slate-800">💡 Tips Penamaan File dalam Folder Nopol:</p>
        <p>• Foto Depan: Beri nama mengandung kata <code class="bg-white px-1.5 py-0.5 rounded text-red-700 font-bold">depan</code> atau <code class="bg-white px-1.5 py-0.5 rounded text-red-700 font-bold">1.jpg</code></p>
        <p>• Foto Samping: Beri nama mengandung kata <code class="bg-white px-1.5 py-0.5 rounded text-red-700 font-bold">samping</code> atau <code class="bg-white px-1.5 py-0.5 rounded text-red-700 font-bold">2.jpg</code></p>
        <p>• Foto Belakang: Beri nama mengandung kata <code class="bg-white px-1.5 py-0.5 rounded text-red-700 font-bold">belakang</code> atau <code class="bg-white px-1.5 py-0.5 rounded text-red-700 font-bold">3.jpg</code></p>
    </div>

    <form action="{{ route('cars.photos.zip') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-wider mb-2">Pilih File .ZIP Koleksi Foto</label>
            <input type="file" 
                   name="zip_file" 
                   accept=".zip" 
                   required 
                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-200 rounded-2xl p-2 bg-slate-50">
        </div>

        <button type="submit" 
                class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] shadow-xl shadow-slate-900/10 transition-all transform active:scale-95">
            Ekstrak & Sinkronkan Semua Foto
        </button>
    </form>

    {{-- List Nopol yang tidak cocok jika ada --}}
    @if (session('unmatchedNopol') && count(session('unmatchedNopol')) > 0)
        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900">
            <p class="font-bold mb-1">⚠️ Beberapa Folder Nopol tidak ditemukan di database:</p>
            <p class="text-[11px] font-mono">{{ implode(', ', session('unmatchedNopol')) }}</p>
        </div>
    @endif
</div>
    </div>
    
</div>

@endsection