<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use ZipArchive;


class PortalController extends Controller
{
   public function index(Request $request)
{
    $query = Car::with('showroom');

    // 1. Pencarian berdasarkan kata kunci
   if ($request->filled('search')) {
        $search = trim($request->search);
        $query->where(function ($q) use ($search) {
            $q->where('nama_merk', 'like', "%{$search}%")
              ->orWhere('tipe_kend', 'like', "%{$search}%")
              ->orWhere('warna_kend', 'like', "%{$search}%")
              ->orWhere('jenis_kend', 'like', "%{$search}%")
              ->orWhereHas('showroom', function ($showroomQuery) use ($search) {
                  $showroomQuery->where('kota', 'like', "%{$search}%");
              });
        });
    }

    // 2. Filter Merk (Sudah diperbaiki ke $request->brand dan menggunakan LIKE agar cocok dengan huruf KAPITAL)
    if ($request->filled('brand')) {
        $brand = trim($request->brand);
        $query->where('nama_merk', 'like', "%{$brand}%");
    }

    // 3. Filter Transmisi (Mendukung nama input 'transmission' dari Blade maupun 'transmisi')
    $transmisiInput = $request->input('transmission') ?? $request->input('transmisi');
    if (!empty($transmisiInput)) {
        $query->where('transmisi', 'like', "%{$transmisiInput}%");
    }

    // 4. Filter Tahun Kendaraan
    if ($request->filled('year')) {
        $query->where('tahun_buat', $request->year);
    }

    $cars = $query->latest()->paginate(12)->withQueryString();

    // Ambil daftar merk unik untuk opsi filter dropdown
    $brands = Car::whereNotNull('nama_merk')->distinct()->pluck('nama_merk');

    return view('portal.index', compact('cars', 'brands'));
}
}
