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

        return view('portal.index', compact('cars', 'brands'));
    }
}
