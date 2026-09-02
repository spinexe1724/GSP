<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CarController extends Controller
{
    /**
     * Menampilkan katalog/daftar unit mobil (dengan relasi showroom).
     */
    public function index(Request $request)
    {
        $query = Car::with('showroom');

        // Pencarian berdasarkan merk, tipe, nopol, atau nama showroom
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('nopol', 'like', "%{$search}%")
                  ->orWhere('no_cif', 'like', "%{$search}%")
                  ->orWhereHas('showroom', function ($showroomQuery) use ($search) {
                      $showroomQuery->where('nmdealer', 'like', "%{$search}%")
                                    ->orWhere('kota', 'like', "%{$search}%");
                  });
            });
        }

        $cars = $query->latest()->paginate(15)->withQueryString();

        return view('cars.index', compact('cars'));
    }

    /**
     * Menampilkan form upload file Excel data mobil.
     */
    public function createUpload()
    {
        return view('cars.upload-cars');
    }

    /**
     * Memproses upload file Excel harian unit mobil.
     */
    public function upload(Request $request)
    {
        ini_set('max_execution_time', '600');
        ini_set('memory_limit', '512M');

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
        ], [
            'file.required' => 'Silakan pilih file Excel terlebih dahulu.',
            'file.mimes'    => 'Format file harus berupa .xlsx, .xls, atau .csv',
            'file.max'      => 'Ukuran file maksimal adalah 20MB.',
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file Excel: ' . $e->getMessage());
        }

        if (empty($rows)) {
            return redirect()->back()->with('error', 'File Excel kosong.');
        }

        // 1. Ambil baris pertama sebagai Header
        $rawHeader = array_shift($rows);
        $headerMap = [];

        foreach ($rawHeader as $colLetter => $colName) {
            $cleaned = strtolower(trim((string)$colName));
            if (!empty($cleaned)) {
                $headerMap[$cleaned] = $colLetter;
            }
        }

        // 2. Validasi kolom no_cif (beserta kemungkinan aliasnya)
        $cifKey = $headerMap['no_cif'] 
            ?? $headerMap['cifkonsumen'] 
            ?? $headerMap['cif_dealer'] 
            ?? $headerMap['cif'] 
            ?? null;

        if (!$cifKey) {
            $foundCols = implode(', ', array_slice(array_keys($headerMap), 0, 8));
            return redirect()->back()->with('error', "Kolom 'no_cif' tidak ditemukan di baris pertama Excel. Kolom terbaca: {$foundCols}...");
        }

        $importedCount = 0;
        $skippedCount = 0;

        // 3. Looping data setiap baris mobil
        foreach ($rows as $row) {
            // Cek jika seluruh baris kosong
            $allEmpty = true;
            foreach ($row as $val) {
                if (trim((string)$val) !== '') {
                    $allEmpty = false;
                    break;
                }
            }
            if ($allEmpty) {
                continue;
            }

            $cifKonsumen = isset($row[$cifKey]) ? trim((string)$row[$cifKey]) : null;
            $nopol       = isset($headerMap['nopol']) ? trim((string)($row[$headerMap['nopol']] ?? '')) : null;

            // Lewati jika CIF Konsumen kosong
            if (empty($cifKonsumen) || $cifKonsumen === '-' || $cifKonsumen === '0') {
                $skippedCount++;
                continue;
            }

            try {
                Car::updateOrCreate(
                    [
                        'no_cif' => $cifKonsumen,
                        'nopol'        => !empty($nopol) ? $nopol : '-',
                    ],
                    [
                        'merk'  => isset($headerMap['merk']) ? trim((string)($row[$headerMap['merk']] ?? '')) : null,
                        'type'  => isset($headerMap['type']) ? trim((string)($row[$headerMap['type']] ?? '')) : null,
                        'tahun' => isset($headerMap['tahun']) ? trim((string)($row[$headerMap['tahun']] ?? '')) : null,
                    ]
                );
                $importedCount++;
            } catch (\Exception $e) {
                Log::warning("Gagal simpan mobil CIF {$cifKonsumen} Nopol {$nopol}: " . $e->getMessage());
                $skippedCount++;
            }
        }

        return redirect()->back()->with('success', "Update data mobil selesai: {$importedCount} unit berhasil disimpan/diperbarui ({$skippedCount} baris dilewati).");
    }
   public function uploadZipPhotos(Request $request)
{
    // Naikkan batas waktu eksekusi & memori untuk menangani file ZIP besar
    ini_set('max_execution_time', '900');
    ini_set('memory_limit', '1024M');

    $request->validate([
        'zip_file' => 'required|file|mimes:zip|max:512000', // Maksimal 500MB
    ], [
        'zip_file.required' => 'Pilih file ZIP foto terlebih dahulu.',
        'zip_file.mimes'    => 'Format file harus berupa .zip',
        'zip_file.max'      => 'Ukuran file ZIP maksimal 500MB.',
    ]);

    $zipFile = $request->file('zip_file');
    $zip = new ZipArchive;

    if ($zip->open($zipFile->getRealPath()) !== true) {
        return redirect()->back()->with('error', 'Gagal membuka atau membaca isi file ZIP.');
    }

    $unmatchedNopol = [];
    $totalPhotosSaved = 0;

    // Loop semua entri file di dalam ZIP
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);

        // Abaikan folder kosong atau file sistem bawaan macOS / Windows
        if (
            str_ends_with($filename, '/') ||
            str_contains($filename, '__MACOSX') ||
            str_contains($filename, '.DS_Store') ||
            str_contains($filename, 'Thumbs.db')
        ) {
            continue;
        }

        // Dapatkan nama file dan nama folder di atasnya
        $pathParts  = explode('/', str_replace('\\', '/', $filename));
        $fileOnly   = end($pathParts);
        $folderName = prev($pathParts);

        if (!$folderName) {
            continue;
        }

        // ================= EKSTRAKSI NOPOL DARI NAMA FOLDER =================
        // Menangkap format plat nomor Indonesia (contoh: D 1799 YCE, BE 1187 AMY, BH 1473 YD)
        // meskipun di awal folder tertulis nama showroom seperti "BINTANG RAYA MOTOR D 1799 YCE"
        $detectedNopol = null;
        if (preg_match('/([A-Za-z]{1,2})\s*([0-9]{1,4})\s*([A-Za-z]{1,3})/', $folderName, $matches)) {
            // Gabungkan tanpa spasi: misal "D1799YCE"
            $detectedNopol = strtoupper($matches[1] . $matches[2] . $matches[3]);
        } else {
            // Fallback jika nama folder langsung berupa nomor plat polos tanpa spasi
            $detectedNopol = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($folderName));
        }

        // Cari mobil di database berdasarkan nopol (abaikan spasi dan tanda minus pada data DB)
        $car = Car::whereRaw("REPLACE(REPLACE(UPPER(nopol), ' ', ''), '-', '') = ?", [$detectedNopol])->first();

        if (!$car) {
            if (!in_array($folderName, $unmatchedNopol)) {
                $unmatchedNopol[] = $folderName;
            }
            continue;
        }

        // ================= VALIDASI EKSTENSI GAMBAR =================
        $extension     = strtolower(pathinfo($fileOnly, PATHINFO_EXTENSION));
        $lowerFileOnly = strtolower($fileOnly);

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            continue;
        }

        // ================= FILTER STRICT HANYA 3 SISI FOTO =================
        $targetField = null;

        if (str_contains($lowerFileOnly, 'depan') || str_contains($lowerFileOnly, 'front')) {
            $targetField = 'foto_depan';
        } elseif (str_contains($lowerFileOnly, 'samping') || str_contains($lowerFileOnly, 'side')) {
            $targetField = 'foto_samping';
        } elseif (str_contains($lowerFileOnly, 'belakang') || str_contains($lowerFileOnly, 'rear') || str_contains($lowerFileOnly, 'back')) {
            $targetField = 'foto_belakang';
        }

        // Lewati file gambar selain 3 sisi tersebut (seperti interior, mesin, bpkb, stnk, dll.)
        if (!$targetField) {
            continue;
        }

        // Hapus foto lama di storage jika sebelumnya sudah ada
        if (!empty($car->$targetField) && Storage::disk('public')->exists($car->$targetField)) {
            Storage::disk('public')->delete($car->$targetField);
        }

        // Ambil data biner foto langsung dari file ZIP
        $fileContent = $zip->getFromIndex($i);

        // Path penyimpanan file baru: storage/app/public/cars/
        $newPath = 'cars/' . $detectedNopol . '_' . $targetField . '_' . time() . '.' . $extension;

        // Simpan ke storage public
        Storage::disk('public')->put($newPath, $fileContent);

        // Update record path foto ke database
        $car->update([
            $targetField => $newPath,
        ]);

        $totalPhotosSaved++;
    }

    $zip->close();

    $responseMessage = "Proses selesai! Sebanyak {$totalPhotosSaved} foto berhasil dipasangkan ke unit mobil.";

    if (count($unmatchedNopol) > 0) {
        $responseMessage .= ' ' . count($unmatchedNopol) . ' folder nopol dilewati karena tidak cocok dengan data mobil di sistem.';
    }

    return redirect()->back()
        ->with('success', $responseMessage)
        ->with('unmatchedNopol', $unmatchedNopol);
}
}