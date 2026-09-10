<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
class ShowroomController extends Controller
{
  public function index()
{
    return view('showrooms.upload-showrooms');
}

public function show($id)
    {
        // Ambil data showroom beserta unit mobil yang dimilikinya (Eager Loading)
        $showroom = Showroom::with('cars')->findOrFail($id);

        return view('showrooms.show', compact('showroom'));
    }

    public function myProfile()
{
    $user = auth()->user();

    // Cari showroom berdasarkan KTP atau CNO user yang login
    $showroom = Showroom::with('cars')
        ->where('clprnoktp', $user->ktp ?? $user->clprnoktp)
        ->first();

    // Jika showroom tidak ditemukan, bisa dialihkan atau buat view penanganan
    if (!$showroom) {
        return redirect()->route('cars.index')->with('error', 'Profil data showroom belum terhubung dengan akun Anda.');
    }

    return view('showrooms.profile', compact('showroom'));
}
public function upload(Request $request)
    {
 $request->validate([
        'file' => 'required|mimes:xlsx,csv|max:10240',
    ], [
        'file.required' => 'Pilih file Excel showroom terlebih dahulu.',
        'file.mimes'    => 'Format file ditolak! Gunakan file .xlsx atau .csv.',
        'file.max'      => 'Ukuran file maksimal 10MB.'
    ]);

    $file = $request->file('file');
    $filename = time() . '_showroom.' . $file->getClientOriginalExtension();
    $destinationPath = storage_path('app/temp');
    
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $file->move($destinationPath, $filename);
    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;

    $batchData = [];
    $batchSize = 1000;
    $now = Carbon::now();

    (new FastExcel)->import($fullPath, function ($row) use (&$batchData, $batchSize, $now) {
        $rowLower = array_change_key_case($row, CASE_LOWER);

        $safeString = function ($value) {
            if ($value instanceof \DateTimeInterface) {
                return $value->format('Y-m-d');
            }
            return trim((string) $value);
        };

        // Ambil dan bersihkan data KTP
        $rawKtp = $safeString($rowLower['clprnoktp'] ?? $rowLower['ktp'] ?? $rowLower['no_ktp'] ?? '');
        $ktpClean = ($rawKtp === '') ? null : $rawKtp;

        // Ambil cno, jika kosong jadikan null atau string kosong
        $cno = $safeString($rowLower['cno'] ?? $rowLower['kode_dealer'] ?? '');
        $finalCno = ($cno === '') ? null : $cno;

        // Ambil variabel inisial
        $inisialValue = $safeString($rowLower['inisial'] ?? '');

        // TANPA FILTER empty($cno): Semua baris di Excel sekarang pasti masuk!
        $batchData[] = [
            'clprnoktp'  => $ktpClean,
            'cno'        => $finalCno,
            'kdcab'      => $safeString($rowLower['kdcab'] ?? ''),
            'inisial'    => $inisialValue,
            'nmdealer'   => $safeString($rowLower['nmdealer'] ?? $rowLower['nama_dealer'] ?? ''),
            'cnm'        => $safeString($rowLower['cnm'] ?? ''),
            'ad1'        => $safeString($rowLower['ad1'] ?? ''),
            'ad2'        => $safeString($rowLower['ad2'] ?? ''),
            'kota'       => $safeString($rowLower['kota'] ?? ''),
            'alamat'     => $safeString($rowLower['alamat'] ?? ''),
            'dlmou'      => $safeString($rowLower['dlmou'] ?? ''),
            'dlmoutglfr' => $safeString($rowLower['dlmoutglfr'] ?? ''), 
            'dlmoutglto' => $safeString($rowLower['dlmoutglto'] ?? ''), 
            'created_at' => $now,
            'updated_at' => $now,
        ];

        if (count($batchData) >= $batchSize) {
            // Menggunakan insert biasa atau upsert dengan aman
            // Catatan: Jika ada cno yang bernilai null secara massal, gunakan insert untuk menghindari bentrok unik key database.
            Showroom::insert($batchData);
            $batchData = [];
        }
    });

    if (count($batchData) > 0) {
        Showroom::insert($batchData);
    }

    if (file_exists($fullPath)) {
        unlink($fullPath);
    }

    return redirect()->back()->with('success', 'Semua data showroom berhasil di-upload secara utuh! Data dengan CNO kosong tetap masuk.');
}

public function monitoring(Request $request)
    {
        $query = Showroom::with('cars');

        // Pencarian komprehensif pada Showroom dan Field Cars Terbaru
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                // Pencarian data Showroom
                $q->where('cno', 'like', "%{$search}%")
                  ->orWhere('nmdealer', 'like', "%{$search}%")
                  ->orWhere('cnm', 'like', "%{$search}%")
                  ->orWhere('clprnoktp', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('kdcab', 'like', "%{$search}%")
                  // Pencarian relasi ke tabel Cars dengan field-field baru
                  ->orWhereHas('cars', function ($carQuery) use ($search) {
                      $carQuery->where('no_polisi', 'like', "%{$search}%")
                               ->orWhere('no_cif', 'like', "%{$search}%")
                               ->orWhere('nama_merk', 'like', "%{$search}%")
                               ->orWhere('tipe_kend', 'like', "%{$search}%")
                               ->orWhere('jenis_kend', 'like', "%{$search}%")
                               ->orWhere('warna_kend', 'like', "%{$search}%")
                               ->orWhere('transmisi', 'like', "%{$search}%")
                               ->orWhere('tahun_buat', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Showroom yang memiliki unit mobil
        if ($request->filled('has_cars') && $request->has_cars == '1') {
            $query->has('cars');
        }

        $showrooms = $query->latest()->paginate(10)->withQueryString();

        return view('showrooms.monitoring', compact('showrooms'));
    }
}