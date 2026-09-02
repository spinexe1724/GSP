@extends('layouts.app')

@section('content')
<div class="pt-32 pb-20 bg-slate-50 min-h-screen font-['Plus_Jakarta_Sans']">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-10">
                <h1 class="text-3xl font-black text-slate-900">Pasang Iklan Mobil.</h1>
                <p class="text-slate-500 mt-2">Lengkapi detail unit untuk dipublikasikan ke marketplace.</p>
            </div>

            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                {{-- SECTION 1: Informasi Dasar --}}
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                        <span class="w-2 h-6 bg-red-700 rounded-full mr-3"></span>
                        Informasi Kendaraan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase ml-2">Nomor VIN</label>
                            <input type="text" name="vin" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold focus:ring-2 focus:ring-red-700 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase ml-2">Harga (Rp)</label>
                            <input type="number" name="price" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold focus:ring-2 focus:ring-red-700 outline-none transition-all" placeholder="Contoh: 250000000">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase ml-2">Merk / Brand</label>
                            <select name="brand" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold focus:ring-2 focus:ring-red-700 outline-none">
                                <option value="Toyota">Toyota</option>
                                <option value="Honda">Honda</option>
                                <option value="Mitsubishi">Mitsubishi</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase ml-2">Model</label>
                            <input type="text" name="model" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold focus:ring-2 focus:ring-red-700 outline-none">
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Spesifikasi & Foto --}}
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                        <span class="w-2 h-6 bg-slate-300 rounded-full mr-3"></span>
                        Spesifikasi & Foto
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase ml-2">Tahun</label>
                                <input type="number" name="year" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase ml-2">Transmisi</label>
                                <select name="transmission" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold">
                                    <option>Manual</option>
                                    <option>Automatic</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase ml-2">Bahan Bakar</label>
                                <select name="fuel_type" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold">
                                    <option>Bensin</option>
                                    <option>Diesel</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase ml-2">Foto Unit</label>
                            <div class="relative w-full h-40 border-2 border-dashed border-slate-200 rounded-[32px] flex flex-col items-center justify-center bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer">
                                <p class="text-slate-400 font-bold text-sm">Klik atau seret foto ke sini</p>
                                <p class="text-slate-300 text-[10px] uppercase mt-1">Max 2MB (JPG, PNG)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#800000] hover:bg-red-900 text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-red-900/20 transition-all transform active:scale-95">
                        Tayangkan Iklan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection