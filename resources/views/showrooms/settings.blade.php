@extends('layouts.app')

@section('title', 'Pengaturan Akun Showroom')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 pb-12 pt-24 font-['Plus_Jakarta_Sans'] sm:px-6">
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('showrooms.dashboard') }}" class="inline-flex min-h-11 items-center gap-2 text-sm font-bold text-slate-600 transition hover:text-[#800000] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#800000]">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12" />
            </svg>
            Kembali ke dashboard
        </a>

        <header class="mt-5 rounded-3xl bg-[#800000] p-6 text-white shadow-sm sm:p-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-white/70">Akun mitra showroom</p>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight sm:text-3xl">Pengaturan akun</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-white/80">Perbarui informasi kontak operasional atau ganti password akun showroom Anda.</p>
            <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-white/20 pt-4 text-sm">
                <span class="font-bold">{{ $user->nmdealer ?? 'Showroom' }}</span>
                @if($user->cno)
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">CIF / CNO: {{ $user->cno }}</span>
                @endif
            </div>
        </header>

        @if(session('success'))
            <div role="status" class="mt-5 flex gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                </svg>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="mt-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                <p class="font-extrabold">Pengaturan belum berhasil disimpan.</p>
                <p class="mt-1">Periksa kembali informasi yang ditandai di bawah.</p>
            </div>
        @endif

        <form action="{{ route('showrooms.settings.update_profile') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="flex items-start gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-[#800000]" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h3.3a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.5 1.21L8 10.52a11 11 0 0 0 5.48 5.48l1.13-2.25a1 1 0 0 1 1.21-.5l4.5 1.5a1 1 0 0 1 .68.95V19a2 2 0 0 1-2 2h-1C9.72 21 3 14.28 3 6V5Z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Informasi kontak</h2>
                        <p class="mt-1 text-sm leading-6 text-slate-500">Nomor PIC untuk komunikasi operasional showroom.</p>
                    </div>
                </div>

                <div class="mt-6 max-w-xl">
                    <label for="nopic" class="block text-sm font-bold text-slate-800">Nomor WhatsApp PIC <span class="font-medium text-slate-400">(opsional)</span></label>
                    <input
                        type="tel"
                        name="nopic"
                        id="nopic"
                        value="{{ old('nopic', $showroom->nopic ?? '') }}"
                        maxlength="20"
                        autocomplete="tel"
                        inputmode="tel"
                        placeholder="Contoh: 08123456789"
                        aria-describedby="nopic-help @error('nopic') nopic-error @enderror"
                        @error('nopic') aria-invalid="true" @enderror
                        class="mt-2 min-h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-[#800000] focus:outline-none focus:ring-2 focus:ring-[#800000]/20 @error('nopic') border-red-500 @enderror"
                    >
                    <p id="nopic-help" class="mt-2 text-xs leading-5 text-slate-500">Maksimal 20 karakter. Pastikan nomor dapat dihubungi.</p>
                    @error('nopic')
                        <p id="nopic-error" class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="flex items-start gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-700" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="10" width="16" height="11" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3m-4 5v2" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Keamanan akun</h2>
                        <p class="mt-1 text-sm leading-6 text-slate-500">Isi kedua kolom berikut hanya jika ingin mengganti password.</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-800">Password baru</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="new-password"
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            aria-describedby="password-help @error('password') password-error @enderror"
                            @error('password') aria-invalid="true" @enderror
                            class="mt-2 min-h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-[#800000] focus:outline-none focus:ring-2 focus:ring-[#800000]/20 @error('password') border-red-500 @enderror"
                        >
                        <p id="password-help" class="mt-2 text-xs leading-5 text-slate-500">Gunakan minimal 8 karakter.</p>
                        @error('password')
                            <p id="password-error" class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-800">Konfirmasi password baru</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            autocomplete="new-password"
                            minlength="8"
                            placeholder="Ketik ulang password baru"
                            aria-describedby="@error('password') password-confirmation-error @enderror"
                            @error('password') aria-invalid="true" @enderror
                            class="mt-2 min-h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-[#800000] focus:outline-none focus:ring-2 focus:ring-[#800000]/20 @error('password') border-red-500 @enderror"
                        >
                        @error('password')
                            <p id="password-confirmation-error" class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('showrooms.dashboard') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000]">Batal</a>
                <button type="submit" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-[#800000] px-6 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#650000] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#800000]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                    </svg>
                    Simpan pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
