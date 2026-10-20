@extends('layouts.app')

@section('title', 'Kelola Foto Unit')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 pb-28 pt-24 font-['Plus_Jakarta_Sans'] sm:px-6">
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('showrooms.dashboard') }}" class="inline-flex min-h-11 items-center gap-2 text-sm font-bold text-slate-600 transition hover:text-[#800000] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#800000]">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12" />
            </svg>
            Kembali ke dashboard
        </a>

        <header class="mt-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-[#800000]">Kelola foto kendaraan</p>
                    <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                        {{ trim(($car->nama_merk ?? '') . ' ' . ($car->tipe_kend ?? '')) ?: 'Unit kendaraan' }}
                    </h1>
                    <p class="mt-2 text-sm text-slate-600">
                        Nopol <span class="font-bold text-slate-800">{{ $car->no_polisi ?: 'Belum tersedia' }}</span>
                        <span class="mx-2 text-slate-300" aria-hidden="true">|</span>
                        Tahun <span class="font-bold text-slate-800">{{ $car->tahun_buat ?: '-' }}</span>
                    </p>
                </div>
                <div class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-3 py-2 text-xs font-bold text-amber-800 ring-1 ring-inset ring-amber-200">
                    <span class="h-2 w-2 rounded-full bg-amber-500" aria-hidden="true"></span>
                    Perubahan tersimpan setelah menekan tombol
                </div>
            </div>
        </header>

        @if(session('success'))
            <div role="status" class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="mt-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                <p class="font-bold">Ada foto/data yang belum bisa diproses.</p>
                <p class="mt-1">Periksa pesan pada bagian terkait. Gunakan format file dan nilai angka yang valid.</p>
            </div>
        @endif

        <div class="mt-6 rounded-2xl border border-[#ead6d6] bg-[#fffafa] p-4 sm:p-5">
            <div class="flex gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#800000] ring-1 ring-[#ead6d6]" aria-hidden="true">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.3 4.8 2.9 17.6A1.6 1.6 0 0 0 4.3 20h15.4a1.6 1.6 0 0 0 1.4-2.4L13.7 4.8a2 2 0 0 0-3.4 0Z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-extrabold text-slate-900">Sensor plat nomor manual</p>
                    <p class="mt-1 text-sm leading-6 text-slate-600">Tarik kotak (klik dan geser) pada area plat di pratinjau gambar untuk menyamarkan plat nomor kendaraan secara manual.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('showrooms.cars.foto.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- SECTION BARU: INPUT HARGA UNIT -->
            <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="flex flex-col gap-1">
                    <h2 class="font-extrabold text-slate-900">Harga Jual / Buka Harga Unit</h2>
                    <p class="text-xs text-slate-500">Atur nominal harga penawaran unit kendaraan ini untuk calon pembeli.</p>
                </div>

                <div class="mt-4 max-w-md">
                    <label for="harga" class="block text-xs font-bold text-slate-700">
                        Harga Jual (Rp) <span class="font-medium text-slate-400">(opsional)</span>
                    </label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-slate-400">
                            Rp
                        </span>
                        <input 
                            type="number" 
                            name="harga" 
                            id="harga" 
                            value="{{ old('harga', $car->harga) }}" 
                            placeholder="Contoh: 150000000" 
                            class="block min-h-12 w-full rounded-xl border border-slate-300 bg-white pl-11 pr-4 text-sm font-semibold text-slate-800 placeholder:font-normal placeholder:text-slate-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000]"
                        >
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Kosongkan jika harga belum pasti atau masih dalam negosiasi.</p>
                    @error('harga')
                        <p class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <div class="grid gap-4 md:grid-cols-2">
                @php
                    $photoFields = [
                        ['field' => 'foto_depan', 'title' => 'Tampak depan', 'hint' => 'Ambil foto dari arah depan kendaraan.', 'canvas' => 'canvas_depan', 'status' => 'status_depan'],
                        ['field' => 'foto_belakang', 'title' => 'Tampak belakang', 'hint' => 'Pastikan bagian belakang kendaraan terlihat jelas.', 'canvas' => 'canvas_belakang', 'status' => 'status_belakang'],
                        ['field' => 'foto_samping', 'title' => 'Tampak samping', 'hint' => 'Tampilkan sisi kendaraan secara utuh.', 'canvas' => 'canvas_samping', 'status' => 'status_samping'],
                    ];
                @endphp

                @foreach($photoFields as $photo)
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="font-extrabold text-slate-900">{{ $photo['title'] }}</h2>
                                <p class="mt-1 text-xs leading-5 text-slate-500">{{ $photo['hint'] }}</p>
                            </div>
                            @if($car->{$photo['field']})
                                <span class="shrink-0 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-bold text-green-700">Sudah ada</span>
                            @else
                                <span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-800">Belum ada</span>
                            @endif
                        </div>

                        @if($car->{$photo['field']})
                            <img src="{{ asset($car->{$photo['field']}) }}" alt="Foto {{ strtolower($photo['title']) }} saat ini" class="mt-4 max-h-56 w-full rounded-xl border border-slate-200 bg-slate-50 object-contain">
                        @endif

                        <label for="{{ $photo['field'] }}" class="mt-4 block text-xs font-bold text-slate-700">Pilih foto baru <span class="font-medium text-slate-400">(opsional)</span></label>
                        <input type="file" name="{{ $photo['field'] }}" id="{{ $photo['field'] }}" accept="image/jpeg,image/png,image/jpg" class="mt-2 block min-h-12 w-full cursor-pointer rounded-xl border border-slate-300 bg-white text-sm text-slate-600 file:mr-3 file:min-h-12 file:border-0 file:bg-slate-100 file:px-4 file:font-bold file:text-slate-700 hover:file:bg-slate-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000]">
                        <p class="mt-2 text-xs text-slate-500">JPG atau PNG, maksimal 5 MB.</p>
                        @error($photo['field'])
                            <p class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
                        @enderror

                        <div class="mt-4 rounded-xl bg-slate-50 p-3">
                            <p class="text-xs font-bold text-slate-700">Pratinjau dan sensor manual</p>
                            <p class="mt-1 text-xs leading-5 text-slate-500">Pratinjau muncul setelah memilih foto.</p>
                            <p class="mt-3 text-xs text-slate-600">Status sensor: <span id="{{ $photo['status'] }}" class="status-indicator font-bold text-slate-500">Menunggu foto...</span></p>
                            <canvas id="{{ $photo['canvas'] }}" class="mt-2 hidden w-full cursor-crosshair rounded-lg border border-slate-200 bg-white" style="touch-action: none;" aria-label="Pratinjau foto {{ strtolower($photo['title']) }}; tarik pada area untuk sensor manual"></canvas>
                        </div>
                    </section>
                @endforeach

                <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="font-extrabold text-slate-900">Odometer / dashboard</h2>
                            <p class="mt-1 text-xs leading-5 text-slate-500">Pastikan angka kilometer terlihat dan terbaca.</p>
                        </div>
                        @if($car->foto_odometer)
                            <span class="shrink-0 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-bold text-green-700">Sudah ada</span>
                        @else
                            <span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-800">Belum ada</span>
                        @endif
                    </div>
                    @if($car->foto_odometer)
                        <img src="{{ asset($car->foto_odometer) }}" alt="Foto odometer saat ini" class="mt-4 max-h-56 w-full rounded-xl border border-slate-200 bg-slate-50 object-contain">
                    @endif
                    <label for="foto_odometer" class="mt-4 block text-xs font-bold text-slate-700">Pilih foto baru <span class="font-medium text-slate-400">(opsional)</span></label>
                    <input type="file" name="foto_odometer" id="foto_odometer" accept="image/jpeg,image/png,image/jpg" class="mt-2 block min-h-12 w-full cursor-pointer rounded-xl border border-slate-300 bg-white text-sm text-slate-600 file:mr-3 file:min-h-12 file:border-0 file:bg-slate-100 file:px-4 file:font-bold file:text-slate-700 hover:file:bg-slate-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000]">
                    <p class="mt-2 text-xs text-slate-500">JPG atau PNG, maksimal 5 MB.</p>
                    @error('foto_odometer')
                        <p class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
                    @enderror
                    <img id="preview_odometer" src="{{ $car->foto_odometer ? asset($car->foto_odometer) : '#' }}" alt="Pratinjau foto odometer" class="{{ $car->foto_odometer ? 'mt-4 block max-h-56 w-full rounded-xl border border-slate-200 object-contain' : 'mt-4 hidden max-h-56 w-full rounded-xl border border-slate-200 object-contain' }}" />
                </section>
            </div>

            <div class="fixed inset-x-0 bottom-0 z-20 border-t border-slate-200 bg-white/95 p-3 shadow-[0_-8px_24px_rgba(15,23,42,0.08)] backdrop-blur sm:static sm:mt-6 sm:flex sm:justify-end sm:gap-3 sm:border-0 sm:bg-transparent sm:p-0 sm:shadow-none sm:backdrop-blur-none">
                <div class="mx-auto flex max-w-5xl gap-3 sm:mx-0">
                    <a href="{{ route('showrooms.dashboard') }}" class="inline-flex min-h-12 flex-1 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000] sm:flex-none">Batal</a>
                    <button type="submit" class="inline-flex min-h-12 flex-1 items-center justify-center gap-2 rounded-xl bg-[#800000] px-5 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#650000] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000] sm:flex-none">
                        Simpan perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // --- FUNGSI UTAMA SENSOR MANUAL ---
    function setupManualBlur(inputId, canvasId, statusId) {
        const inputEl = document.getElementById(inputId);
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        const statusEl = document.getElementById(statusId);

        let originalImg = null;
        let drawnBoxes = []; // Menyimpan semua area yang disensor
        let isDrawing = false;
        let startX = 0, startY = 0;
        let tempBox = null;

        // Fungsi menggambar ulang canvas
        function redrawCanvas() {
            if (!originalImg) return;
            
            // 1. Bersihkan seluruh kanvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // 2. Gambar foto asli (tajam) sebagai dasar/background
            ctx.save();
            ctx.filter = 'none';
            ctx.drawImage(originalImg, 0, 0);
            ctx.restore();
            
            // 3. Terapkan efek BLUR murni HANYA pada kotak sensor
            if (drawnBoxes.length > 0) {
                ctx.save();
                
                // Mulai membuat jalur (path) area mana saja yang akan di-blur
                ctx.beginPath();
                drawnBoxes.forEach(box => {
                    ctx.rect(box.x, box.y, box.w, box.h);
                });
                
                // KUNCI area tersebut!
                ctx.clip();
                
                // Beri efek blur tebal
                ctx.filter = 'blur(30px)';
                
                // Gambar ulang SELURUH foto, tapi karena sudah di-clip, blurnya HANYA tembus di area ditarik
                ctx.drawImage(originalImg, 0, 0);
                
                ctx.restore();
            }

            // 4. Gambar kotak transparan saat user menarik kursor manual
            if (tempBox) {
                ctx.save();
                ctx.fillStyle = 'rgba(255, 255, 255, 0.4)';
                ctx.fillRect(tempBox.x, tempBox.y, tempBox.w, tempBox.h);
                ctx.strokeStyle = '#3b82f6'; 
                ctx.lineWidth = 2;
                ctx.strokeRect(tempBox.x, tempBox.y, tempBox.w, tempBox.h);
                ctx.restore();
            }
        }

        // Fungsi mengupdate file input sebelum form disubmit
        function updateFileInput() {
            canvas.toBlob(function(blob) {
                const blurredFile = new File([blob], inputEl.files[0].name, { type: 'image/jpeg' });
                const dt = new DataTransfer();
                dt.items.add(blurredFile);
                inputEl.files = dt.files;
            }, 'image/jpeg', 0.9);
        }

        // Mendapatkan koordinat mouse/sentuhan yang akurat dari canvas
        function getMousePos(evt) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            const clientX = evt.clientX || (evt.touches && evt.touches[0].clientX);
            const clientY = evt.clientY || (evt.touches && evt.touches[0].clientY);
            
            return {
                x: (clientX - rect.left) * scaleX,
                y: (clientY - rect.top) * scaleY
            };
        }

        // --- Event Listener Canvas (Drag & Draw) ---
        const startDrawing = (e) => {
            if(!originalImg) return;
            e.preventDefault();
            isDrawing = true;
            const pos = getMousePos(e);
            startX = pos.x; startY = pos.y;
        };

        const draw = (e) => {
            if (!isDrawing) return;
            e.preventDefault();
            const pos = getMousePos(e);
            
            // Kalkulasi agar bisa ditarik ke berbagai arah
            tempBox = {
                x: Math.min(startX, pos.x),
                y: Math.min(startY, pos.y),
                w: Math.abs(pos.x - startX),
                h: Math.abs(pos.y - startY)
            };
            redrawCanvas();
        };

        const stopDrawing = (e) => {
            if (!isDrawing) return;
            e.preventDefault();
            isDrawing = false;
            
            if (tempBox && tempBox.w > 10 && tempBox.h > 10) {
                drawnBoxes.push(tempBox); 
                statusEl.innerText = "Sensor ditambahkan! Tarik lagi untuk menambah area.";
            }
            
            tempBox = null;    // 1. Hapus efek kotak transparan
            redrawCanvas();    // 2. Gambar ulang kanvas dengan kotak solid pekat
            updateFileInput(); // 3. BARU SIMPAN gambar ke form input setelah warnanya pekat
        };

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);
        
        // Support touch event untuk HP
        canvas.addEventListener('touchstart', startDrawing, {passive: false});
        canvas.addEventListener('touchmove', draw, {passive: false});
        canvas.addEventListener('touchend', stopDrawing);

        // --- Event Listener Upload Foto ---
        inputEl.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            drawnBoxes = []; // Reset box tiap foto baru
            canvas.style.display = 'block';
            statusEl.innerText = "Silakan tarik kotak (klik & drag) pada area yang ingin disensor.";
            statusEl.className = "status-indicator font-semibold text-blue-600";

            const reader = new FileReader();
            reader.onload = function(event) {
                originalImg = new Image();
                originalImg.src = event.target.result;
                originalImg.onload = function() {
                    canvas.width = originalImg.width; 
                    canvas.height = originalImg.height;
                    
                    redrawCanvas();
                    updateFileInput();
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // --- TERAPKAN KE MASING-MASING INPUT ---
    setupManualBlur('foto_depan', 'canvas_depan', 'status_depan');
    setupManualBlur('foto_belakang', 'canvas_belakang', 'status_belakang');
    setupManualBlur('foto_samping', 'canvas_samping', 'status_samping');

    // Khusus Odometer (Preview saja, tidak butuh Canvas/Blur)
    document.getElementById('foto_odometer').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewImg = document.getElementById('preview_odometer');
                previewImg.src = event.target.result;
                previewImg.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection