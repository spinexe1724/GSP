@extends('layouts.admin')
@section('title', 'Review Foto Unit')
@section('content')

<div class="min-h-screen bg-[#f8fafc] font-['Plus_Jakarta_Sans'] text-slate-800">
    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-5 space-y-5">

        @php
            $perPage = 10;
            $currentPage = max(1, (int) request()->query('page', 1));
            $totalFolders = $groupedPhotos->count();
            $totalPages = max(1, (int) ceil($totalFolders / $perPage));
            $currentPage = min($currentPage, $totalPages);
            $pagedPhotos = $groupedPhotos->forPage($currentPage, $perPage);
            
            // Untuk penomoran tabel
            $startIndex = ($currentPage - 1) * $perPage;
        @endphp

        {{-- HEADER --}}
        <div class="bg-white border border-slate-200 rounded-xl px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h1 class="text-lg font-black text-slate-900">Daftar Antrean Review Foto</h1>
                    @if($totalFolders > 0)
                        <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold">
                            {{ $totalFolders }} Antrean
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500">Pilih Nopol pada tabel di bawah ini untuk melihat dan memetakan foto ke unit kendaraan.</p>
            </div>

            <form action="{{ route('admin.cars.photo_review.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SEMUA data foto review? Tindakan ini tidak dapat dibatalkan.');">
                @csrf @method('DELETE')
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-[#800000] border border-red-200 text-xs font-bold px-4 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Bersihkan Semua
                </button>
            </form>
        </div>

        {{-- TABEL MONITORING --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">No</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider">No. Polisi (Folder)</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Jumlah Foto</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pagedPhotos as $nopol => $photos)
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="px-5 py-4 text-sm text-slate-500 text-center font-medium">
                                    {{ $startIndex + $loop->iteration }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center flex-shrink-0 group-hover:bg-[#800000] group-hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-black text-slate-900 uppercase">{{ $nopol }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold">
                                        {{ $photos->count() }} Foto
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    {{-- TOMBOL MENUJU DETAIL --}}
                                    <a href="{{ route('admin.cars.photo_review.detail', ['id' => $nopol]) }}" class="inline-flex items-center justify-center gap-1.5 bg-[#800000] hover:bg-red-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                        Proses
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-16 text-center">
                                    <div class="w-16 h-16 mx-auto rounded-full bg-emerald-50 flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h2 class="text-sm font-black text-slate-900">Semua Foto Sudah Terpetakan</h2>
                                    <p class="text-xs text-slate-500 mt-1">Tidak ada antrean folder foto saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($totalPages > 1)
            <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-5 py-3">
                <p class="text-xs text-slate-500">
                    Menampilkan halaman <span class="font-bold text-slate-700">{{ $currentPage }}</span> dari <span class="font-bold text-slate-700">{{ $totalPages }}</span>
                </p>
                <div class="flex gap-2">
                    @if($currentPage > 1)
                        <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition">Sebelumnya</a>
                    @endif
                    @if($currentPage < $totalPages)
                        <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}" class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition">Selanjutnya</a>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>

@endsection