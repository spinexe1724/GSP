@extends('layouts.app')

@section('title', 'Login - Gratama Dealer')

@section('content')
<div class="relative w-full bg-white font-['Plus_Jakarta_Sans']">
    
    {{-- HERO SECTION --}}
    <div class="relative min-h-[650px] md:h-[750px] w-full overflow-hidden pt-28 md:pt-36">
        {{-- Background Image --}}
        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2000" 
             class="absolute inset-0 w-full h-full object-cover" alt="Hero Background">
        
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 container mx-auto px-6 h-full flex flex-col md:flex-row items-center justify-between pb-16">
            
            {{-- Bagian Teks Hero (Kiri) --}}
            <div class="hidden md:block text-white max-w-xl">
                <h1 class="text-6xl font-black leading-tight mb-4 tracking-tighter">
                    Elevate Your <br> <span class="text-red-600">Showroom.</span>
                </h1>
                <p class="text-lg opacity-70 font-medium">
                    Akses dashboard eksklusif Gratama Dealer untuk manajemen unit yang lebih efisien.
                </p>
            </div>

            {{-- FORM LOGIN (Kanan) --}}
            {{-- List merah dihilangkan, border dibuat soft --}}
            <div class="w-full max-w-[400px] bg-white/20 backdrop-blur-2xl p-10 rounded-[40px] shadow-2xl border border-white/10 mt-8 md:mt-0 relative overflow-hidden">
                
                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-3xl font-black text-white tracking-tight">Login.</h2>
                    <p class="text-white/60 text-[10px] font-black uppercase tracking-[0.3em] mt-2">Gratama Showroom Partner</p>
                </div>

                <form action="" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <input type="email" name="email" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="Work Email">
                    </div>
                    
                    <div class="space-y-1">
                        <input type="password" name="password" required 
                               class="w-full bg-white/10 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-700 focus:bg-white outline-none transition-all font-bold text-white focus:text-slate-900 text-sm placeholder:text-white/40" 
                               placeholder="Password">
                    </div>
                    
                    <div class="pt-6">
                        {{-- Button Merah Maroon Tetap Ada --}}
                        <button type="submit" 
                                class="w-full bg-[#800000] hover:bg-red-900 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-red-950/40 transition-all duration-300 transform active:scale-95">
                            Login System
                        </button>
                    </div>
                </form>

                <div class="mt-10 text-center pt-6 border-t border-white/10">
                    <p class="text-white/40 font-bold text-[10px] uppercase tracking-widest">
                        New Partner? <a href="/register" class="text-red-500 hover:text-red-400 transition-colors ml-1">Register Now</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- FOOTER SECTION --}}
    @include('layouts.footer')
</div>
@endsection