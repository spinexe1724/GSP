@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Akun Showroom</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('showrooms.settings.update_profile') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Bagian 1: Informasi Kontak / Nomor WhatsApp --}}
            <div class="mb-8 pb-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Kontak</h3>
                
                <div class="max-w-md">
                    <label for="nopic" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (PIC)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Ikon WhatsApp / Telepon -->
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="text" name="nopic" id="nopic" value="{{ old('nopic', $user->nopic) }}" class="pl-10 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 border" placeholder="Contoh: 08123456789">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Nomor ini akan digunakan untuk komunikasi operasional atau B2B.</p>
                </div>
            </div>

            {{-- Bagian 2: Ganti Password --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Ubah Password</h3>
                <p class="text-sm text-gray-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah password saat ini.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 border" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 border" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm font-medium">Batal</a>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection