<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Showroom;
use App\Models\UnmatchedCar;
use App\Models\UnmatchedPhoto;
use App\Models\PhotoReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;

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
        // 1. Validasi File Excel/CSV
       $request->validate([
        'file' => 'required|mimes:xlsx,csv|max:10240',
    ]);

    $file = $request->file('file');
    $filename = time() . '_unit.' . $file->getClientOriginalExtension();
    $destinationPath = storage_path('app/temp');
    
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $file->move($destinationPath, $filename);
    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;

    (new FastExcel)->import($fullPath, function ($row) {
        $rowLower = array_change_key_case($row, CASE_LOWER);

        $safeString = function ($value) {
            if ($value instanceof \DateTimeInterface) {
                return $value->format('Y-m-d');
            }
            return trim((string) $value);
        };

        $nopol = $safeString($rowLower['no_polisi'] ?? $rowLower['nopol'] ?? '');
        $nocif = $safeString($rowLower['no_cif'] ?? $rowLower['cif'] ?? '');

        if (!empty($nopol)) {
            // Cek apakah no_cif ini terdaftar sebagai cno di tabel showrooms
            $showroomExists = Showroom::where('cno', $nocif)->exists();

            $dataPayload = [
                'no_polisi'  => $nopol,
                'no_cif'     => $nocif,
                'nama_merk'  => $safeString($rowLower['nama_merk'] ?? $rowLower['merk'] ?? ''),
                'tipe_kend'  => $safeString($rowLower['tipe_kend'] ?? $rowLower['tipe'] ?? ''),
                'warna_kend' => $safeString($rowLower['warna_kend'] ?? $rowLower['warna'] ?? ''),
                'jenis_kend' => $safeString($rowLower['jenis_kend'] ?? $rowLower['jenis'] ?? ''),
                'transmisi'  => $safeString($rowLower['transmisi'] ?? $rowLower['trans'] ?? ''),
                'tahun_buat' => $safeString($rowLower['tahun_buat'] ?? $rowLower['tahun'] ?? $rowLower['thn'] ?? null),
            ];

            if ($showroomExists) {
                // Jika cocok, masukkan ke tabel utama (bisa pakai upsert)
                Car::updateOrCreate(['no_polisi' => $nopol], array_merge($dataPayload, [
                    'showroom_id' => Showroom::where('cno', $nocif)->value('id') // Sesuaikan foreign key jika ada
                ]));
            } else {
                // Jika tidak cocok/tidak ditemukan, lempar ke tabel staging (Review Area)
                UnmatchedCar::updateOrCreate(['no_polisi' => $nopol], $dataPayload);
            }
        }
    });

    if (file_exists($fullPath)) {
        unlink($fullPath);
    }

    return redirect()->back()->with('success', 'Proses Excel selesai! Data yang CIF-nya tidak cocok diamankan ke menu Review.');
}
public function uploadZipPhotos(Request $request)
{
   $request->validate([
        'zip_file' => 'required|file|mimes:zip,application/zip,application/x-zip-compressed',
    ]);

    try {
        $file = $request->file('zip_file');
        
        // Buat nama file unik
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Tentukan folder tujuan fisik di storage/app/temp_uploads
        $destinationPath = storage_path('app/temp_uploads');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Pindahkan file dari direktori sementara PHP ke folder tujuan secara langsung
        $file->move($destinationPath, $filename);
        $fullZipPath = $destinationPath . '/' . $filename;

        // Pastikan file benar-benar ada di tujuan
        if (!file_exists($fullZipPath)) {
            throw new \Exception("Gagal memindahkan file ZIP ke folder penyimpanan.");
        }

        // Lempar ke Background Job (Queue)
        \App\Jobs\ProcessCarPhotosZip::dispatch($fullZipPath);

        return redirect()->back()->with('success', 'File ZIP berhasil diunggah dan masuk antrean proses!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}
public function destroy($id)
{
    $car = Car::findOrFail($id);

    // Hapus file fisik foto jika ada di disk storage public
    $photoFields = ['foto_depan', 'foto_samping', 'foto_belakang'];
    foreach ($photoFields as $field) {
        if (!empty($car->$field) && Storage::disk('public')->exists($car->$field)) {
            Storage::disk('public')->delete($car->$field);
        }
    }

    $nopol = $car->no_polisi;
    $car->delete();

    return redirect()->back()->with('success', "Unit mobil dengan plat nomor {$nopol} berhasil dihapus.");
}

public function uploadChunk(Request $request)
{
    $file = $request->file('file');
    $fileName = $request->post('resumableFilename');
    $chunkIndex = $request->post('resumableChunkNumber') - 1;
    $totalChunks = $request->post('resumableTotalChunks');

    // Folder penyimpanan sementara untuk potongan file
    $tempDir = storage_path('app/temp_chunks/' . md5($fileName));
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    // Pindahkan chunk ke folder temp
    $file->move($tempDir, $chunkIndex);

    // Cek apakah semua chunk sudah terkumpul lengkap
    $allChunksUploaded = true;
    for ($i = 0; $i < $totalChunks; $i++) {
        if (!file_exists($tempDir . '/' . $i)) {
            $allChunksUploaded = false;
            break;
        }
    }

    // Jika semua bagian sudah lengkap, gabungkan menjadi file ZIP utuh
    if ($allChunksUploaded) {
        $finalPath = storage_path('app/temp_uploads/' . time() . '_' . $fileName);
        $finalFile = fopen($finalPath, 'wb');

        for ($i = 0; $i < $totalChunks; $i++) {
            $chunk = fopen($tempDir . '/' . $i, 'rb');
            stream_copy_to_stream($chunk, $finalFile);
            fclose($chunk);
            unlink($tempDir . '/' . $i); // Hapus chunk setelah digabung
        }

        fclose($finalFile);
        rmdir($tempDir); // Hapus folder temp chunks

        // Lempar file ZIP utuh ke Background Job yang sudah ada
        \App\Jobs\ProcessCarPhotosZip::dispatch($finalPath);

        return response()->json([
            'status' => 'completed', 
            'message' => 'File berhasil digabung dan masuk antrean proses!'
        ]);
    }

    return response()->json([
        'status' => 'uploading', 
        'message' => 'Chunk diterima.'
    ]);
}

}