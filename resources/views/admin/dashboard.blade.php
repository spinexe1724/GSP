@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900">
                    Dashboard
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Ringkasan operasional data showroom dan unit kendaraan.
                </p>
            </div>

            {{-- LINK KE HOMEPAGE SEBELUM LOGIN --}}
            <a href="{{ url('/') }}"
               target="_blank"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                      bg-white border border-slate-200 rounded-xl
                      text-sm font-bold text-slate-700
                      hover:border-[#800000] hover:text-[#800000]
                      hover:shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6"/>
                </svg>
                Lihat Homepage
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>


        {{-- =========================================================
            KPI CARDS
        ========================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- SHOWROOM --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            Total Showroom
                        </p>

                        <h2 class="text-3xl font-black text-slate-900 mt-2">
                            {{ number_format($totalShowrooms ?? 0) }}
                        </h2>

                        <p class="text-xs text-slate-400 mt-2">
                            Showroom terdaftar
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-700"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/>
                        </svg>
                    </div>

                </div>

            </div>


            {{-- UNIT MOBIL --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            Total Unit Mobil
                        </p>

                        <h2 class="text-3xl font-black text-slate-900 mt-2">
                            {{ number_format($totalCars ?? 0) }}
                        </h2>

                        <p class="text-xs text-slate-400 mt-2">
                            Total kendaraan
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-700"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 17h14M6 17l1-5h10l1 5M8 12l1.5-4h5L16 12M7 17v2m10-2v2"/>
                        </svg>
                    </div>

                </div>

            </div>


            {{-- FOTO --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            Unit Memiliki Foto
                        </p>

                        <h2 class="text-3xl font-black text-green-700 mt-2">
                            {{ number_format($carsWithPhotos ?? 0) }}
                        </h2>

                        <p class="text-xs text-slate-400 mt-2">
                            {{ $photoPercentage ?? 0 }}% dari total unit
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            CHART AREA
        ========================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- DOUGHNUT --}}
            <div class="lg:col-span-1 bg-white border border-slate-100 rounded-2xl shadow-sm p-6">

                <div class="mb-4">

                    <h3 class="text-sm font-black text-slate-900">
                        Kelengkapan Foto
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Status unit berdasarkan ketersediaan foto.
                    </p>

                </div>

                <div class="relative h-[280px]">
                    <canvas id="photoChart"></canvas>
                </div>

            </div>


            {{-- BAR CHART --}}
            <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm p-6">

                <div class="mb-4">

                    <h3 class="text-sm font-black text-slate-900">
                        Ringkasan Data
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Perbandingan data utama sistem.
                    </p>

                </div>

                <div class="relative h-[280px]">
                    <canvas id="summaryChart"></canvas>
                </div>

            </div>

        </div>


        {{-- =========================================================
            PHOTO PROGRESS
        ========================================================== --}}
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>
                    <h3 class="text-sm font-black text-slate-900">
                        Progress Kelengkapan Foto
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Persentase unit yang sudah memiliki minimal satu foto.
                    </p>
                </div>

                <div class="text-2xl font-black text-[#800000]">
                    {{ $photoPercentage ?? 0 }}%
                </div>

            </div>


            <div class="mt-5">

                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">

                    <div
                        class="h-full bg-[#800000] rounded-full transition-all duration-700"
                        style="width: {{ min($photoPercentage ?? 0, 100) }}%">
                    </div>

                </div>

                <div class="flex justify-between mt-2 text-[10px] text-slate-400 font-semibold">

                    <span>
                        {{ number_format($carsWithPhotos ?? 0) }} unit memiliki foto
                    </span>

                    <span>
                        {{ number_format($carsWithoutPhotos ?? 0) }} unit belum memiliki foto
                    </span>

                </div>

            </div>

        </div>


        {{-- =========================================================
            STATUS
        ========================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="bg-green-50 border border-green-100 rounded-2xl p-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">

                        <svg class="w-5 h-5 text-green-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    </div>

                    <div>

                        <p class="text-xs font-bold text-green-700 uppercase">
                            Unit Dengan Foto
                        </p>

                        <p class="text-lg font-black text-green-800">
                            {{ number_format($carsWithPhotos ?? 0) }} Unit
                        </p>

                    </div>

                </div>

            </div>


            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">

                        <svg class="w-5 h-5 text-amber-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 004.2 20h15.6a2 2 0 001.73-2.64l-7.82-13.5a2 2 0 00-3.42 0z"/>

                        </svg>

                    </div>

                    <div>

                        <p class="text-xs font-bold text-amber-700 uppercase">
                            Perlu Dilengkapi
                        </p>

                        <p class="text-lg font-black text-amber-800">
                            {{ number_format($carsWithoutPhotos ?? 0) }} Unit
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>


{{-- =========================================================
    CHART.JS
========================================================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | PHOTO CHART
    |--------------------------------------------------------------------------
    */

    const photoCanvas = document.getElementById('photoChart');

    if (photoCanvas) {

        new Chart(photoCanvas, {

            type: 'doughnut',

            data: {

                labels: [
                    'Sudah memiliki foto',
                    'Belum memiliki foto'
                ],

                datasets: [{

                    data: [
                        {{ $carsWithPhotos ?? 0 }},
                        {{ $carsWithoutPhotos ?? 0 }}
                    ],

                    backgroundColor: [
                        '#15803d',
                        '#e2e8f0'
                    ],

                    borderWidth: 0,

                    hoverOffset: 6

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '72%',

                plugins: {

                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 18,
                            font: {
                                size: 11
                            }
                        }
                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY CHART
    |--------------------------------------------------------------------------
    */

    const summaryCanvas = document.getElementById('summaryChart');

    if (summaryCanvas) {

        new Chart(summaryCanvas, {

            type: 'bar',

            data: {

                labels: [
                    'Showroom',
                    'Unit Mobil',
                    'Unit Berfoto'
                ],

                datasets: [{

                    label: 'Jumlah',

                    data: [
                        {{ $totalShowrooms ?? 0 }},
                        {{ $totalCars ?? 0 }},
                        {{ $carsWithPhotos ?? 0 }}
                    ],

                    backgroundColor: [
                        '#334155',
                        '#800000',
                        '#15803d'
                    ],

                    borderRadius: 8,

                    borderSkipped: false

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#f1f5f9'
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

    }

});

</script>

@endsection