@extends('layouts.admin')

@section('title', 'Admin Dashboard - Kelola Data')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        {{-- Notifikasi Flash Message -->>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

   {{-- Statistik Ringkasan yang Disamakan --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-gray-500 text-sm">TOTAL SHOWROOM</div>
        <div class="text-3xl font-bold mt-1 text-gray-800">{{ number_format($totalShowrooms ?? 0) }}</div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-gray-500 text-sm">TOTAL UNIT MOBIL</div>
        <div class="text-3xl font-bold mt-1 text-gray-800">{{ number_format($totalCars ?? 0) }}</div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-gray-500 text-sm">UNIT MEMILIKI FOTO</div>
        <div class="text-3xl font-bold mt-1 text-green-700">{{ number_format($carsWithPhotos ?? 0) }}</div>
    </div>
</div>

        {{-- Bagian Form Import & Upload --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- LANGKAH 1: Import Showroom --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Langkah 1</div>
                <h3 class="font-bold text-lg text-gray-800">1. Import Showroom</h3>
                <p class="text-sm text-gray-600">Upload file Excel master showroom (kolom CNO, nama dealer, alamat, kota, dan KTP).</p>
                
                <form action="{{ route('showrooms.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="file" name="file_excel" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"/>
                    <button type="submit" class="w-full bg-[#0a1128] hover:bg-black text-white font-medium py-2 px-4 rounded transition text-sm">
                        UPLOAD EXCEL SHOWROOM
                    </button>
                </form>
            </div>

            {{-- LANGKAH 2: Import Unit Mobil --}}
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


            {{-- LANGKAH 3: Import Foto Massal (Chunk Upload Resumable.js) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Langkah 3</div>
                <h3 class="font-bold text-lg text-gray-800">3. Import Foto Massal</h3>
                <p class="text-sm text-gray-600">Upload file <b>.ZIP</b></p>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <button id="upload-btn" type="button" class="w-full bg-[#800000] hover:bg-red-900 text-white font-medium py-2 px-4 rounded transition text-sm text-center shadow">
                            UPLOAD
                        </button>
                    </div>

                    <div class="text-xs font-semibold text-gray-500 text-center" id="upload-status">
                        Belum ada file dipilih
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden hidden" id="progress-container">
                        <div id="progress-bar" class="bg-[#800000] h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Pustaka Resumable.js CDN & Skrip Eksekusi --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let r = new Resumable({
            target: '{{ route("admin.cars.chunk.upload") }}',
            query: { _token: '{{ csrf_token() }}' },
            chunkSize: 2 * 1024 * 1024, // Pecah file per 2 MB per bagian
            simultaneousUploads: 3,     // Mengirim 3 chunk secara paralel
            testChunks: false,
            throttleProgressCallbacks: 1
        });

        // Menghubungkan tombol pilihan file dengan Resumable
        r.assignBrowse(document.getElementById('upload-btn'));

        r.on('fileAdded', function (file) {
            document.getElementById('progress-container').classList.remove('hidden');
            document.getElementById('upload-status').innerText = 'Memulai pengunggahan ' + file.fileName + '...';
            r.upload();
        });

        r.on('fileProgress', function (file) {
            let progress = Math.floor(file.progress() * 100);
            document.getElementById('progress-bar').style.width = progress + '%';
            document.getElementById('upload-status').innerText = 'Mengunggah: ' + progress + '% (Stabil & Anti-Timeout)';
        });

        r.on('fileSuccess', function (file, response) {
            let res = JSON.parse(response);
            document.getElementById('upload-status').innerText = 'Selesai! ' + res.message;
            document.getElementById('progress-bar').classList.add('bg-green-600');
            setTimeout(() => {
                location.reload(); // Refresh otomatis setelah sukses tergabung & masuk antrean
            }, 2500);
        });

        r.on('fileError', function (file, message) {
            document.getElementById('upload-status').innerText = 'Gagal mengunggah file. Periksa koneksi Anda.';
            alert('Terjadi kesalahan saat mengirim bagian file.');
        });
    });
</script>
@endsection