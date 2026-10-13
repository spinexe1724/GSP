@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Kelola Foto 4 Sisi Kendaraan</h2>
        <p class="text-sm text-gray-600 mb-6">
            Unit: <strong>{{ $car->name ?? 'HONDA BRIO SATYA E 1.2 CVT' }}</strong> (Nopol: {{ $car->license_plate ?? 'D 1123 AGB' }})
        </p>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4">
            <p class="text-sm text-blue-700 font-semibold">💡 Info Sensor Plat Nomor:</p>
            <p class="text-xs text-blue-600 mt-1">AI akan mencoba mensensor plat secara otomatis. Jika AI meleset, <strong>klik dan seret (drag)</strong> langsung pada gambar di bawah ini untuk membuat kotak sensor manual.</p>
        </div>

        {{-- Form Update Foto --}}
<form action="{{ route('showrooms.cars.foto.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
            @method('PUT')

            {{-- 1. Foto Tampak Depan --}}
            <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <label class="block font-semibold text-gray-700 mb-2">1. Foto Tampak Depan Kendaraan</label>
                <input type="file" name="foto_depan" id="foto_depan" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                
                <div class="mt-3 relative">
                    <p class="text-xs text-gray-600 mb-1">Status AI: <span id="status_depan" class="ai-status font-semibold text-blue-600">Menyiapkan...</span></p>
                    <div class="mt-2 text-center">
                        <!-- Menggunakan Canvas agar bisa digambar manual -->
                        <canvas id="canvas_depan" class="cursor-crosshair w-full max-w-full rounded-md border border-gray-300 shadow-sm" style="display: none; touch-action: none;"></canvas>
                    </div>
                </div>
            </div>

            {{-- 2. Foto Tampak Belakang --}}
            <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <label class="block font-semibold text-gray-700 mb-2">2. Foto Tampak Belakang</label>
                <input type="file" name="foto_belakang" id="foto_belakang" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                
                <div class="mt-3 relative">
                    <p class="text-xs text-gray-600 mb-1">Status AI: <span id="status_belakang" class="ai-status font-semibold text-blue-600">Menyiapkan...</span></p>
                    <div class="mt-2 text-center">
                        <canvas id="canvas_belakang" class="cursor-crosshair w-full max-w-full rounded-md border border-gray-300 shadow-sm" style="display: none; touch-action: none;"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. Foto Tampak Samping --}}
            <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <label class="block font-semibold text-gray-700 mb-2">3. Foto Tampak Samping</label>
                <input type="file" name="foto_samping" id="foto_samping" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                
                <div class="mt-3 relative">
                    <p class="text-xs text-gray-600 mb-1">Status AI: <span id="status_samping" class="ai-status font-semibold text-blue-600">Menyiapkan...</span></p>
                    <div class="mt-2 text-center">
                        <canvas id="canvas_samping" class="cursor-crosshair w-full max-w-full rounded-md border border-gray-300 shadow-sm" style="display: none; touch-action: none;"></canvas>
                    </div>
                </div>
            </div>

            {{-- 4. Foto Odometer (Tanpa AI) --}}
            <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <label class="block font-semibold text-gray-700 mb-2">4. Foto Odometer / Dashboard</label>
                <input type="file" name="foto_odometer" id="foto_odometer" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                <div class="mt-3">
                    <img id="preview_odometer" src="#" alt="Preview Odometer" style="max-width: 100%; max-height: 300px; display: none; border-radius: 6px; border: 1px solid #cbd5e1;" />
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm font-medium">Kembali</a>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Library ONNX Runtime Web -->
<script src="https://cdn.jsdelivr.net/npm/onnxruntime-web/dist/ort.min.js"></script>
<script>
    // --- 1. INISIALISASI MODEL AI ---
    let session = null;
    async function initAI() {
        try {
            const modelUrl = "https://huggingface.co/spaces/GratamaFerdi/yolo-plate-blur/resolve/main/model.onnx";
            session = await ort.InferenceSession.create(modelUrl, { executionProviders: ['wasm'] });
            document.querySelectorAll('.ai-status').forEach(el => {
                el.innerText = "AI Siap!"; el.className = "ai-status font-semibold text-green-600";
            });
        } catch (e) {
            console.error("Gagal memuat AI:", e);
            document.querySelectorAll('.ai-status').forEach(el => {
                el.innerText = "AI Gagal. Gunakan sensor manual (klik & drag pada foto).";
                el.className = "ai-status font-semibold text-red-600";
            });
        }
    }
    initAI();

    // --- 2. FUNGSI PREPROCESSING & PARSING AI ---
    function preprocessToYolo(img) {
        const c = document.createElement('canvas');
        c.width = 640; c.height = 640;
        const cx = c.getContext('2d');
        cx.drawImage(img, 0, 0, 640, 640);
        const imgData = cx.getImageData(0, 0, 640, 640).data;
        const red = new Float32Array(640 * 640); const green = new Float32Array(640 * 640); const blue = new Float32Array(640 * 640);
        for (let i = 0, p = 0; i < imgData.length; i += 4, p++) {
            red[p] = imgData[i] / 255.0; green[p] = imgData[i + 1] / 255.0; blue[p] = imgData[i + 2] / 255.0;
        }
        const input = new Float32Array(3 * 640 * 640);
        input.set(red, 0); input.set(green, 640 * 640); input.set(blue, 2 * 640 * 640);
        return new ort.Tensor('float32', input, [1, 3, 640, 640]);
    }

    function parseYoloOutput(output, origW, origH) {
        const numCols = 8400; let bestBox = null; let maxConf = 0;
        for (let i = 0; i < numCols; i++) {
            const conf = output[4 * numCols + i];
            if (conf > maxConf && conf > 0.4) {
                maxConf = conf;
                const w = output[2 * numCols + i]; const h = output[3 * numCols + i];
                bestBox = {
                    x: (output[0 * numCols + i] - w / 2) * (origW / 640),
                    y: (output[1 * numCols + i] - h / 2) * (origH / 640),
                    w: w * (origW / 640), h: h * (origH / 640)
                };
            }
        }
        return bestBox;
    }

    // --- 3. FUNGSI UTAMA AI + GAMBAR MANUAL ---
    function setupAIFilter(inputId, canvasId, statusId) {
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
                
                // KUNCI area tersebut! (Semua gambar setelah ini hanya akan muncul di dalam kotak)
                ctx.clip();
                
                // Beri efek blur tebal (misal 30px)
                ctx.filter = 'blur(30px)';
                
                // Gambar ulang SELURUH foto, tapi karena sudah di-clip, blurnya HANYA tembus di area plat!
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
            // Skala antara ukuran tampil di layar vs resolusi piksel aslinya
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
                statusEl.innerText = "Sensor manual ditambahkan!";
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
        inputEl.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            drawnBoxes = []; // Reset box tiap foto baru
            canvas.style.display = 'block';
            statusEl.innerText = "Menganalisa gambar...";

            const reader = new FileReader();
            reader.onload = async function(event) {
                originalImg = new Image();
                originalImg.src = event.target.result;
                originalImg.onload = async function() {
                    canvas.width = originalImg.width; 
                    canvas.height = originalImg.height;
                    
                    if (session) {
                        // Proses deteksi AI
                        const inputTensor = preprocessToYolo(originalImg);
                        const results = await session.run({ images: inputTensor });
                        const aiBox = parseYoloOutput(results[Object.keys(results)[0]].data, originalImg.width, originalImg.height);
                        
                        if (aiBox) {
                            drawnBoxes.push(aiBox); // Masukkan hasil AI ke array box
                            statusEl.innerText = "Plat tersensor otomatis! (Bisa tambah manual jika ada plat lain)";
                        } else {
                            statusEl.innerText = "AI tidak menemukan plat. Silakan klik & drag (tarik kotak) pada foto untuk sensor manual.";
                        }
                    }
                    
                    redrawCanvas();
                    updateFileInput();
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // --- 4. TERAPKAN KE MASING-MASING INPUT ---
    setupAIFilter('foto_depan', 'canvas_depan', 'status_depan');
    setupAIFilter('foto_belakang', 'canvas_belakang', 'status_belakang');
    setupAIFilter('foto_samping', 'canvas_samping', 'status_samping');

    // Khusus Odometer (Preview saja, tidak butuh Canvas/AI)
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