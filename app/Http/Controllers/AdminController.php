<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Showroom;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalShowrooms = Showroom::count();

        $totalCars = Car::count();

        $carsWithPhotos = Car::whereNotNull('foto_depan')
            ->orWhereNotNull('foto_samping')
            ->orWhereNotNull('foto_belakang')
            ->count();

        $carsWithoutPhotos = max($totalCars - $carsWithPhotos, 0);

        $photoPercentage = $totalCars > 0
            ? round(($carsWithPhotos / $totalCars) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'totalShowrooms',
            'totalCars',
            'carsWithPhotos',
            'carsWithoutPhotos',
            'photoPercentage'
        ));
    }
}