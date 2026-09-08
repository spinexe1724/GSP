@section('content')
<div class="relative min-h-screen bg-[#800000]">

    {{-- NAVBAR --}}
    {{-- Jika BUKAN halaman admin, tampilkan Navbar penuh --}}
    @if(!request()->is('admin*'))
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-6 py-6">
        <div class="container mx-auto flex justify-between items-center">
            
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <span class="text-white font-bold text-2xl tracking-tighter" id="nav-logo-text">GSP</span>
            </div>

            {{-- Menu Utama --}}
            <div class="hidden md:flex items-center gap-10">
                <a href="#" class="nav-link text-white hover:opacity-75 font-medium transition active-link">Home</a>
                <a href="#" class="nav-link text-white hover:opacity-75 font-medium transition">Cars</a>
                <a href="#" class="nav-link text-white hover:opacity-75 font-medium transition">Brands</a>
                <a href="#" class="nav-link text-white hover:opacity-75 font-medium transition">Contact</a>
            </div>

            {{-- Button --}}
            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->is_admin)
                        {{-- Jika Admin sedang di Homepage, beri opsi balik ke Panel Admin --}}
                        <a href="{{ route('admin.dashboard') }}" id="nav-login-btn" class="bg-white text-gray-900 px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-100 transition">
                            Panel Admin
                        </a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" id="nav-login-btn" class="bg-white text-gray-900 px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-100 transition">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" id="nav-login-btn" class="bg-white text-gray-900 px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-100 transition">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </nav>
    @endif


{{-- SCRIPT SCROLL DENGAN PENGECEKAN --}}
<script>
    window.onscroll = function() {
        const nav = document.getElementById('navbar');
        if (!nav) return; // Mencegah error JS jika navbar tidak ada

        const logoText = document.getElementById('nav-logo-text');
        const navLinks = nav.querySelectorAll('.nav-link');

        if (window.pageYOffset > 50) {
            nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'py-4');
            nav.classList.remove('py-6');
            if(logoText) logoText.classList.replace('text-white', 'text-gray-900');
            navLinks.forEach(link => {
                link.classList.replace('text-white', 'text-gray-700');
            });
        } else {
            nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'py-4');
            nav.classList.add('py-6');
            if(logoText) logoText.classList.replace('text-gray-900', 'text-white');
            navLinks.forEach(link => {
                link.classList.replace('text-gray-700', 'text-white');
            });
        }
    };
</script>