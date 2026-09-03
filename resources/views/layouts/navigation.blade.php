@section('content')
<div class="relative min-h-screen bg-white">

    {{-- NAVBAR --}}
    @if(!request()->is('admin*') && (!auth()->check() || !auth()->user()->is_admin))
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-6 py-6">
        <div class="container mx-auto flex justify-between items-center">
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <span class="text-black font-bold text-2xl tracking-tighter" id="nav-logo-text">GSP</span>
            </div>

            {{-- Menu Utama --}}
            <div class="hidden md:flex items-center gap-10">
                <a href="#" class="text-black hover:opacity-75 font-medium transition active-link">Home</a>
                <a href="#" class="text-black hover:opacity-75 font-medium transition">Cars</a>
                <a href="#" class="text-black hover:opacity-75 font-medium transition">Brands</a>
                <a href="#" class="text-black hover:opacity-75 font-medium transition">Contact</a>
            </div>

            {{-- Button --}}
            <div class="flex items-center gap-4">
    
    <a href="{{ route('login') }}" id="nav-login-btn"  class="bg-Red text-black px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-100 transition">
        Login
    </a>
    @endif
</div>
        </div>
    </nav>

    {{-- 1. HERO SECTION --}}
    {{-- SCRIPT UNTUK EFEK SCROLL --}}
    <script>
        window.onscroll = function() {
            const nav = document.getElementById('navbar');
            const logoText = document.getElementById('nav-logo-text');
            const navLinks = nav.querySelectorAll('a:not(.bg-white)');

            if (window.pageYOffset > 50) {
                // Saat di-scroll ke bawah
                nav.classList.add('bg-white/80', 'backdrop-blur-md', 'shadow-sm', 'py-4');
                nav.classList.remove('py-6');
                logoText.classList.replace('text-white', 'text-gray-900');
                navLinks.forEach(link => {
                    link.classList.replace('text-white', 'text-gray-700');
                });
            } else {
                // Saat kembali ke atas (Hero)
                nav.classList.remove('bg-white/80', 'backdrop-blur-md', 'shadow-sm', 'py-4');
                nav.classList.add('py-6');
                logoText.classList.replace('text-gray-900', 'text-white');
                navLinks.forEach(link => {
                    link.classList.replace('text-gray-700', 'text-white');
                });
            }
        };
    </script>