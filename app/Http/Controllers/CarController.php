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

        // Pencarian berdasarkan merk, tipe, nopol, warna, atau nama showroom
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama_merk', 'like', "%{$search}%")
                  ->orWhere('tipe_kend', 'like', "%{$search}%")
                  ->orWhere('no_polisi', 'like', "%{$search}%")
                  ->orWhere('warna_kend', 'like', "%{$search}%")
                  ->orWhere('jenis_kend', 'like', "%{$search}%")
                  ->orWhereHas('showroom', function ($showroomQuery) use ($search) {
                      $showroomQuery->where('nmdealer', 'like', "%{$search}%")
                                    ->orWhere('kota', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Merk
        if ($request->filled('merk')) {
            $query->where('nama_merk', $request->merk);
        }

        // Filter Transmisi
        if ($request->filled('transmisi')) {
            $query->where('transmisi', $request->transmisi);
        }

        $cars = $query->latest()->paginate(12)->withQueryString();

        // Ambil daftar merk unik untuk opsi filter dropdown
        $brands = Car::whereNotNull('nama_merk')->distinct()->pluck('nama_merk');

        return view('cars.index', compact('cars', 'brands'));
    }
    public function show($id)
    {
        $car = Car::with('showroom')->findOrFail($id);

        // Rekomendasi mobil lain dari showroom yang sama
        $relatedCars = Car::where('no_cif', $car->no_cif)
            ->where('id', '!=', $car->id)
            ->limit(3)
            ->get();

        return view('cars.show', compact('car', 'relatedCars'));
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
            $worksheet   = $spreadsheet->getActiveSheet();
            $rows        = $worksheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file Excel: ' . $e->getMessage());
        }

        if (empty($rows)) {
            return redirect()->back()->with('error', 'File Excel kosong.');
        }

        // 1. Ambil baris pertama sebagai Header dan normalisasi
        $rawHeader = array_shift($rows);
        $headerMap = [];

        foreach ($rawHeader as $colLetter => $colName) {
            $cleaned = strtolower(trim((string)$colName));
            $cleaned = str_replace(['-', ' '], '_', $cleaned); // ganti spasi/strip jadi underscore
            if (!empty($cleaned)) {
                $headerMap[$cleaned] = $colLetter;
            }
        }

        // 2. Mapping key kolom (beserta kemungkinan aliasnya di Excel)
        $cifKey = $headerMap['no_cif'] ?? $headerMap['nocif'] ?? $headerMap['cif'] ?? null;
        $nopolKey = $headerMap['no_polisi'] ?? $headerMap['nopol'] ?? $headerMap['plat'] ?? null;
        $merkKey = $headerMap['nama_merk'] ?? $headerMap['merk'] ?? null;
        $tipeKey = $headerMap['tipe_kend'] ?? $headerMap['type'] ?? $headerMap['tipe'] ?? null;
        $tahunKey = $headerMap['tahun_buat'] ?? $headerMap['tahun'] ?? null;
        $jenisKey = $headerMap['jenis_kend'] ?? $headerMap['jenis'] ?? null;
        $transmisiKey = $headerMap['transmisi'] ?? null;
        $warnaKey = $headerMap['warna_kend'] ?? $headerMap['warna'] ?? null;

        if (!$cifKey) {
            $foundCols = implode(', ', array_slice(array_keys($headerMap), 0, 8));
            return redirect()->back()->with('error', "Kolom 'no_cif' tidak ditemukan di baris pertama Excel. Kolom terbaca: {$foundCols}...");
        }

        $importedCount = 0;
        $skippedCount  = 0;

        foreach ($rows as $row) {
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

            $noCif    = isset($row[$cifKey]) ? trim((string)$row[$cifKey]) : null;
            $noPolisi = ($nopolKey && isset($row[$nopolKey])) ? trim((string)$row[$nopolKey]) : null;

            if (empty($noCif) || $noCif === '-' || $noCif === '0') {
                $skippedCount++;
                continue;
            }

            try {
                Car::updateOrCreate(
                    [
                        'no_cif'    => $noCif,
                        'no_polisi' => !empty($noPolisi) ? $noPolisi : '-',
                    ],
                    [
                        'jenis_kend' => ($jenisKey && isset($row[$jenisKey])) ? trim((string)$row[$jenisKey]) : null,
                        'nama_merk'  => ($merkKey && isset($row[$merkKey])) ? trim((string)$row[$merkKey]) : null,
                        'tipe_kend'  => ($tipeKey && isset($row[$tipeKey])) ? trim((string)$row[$tipeKey]) : null,
                        'transmisi'  => ($transmisiKey && isset($row[$transmisiKey])) ? trim((string)$row[$transmisiKey]) : null,
                        'warna_kend' => ($warnaKey && isset($row[$warnaKey])) ? trim((string)$row[$warnaKey]) : null,
                        'tahun_buat' => ($tahunKey && isset($row[$tahunKey])) ? trim((string)$row[$tahunKey]) : null,
                    ]
                );
                $importedCount++;
            } catch (\Exception $e) {
                Log::warning("Gagal simpan mobil No CIF {$noCif} Nopol {$noPolisi}: " . $e->getMessage());
                $skippedCount++;
            }
        }

        return redirect()->back()->with('success', "Update data mobil selesai: {$importedCount} unit berhasil disimpan/diperbarui ({$skippedCount} baris dilewati).");
    }
 public function uploadZipPhotos(Request $request)
    {
        ini_set('max_execution_time', '900');
        ini_set('memory_limit', '1024M');

        $request->validate([
            'zip_file' => 'required|file|mimes:zip|max:512000',
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

        // Cache lookup Nopol di memory agar proses cepat
        $allCars = Car::select('id', 'no_polisi', 'foto_depan', 'foto_samping', 'foto_belakang')->get();
        $carMap = [];
        foreach ($allCars as $c) {
            $cleanDbNopol = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($c->no_polisi));
            if ($cleanDbNopol) {
                $carMap[$cleanDbNopol] = $c;
            }
        }

        $unmatchedNopol = [];
        $totalPhotosSaved = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);

            if (
                str_ends_with($filename, '/') ||
                str_contains($filename, '__MACOSX') ||
                str_contains($filename, '.DS_Store') ||
                str_contains($filename, 'Thumbs.db')
            ) {
                continue;
            }

            $pathParts  = explode('/', str_replace('\\', '/', $filename));
            $fileOnly   = end($pathParts);
            $folderName = prev($pathParts);

            if (!$folderName) {
                continue;
            }

            // Ekstraksi plat nomor dari nama folder
            $detectedNopol = null;
            if (preg_match('/([A-Za-z]{1,2})\s*([0-9]{1,4})\s*([A-Za-z]{1,3})/', $folderName, $matches)) {
                $detectedNopol = strtoupper($matches[1] . $matches[2] . $matches[3]);
            } else {
                $detectedNopol = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($folderName));
            }

            if (!isset($carMap[$detectedNopol])) {
                if (!in_array($folderName, $unmatchedNopol)) {
                    $unmatchedNopol[] = $folderName;
                }
                continue;
            }

            $car = $carMap[$detectedNopol];

            $extension     = strtolower(pathinfo($fileOnly, PATHINFO_EXTENSION));
            $lowerFileOnly = strtolower($fileOnly);

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }

            $targetField = null;
            if (str_contains($lowerFileOnly, 'depan') || str_contains($lowerFileOnly, 'front')) {
                $targetField = 'foto_depan';
            } elseif (str_contains($lowerFileOnly, 'samping') || str_contains($lowerFileOnly, 'side')) {
                $targetField = 'foto_samping';
            } elseif (str_contains($lowerFileOnly, 'belakang') || str_contains($lowerFileOnly, 'rear') || str_contains($lowerFileOnly, 'back')) {
                $targetField = 'foto_belakang';
            }

            if (!$targetField) {
                continue;
            }

            if (!empty($car->$targetField) && Storage::disk('public')->exists($car->$targetField)) {
                Storage::disk('public')->delete($car->$targetField);
            }

            $fileContent = $zip->getFromIndex($i);
            $newPath = 'cars/' . $detectedNopol . '_' . $targetField . '_' . time() . '.' . $extension;

            Storage::disk('public')->put($newPath, $fileContent);

            $car->update([$targetField => $newPath]);
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