@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Sedikit penyesuaian agar tampilan Select2 cocok dengan Tailwind CSS */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-color: #d1d5db !important; 
        border-radius: 0.375rem !important; 
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }
</style>
@section('title', 'Review Foto Unit Pending')

@section('content')
<div class="container mx-auto p-4">
    
    {{-- Header & Tombol Bersihkan --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Review Foto Unit (Belum Terpetakan)</h2>
        
        {{-- TOMBOL BERSIHKAN SEMUA FOTO REVIEW --}}
        <form action="{{ route('admin.cars.photo_review.clear') }}" method="POST" class="inline-block w-full md:w-auto" onsubmit="return confirm('Peringatan: Apakah Anda yakin ingin menghapus SEMUA data foto review ini beserta file aslinya dari server? Tindakan ini tidak dapat dibatalkan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                Bersihkan Semua Foto Review
            </button>
        </form>
    </div>

    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Daftar Accordion --}}
    <div class="w-full">
        @forelse($groupedPhotos as $nopol => $photos)
            <details class="group bg-white border border-gray-300 rounded-lg mb-3 shadow-sm overflow-hidden">
                
                {{-- SUMMARY: Bagian Header List yang selalu tampil --}}
                <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 uppercase">Folder Nopol: <span class="text-blue-700">{{ $nopol }}</span></h3>
                            <p class="text-xs text-gray-500 font-normal mt-0.5">Terdapat {{ $photos->count() }} foto / file yang perlu ditinjau</p>
                        </div>
                    </div>
                    
                    <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                        Butuh Review
                    </span>
                </summary>

                {{-- CONTENT: Bagian isi form yang tampil saat list dibuka --}}
                <div class="p-5 border-t border-gray-200 bg-white">
                    <form action="{{ route('admin.cars.photo_review.assign', ['id' => $nopol]) }}" method="POST" class="w-full">                        
                        @csrf
                        
                        {{-- Pilih Unit Mobil Tujuan --}}
                        <div class="mb-5 bg-blue-50 p-4 rounded-md border border-blue-200 flex flex-col md:flex-row items-start md:items-center gap-4">
                            <div class="w-full">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Unit Mobil untuk Foto Ini:</label>
                                <select name="car_id" class="select2-car w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3" required>                                    
                                    <option value="">-- Cari dan Pilih Nopol Mobil di Database --</option>
                                    
                                    {{-- Dropdown hanya menampilkan mobil yang kurang foto --}}
                                    @foreach($carsNeedingPhotos as $car)
                                        <option value="{{ $car->id }}">
                                            {{ $car->no_polisi }} - {{ $car->nama_merk }} {{ $car->tipe_kend }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="mt-2 md:mt-5 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-6 rounded-md shadow whitespace-nowrap transition">
                                Simpan Pilihan
                            </button>
                        </div>

                        {{-- Daftar Foto dalam Folder --}}
                        <h4 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">Pilih Slot untuk Masing-masing Foto:</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($photos as $photo)
                              <div class="border border-gray-200 rounded-md p-2 flex flex-col bg-gray-50 hover:shadow-sm transition">
        
                                {{-- PASTIKAN NAME INI ADA DAN SESUAI --}}
                                <input type="hidden" name="photos[{{ $photo->id }}][id]" value="{{ $photo->id }}">

                                <a href="{{ asset($photo->file_path) }}" target="_blank" class="w-full group/img relative mb-2">
                                    <img src="{{ asset($photo->file_path) }}" alt="{{ $photo->file_name }}" class="w-full h-32 object-cover rounded border border-gray-300">
                                </a>
                                
                                <span class="text-[10px] font-mono bg-white border border-gray-200 px-1 py-1 w-full text-center truncate rounded mb-2 text-gray-600">
                                    {{ $photo->file_name }}
                                </span>

                                {{-- PASTIKAN NAME INI MENGGUNAKAN [slot] --}}
                                <select name="photos[{{ $photo->id }}][slot]" class="w-full text-xs border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500 py-1 bg-white cursor-pointer">
                                    <option value="ignore">Abaikan File Ini</option>
                                    <option value="foto_depan">Jadikan Foto Depan</option>
                                    <option value="foto_belakang">Jadikan Foto Belakang</option>
                                    <option value="foto_samping">Jadikan Foto Samping</option>
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </details>
        @empty
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium">Semua foto unit sudah terpetakan dengan baik! Tidak ada file yang perlu direview.</span>
            </div>
        @endforelse
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Load JS Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Mengaktifkan fitur Select2 pada dropdown kita
        $('.select2-car').select2({
            width: '100%', // Wajib 100% agar tidak error saat berada di dalam Accordion
            placeholder: "-- Ketik Nopol atau Merk Mobil di sini --",
            allowClear: true
        });
    });
</script>
@endsection