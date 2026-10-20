@section('content')
<div class="relative min-h-screen bg-[#800000]">

    {{-- NAVBAR --}}
    {{-- Jika BUKAN halaman admin, tampilkan Navbar penuh --}}
    @if(!request()->is('admin*'))
    <nav id="navbar" data-solid="{{ request()->routeIs('showrooms.settings.edit_profile') ? 'true' : 'false' }}" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-6 {{ request()->routeIs('showrooms.settings.edit_profile') ? 'bg-white/95 backdrop-blur-md shadow-sm py-4' : 'py-6' }}">
        <div class="container mx-auto flex justify-between items-center">
            
            {{-- Brand wordmark --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-9 w-9 shrink-0 rounded-lg object-contain shadow-sm sm:h-10 sm:w-10">
                <span class="{{ request()->routeIs('showrooms.settings.edit_profile') ? 'text-gray-900' : 'text-white' }} flex flex-col text-base font-black uppercase leading-[0.9] tracking-[0.08em] sm:text-lg" id="nav-logo-text">
                    <span>Gratama</span>
                    <span>Finance</span>
                </span>
            </div>

            {{-- Menu Utama --}}
           
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
                    <a href="{{ request()->routeIs('portal.index') ? route('showrooms.login') : route('login') }}" id="nav-login-btn" class="bg-white text-gray-900 px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-100 transition">
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
        if (!nav || nav.dataset.solid === 'true') return; // Keep the settings navbar readable at every scroll position.

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