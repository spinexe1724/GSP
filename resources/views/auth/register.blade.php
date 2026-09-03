@extends('layouts.app')

@section('title', 'Register Partner - Gratama Dealer')

@section('content')
<div class="relative w-full bg-white font-['Plus_Jakarta_Sans']">
    
    {{-- HERO SECTION --}}
    <div class="relative min-h-[750px] md:h-[850px] w-full overflow-hidden pt-28 md:pt-36">
        {{-- Background Image --}}
        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2000" 
             class="absolute inset-0 w-full h-full object-cover" alt="Hero Background">
        
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 container mx-auto px-6 h-full flex flex-col md:flex-row items-center justify-between pb-16">
            
            {{-- Bagian Teks Hero (Kiri) --}}
            <div class="hidden md:block text-white max-w-xl">
                <h1 class="text-6xl font-black leading-tight mb-4 tracking-tighter">
                    Join Our <br> <span class="text-red-600">Partnership.</span>
                </h1>
                <p class="text-lg opacity-70 font-medium">
                    Daftarkan showroom Anda menggunakan Nomor KTP terdaftar untuk mulai mengelola unit secara profesional.
                </p>
            </div>

            {{-- FORM REGISTER (Kanan) --}}
            <div class="w-full max-w-[450px] bg-white/20 backdrop-blur-2xl p-10 rounded-[40px] shadow-2xl border border-white/10 mt-8 md:mt-0 relative overflow-hidden">
                
                <div class="mb-8 text-center md:text-left">
                    <h2 class="text-3xl font-black text-white tracking-tight">Register</h2>
                    <p class="text-white/60 text-[10px] font-black uppercase tracking-[0.3em] mt-2">Become a Gratama Partner</p>
                </div>

                {{-- Menampilkan Error Jika KTP Tidak Terdaftar --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-2xl">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-200 text-xs font-bold">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    {{-- Input clpnoktp (KTP) --}}
                    <div class="space-y-1">
                        <input type="text" name="clprnoktp" value="{{ old('clprnoktp') }}" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="NIK">
                    </div>

                    {{-- Input Email --}}
                    <div class="space-y-1">
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="Email Aktif">
                    </div>

                    {{-- Input No Telepon --}}
                    <div class="space-y-1">
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="Nomor Telepon">
                    </div>
                    
                    {{-- Input Password --}}
                    <div class="space-y-1">
                        <input type="password" name="password" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="Password">
                    </div>

                    {{-- Confirm Password --}}
                    <div class="space-y-1">
                        <input type="password" name="password_confirmation" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="Confirm Password">
                    </div>
                    
                    <div class="pt-6">
                        <button type="submit" 
                                 class="w-full bg-[#800000] hover:bg-red-900 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-red-950/40 transition-all duration-300 transform active:scale-95">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-10 text-center pt-6 border-t border-white/10">
                    <p class="text-white/40 font-bold text-[10px] uppercase tracking-widest">
                        Already a Partner? <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 transition-colors ml-1">Login Here</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- FOOTER SECTION --}}
    @include('layouts.footer')
</div>
@endsection