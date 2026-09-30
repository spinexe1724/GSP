@extends('layouts.admin')

@section('title', 'Admin Dashboard - Kelola Data')

@section('content')
<div class="py-4 min-h-[calc(100vh-120px)] flex flex-col">
    <div class="max-w-7xl mx-auto w-full sm:px-6 lg:px-8 space-y-6 flex-1 flex flex-col">


    {{-- Cek isi semua session yang masuk --}}
@if(session()->has('success'))
    <div style="background: green; color: white; padding: 15px; font-weight: bold; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div style="background: red; color: white; padding: 15px; font-weight: bold; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif

        {{-- GRID CARDS (3 KOLOM SEJAJAR, MEMANJANG & KONTEN DI TENGAH) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1 items-stretch">
            
            {{-- LANGKAH 1: Import Showroom --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between h-full">
                <!-- Header Kartu -->
                <div class="space-y-2">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 1</span>
                    <h3 class="font-black text-lg text-slate-900">1. Import Showroom</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Upload file Excel master showroom (kolom CNO, nama dealer, alamat, kota, dan KTP).
                    </p>
                </div>

                <!-- Konten Tengah (Form File Input) -->
                <form action="{{ route('showrooms.import') }}" method="POST" enctype="multipart/form-data" class="my-auto py-6 flex flex-col items-center justify-center w-full space-y-4">
                    @csrf
                    <div class="w-full border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-slate-400 transition bg-slate-50 flex flex-col items-center justify-center min-h-[160px]">
                        <svg class="w-10 h-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required 
                               class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 border border-slate-200 rounded-xl p-1 bg-white"/>
                    </div>
                    
                    <button type="submit" class="w-full bg-[#800000] hover:bg-black text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-wider transition-all shadow-md">
                        UPLOAD EXCEL SHOWROOM
                    </button>
                </form>
            </div>

            {{-- LANGKAH 2: Import Unit Mobil --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between h-full">
                <!-- Header Kartu -->
                <div class="space-y-2">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 2</span>
                    <h3 class="font-black text-lg text-slate-900">2. Import Unit Mobil</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Upload data mobil harian. Sistem mencocokkan kolom <b class="text-slate-800">no_cif</b> ke CNO showroom.
                    </p>
                </div>

                <!-- Konten Tengah (Form File Input) -->
                <form action="{{ route('cars.import') }}" method="POST" enctype="multipart/form-data" class="my-auto py-6 flex flex-col items-center justify-center w-full space-y-4">
                    @csrf
                    <div class="w-full border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-red-300 transition bg-slate-50 flex flex-col items-center justify-center min-h-[160px]">
                        <svg class="w-10 h-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                               class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 border border-slate-200 rounded-xl p-1 bg-white">
                    </div>

                    <button type="submit" class="w-full bg-[#800000] hover:bg-red-900 text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-wider transition-all shadow-md">
                        UPLOAD EXCEL MOBIL
                    </button>
                </form>
            </div>

            {{-- LANGKAH 3: Import Foto Massal (Chunk Upload Resumable.js) --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between h-full">
                <!-- Header Kartu -->
                <div class="space-y-2">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 3</span>
                    <h3 class="font-black text-lg text-slate-900">3. Import Foto Massal</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Upload file <b class="text-slate-800">.ZIP</b> berisi seluruh struktur folder foto kendaraan.
                    </p>
                </div>
                
                <!-- Konten Tengah (Area Status Upload & Tombol) -->
                <div class="my-auto py-6 flex flex-col items-center justify-center w-full space-y-4">
                    <div class="w-full border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-red-300 transition bg-slate-50 flex flex-col items-center justify-center min-h-[160px]">
                        <svg class="w-10 h-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <div class="text-xs font-semibold text-slate-500 text-center min-h-[20px]" id="upload-status">
                            Belum ada file dipilih
                        </div>
                    </div>

                    <!-- Progress Bar (Otomatis muncul saat upload) -->
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden hidden border border-slate-200" id="progress-container">
                        <div id="progress-bar" class="bg-[#800000] h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>

                    <button id="upload-btn" type="button" class="w-full bg-[#800000] hover:bg-red-900 text-white font-black py-3.5 px-4 rounded-xl transition-all text-xs uppercase tracking-wider text-center shadow-md">
                        UPLOAD ZIP FOTO
                    </button>
                </div>
            </div>
{{-- CARD UPLOAD PELUNASAN --}}
<div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between h-full">
    <div class="space-y-2">
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Langkah 4</span>
        <h3 class="font-black text-lg text-slate-900">Import Pelunasan Unit</h3>
        <p class="text-xs text-slate-500 leading-relaxed">
            Upload Excel pelunasan (kolom <b class="text-slate-800">no_polisi</b>). Unit & foto terkait akan otomatis dihapus dari database.
        </p>
    </div>

    <form id="form-pelunasan" action="{{ route('pelunasan.import') }}" method="POST" enctype="multipart/form-data" class="my-auto py-6 flex flex-col items-center justify-center w-full space-y-4">
        @csrf
        <div class="w-full border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-red-300 transition bg-slate-50 flex flex-col items-center justify-center min-h-[160px]">
            <svg class="w-10 h-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 border border-slate-200 rounded-xl p-1 bg-white">
        </div>

        <button id="btn-pelunasan" type="submit" class="w-full bg-[#800000] hover:bg-red-800 text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-wider transition-all shadow-md">
            PROSES PELUNASAN UNIT
        </button>
    </form>
</div>
        </div>
    </div>
</div>

{{-- Pustaka Resumable.js CDN & Skrip Eksekusi --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            document.getElementById('progress-bar').classList.remove('bg-[#800000]');
            document.getElementById('progress-bar').classList.add('bg-green-600');
            
            setTimeout(() => {
                location.reload(); // Refresh otomatis setelah sukses tergabung & masuk antrean
            }, 2000);
        });

        r.on('fileError', function (file, message) {
            document.getElementById('upload-status').innerText = 'Gagal mengunggah file. Periksa koneksi Anda.';
            alert('Terjadi kesalahan saat mengirim bagian file.');
        });
    });

   document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const importedStatus = urlParams.get('imported');
        
        // 1. Notifikasi Import Showroom Berhasil
        if (importedStatus === 'showroom_success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Semua data showroom berhasil di-upload secara utuh! Data dengan CNO kosong tetap masuk.',
                confirmButtonColor: '#0a1128',
                timer: 4000
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        } 
        
        // 2. Notifikasi Import Unit Mobil Berhasil (SAMA DENGAN SHOWROOM)
        else if (importedStatus === 'cars_success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data unit mobil harian berhasil di-upload dan dicocokkan dengan CNO showroom!',
                confirmButtonColor: '#800000',
                timer: 4000
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        } 
        
        // 3. Notifikasi Jika Terjadi Error
        else if (importedStatus === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Upload!',
                text: urlParams.get('msg') || 'Terjadi kesalahan saat mengunggah data.',
                confirmButtonColor: '#800000'
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        // Handling Loading State pada Form Pelunasan
        const formPelunasan = document.getElementById('form-pelunasan');
        const btnPelunasan = document.getElementById('btn-pelunasan');
        if (formPelunasan) {
            formPelunasan.addEventListener('submit', function () {
                btnPelunasan.disabled = true;
                btnPelunasan.innerText = 'MEMPROSES HAPUS DATA...';
                btnPelunasan.classList.add('opacity-75');
            });
        }

        // Reading URL Parameters for SweetAlert Notifications
        const urlParams = new URLSearchParams(window.location.search);
        const importedStatus = urlParams.get('imported');

        if (importedStatus === 'pelunasan_success') {
            const count = urlParams.get('count') || 0;
            Swal.fire({
                icon: 'success',
                title: 'Pelunasan Berhasil!',
                text: `Sebanyak ${count} unit mobil beserta berkas fotonya berhasil dihapus dari sistem.`,
                confirmButtonColor: '#800000',
                timer: 4000
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        } else if (importedStatus === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memproses!',
                text: urlParams.get('msg') || 'Terjadi kesalahan saat mengunggah data pelunasan.',
                confirmButtonColor: '#800000'
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
@endsection