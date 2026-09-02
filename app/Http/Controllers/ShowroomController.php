<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        ini_set('max_execution_time', '600');
        ini_set('memory_limit', '512M');

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
        ], [
            'file.required' => 'Pilih file Excel terlebih dahulu.',
            'file.mimes'    => 'Format file harus berupa .xlsx, .xls, atau .csv',
            'file.max'      => 'Ukuran file maksimal 20MB.',
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

        // Validasi kolom clprnoktp
        if (!isset($headerMap['clprnoktp'])) {
            $foundColumns = implode(', ', array_slice(array_keys($headerMap), 0, 8));
            return redirect()->back()->with('error', "Kolom 'clprnoktp' tidak ditemukan. Kolom yang terbaca: {$foundColumns}...");
        }

        // Cari index kolom cno atau variasinya
        $cnoCol = $headerMap['cno'] 
            ?? $headerMap['c_no'] 
            ?? $headerMap['custno'] 
            ?? $headerMap['c_custno'] 
            ?? $headerMap['cif'] 
            ?? null;

        $importedCount = 0;
        $skippedDetails = []; // Array untuk menampung alasan data gagal
        $rowNumber = 1; // Baris 1 adalah header, data dimulai dari baris 2

        // 2. Loop setiap baris data
        foreach ($rows as $row) {
            $rowNumber++;

            // Cek jika seluruh baris kosong
            $allEmpty = true;
            foreach ($row as $val) {
                if (trim((string)$val) !== '') {
                    $allEmpty = false;
                    break;
                }
            }
            if ($allEmpty) {
                // Abaikan baris kosong tanpa mencatat error
                continue;
            }

            $ktpCol = $headerMap['clprnoktp'];
            $rawKtp = isset($row[$ktpCol]) ? (string)$row[$ktpCol] : '';
            $namaDealer = isset($headerMap['nmdealer']) ? trim((string)($row[$headerMap['nmdealer']] ?? '')) : '-';
            $ktp = trim($rawKtp);

            // Konversi scientific notation (3.201E+15)
            if (stripos($ktp, 'E+') !== false || stripos($ktp, 'E-') !== false) {
                $ktp = number_format((float)$ktp, 0, '', '');
            }

            // ================= KLASIFIKASI ALASAN TIDAK MASUK =================
            if ($ktp === '' || $ktp === '-' || $ktp === '0') {
                $skippedDetails[] = [
                    'row'    => $rowNumber,
                    'dealer' => $namaDealer,
                    'ktp'    => $rawKtp ?: '(Kosong)',
                    'reason' => 'Nomor KTP kosong / berisi strip (-)'
                ];
                continue;
            }

            if (!ctype_digit($ktp)) {
                $skippedDetails[] = [
                    'row'    => $rowNumber,
                    'dealer' => $namaDealer,
                    'ktp'    => $rawKtp,
                    'reason' => 'Mengandung karakter non-angka (huruf/spasi/simbol)'
                ];
                continue;
            }

            $len = strlen($ktp);
            if ($len !== 16) {
                $skippedDetails[] = [
                    'row'    => $rowNumber,
                    'dealer' => $namaDealer,
                    'ktp'    => $rawKtp,
                    'reason' => "Panjang KTP tidak 16 digit (terdeteksi {$len} digit)"
                ];
                continue;
            }

            try {
                Showroom::updateOrCreate(
                    ['clprnoktp' => $ktp],
                    [
                        'cno'        => ($cnoCol && isset($row[$cnoCol])) ? trim((string)$row[$cnoCol]) : null,
                        'kdcab'      => isset($headerMap['kdcab']) ? trim((string)($row[$headerMap['kdcab']] ?? '')) : null,
                        'inisial'    => isset($headerMap['inisial']) ? trim((string)($row[$headerMap['inisial']] ?? '')) : null,
                        'nmdealer'   => isset($headerMap['nmdealer']) ? trim((string)($row[$headerMap['nmdealer']] ?? '')) : null,
                        'cnm'        => isset($headerMap['cnm']) ? trim((string)($row[$headerMap['cnm']] ?? '')) : null,
                        'ad1'        => isset($headerMap['ad1']) ? trim((string)($row[$headerMap['ad1']] ?? '')) : null,
                        'ad2'        => isset($headerMap['ad2']) ? trim((string)($row[$headerMap['ad2']] ?? '')) : null,
                        'kota'       => isset($headerMap['kota']) ? trim((string)($row[$headerMap['kota']] ?? '')) : null,
                        'alamat'     => isset($headerMap['alamat']) ? trim((string)($row[$headerMap['alamat']] ?? '')) : null,
                        'dlmou'      => isset($headerMap['dlmou']) ? trim((string)($row[$headerMap['dlmou']] ?? '')) : null,
                        'dlmoutglfr' => isset($headerMap['dlmoutglfr']) ? trim((string)($row[$headerMap['dlmoutglfr']] ?? '')) : null,
                        'dlmoutglto' => isset($headerMap['dlmoutglto']) ? trim((string)($row[$headerMap['dlmoutglto']] ?? '')) : null,
                    ]
                );
                $importedCount++;
            } catch (\Exception $e) {
                Log::warning("Gagal simpan KTP {$ktp}: " . $e->getMessage());
                $skippedDetails[] = [
                    'row'    => $rowNumber,
                    'dealer' => $namaDealer,
                    'ktp'    => $ktp,
                    'reason' => 'Gagal simpan database: ' . $e->getMessage()
                ];
            }
        }

        $totalSkipped = count($skippedDetails);

        return redirect()->back()
            ->with('success', "Proses selesai: {$importedCount} data valid berhasil disimpan/diperbarui.")
            ->with('skippedDetails', $skippedDetails)
            ->with('totalSkipped', $totalSkipped);
    }
public function monitoring(Request $request)
{
    // Eager load relasi cars agar query ringan dan cepat
    $query = Showroom::with('cars');

    // Filter Pencarian (Nama Dealer, CNO, KTP, atau Pemilik)
    if ($request->filled('search')) {
        $search = trim($request->search);
        $query->where(function ($q) use ($search) {
            $q->where('nmdealer', 'like', "%{$search}%")
              ->orWhere('cno', 'like', "%{$search}%")
              ->orWhere('clprnoktp', 'like', "%{$search}%")
              ->orWhere('cnm', 'like', "%{$search}%")
              ->orWhere('kota', 'like', "%{$search}%")
              // Bisa juga cari berdasarkan nopol/merk mobil yang ada di showroom tersebut
              ->orWhereHas('cars', function ($carQuery) use ($search) {
                  $carQuery->where('nopol', 'like', "%{$search}%")
                           ->orWhere('merk', 'like', "%{$search}%");
              });
        });
    }

    // Filter: Hanya tampilkan showroom yang punya mobil
    if ($request->get('has_cars') === '1') {
        $query->has('cars');
    }

    $showrooms = $query->paginate(20)->withQueryString();

    return view('showrooms.monitoring', compact('showrooms'));
}
}