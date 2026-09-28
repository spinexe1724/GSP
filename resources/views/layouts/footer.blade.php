<footer class="bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-6">

        <div class="flex flex-col md:flex-row items-center justify-between gap-4">

            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#800000] rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-sm">G</span>
                </div>

                <div>
                    <div class="text-sm font-bold text-gray-900">
                        GSP
                    </div>
                    <div class="text-[11px] text-gray-400">
                        Gratama Showroom Partners
                    </div>
                </div>
            </div>

            {{-- Navigasi --}}
            <nav class="flex items-center gap-5 text-xs font-medium text-gray-500">
                <a href="/" class="hover:text-[#800000] transition">
                    Beranda
                </a>

                <a href="{{ route('cars.index') }}" class="hover:text-[#800000] transition">
                    Mobil
                </a>

                <a href="#" class="hover:text-[#800000] transition">
                    Merek
                </a>

                <a href="#" class="hover:text-[#800000] transition">
                    Kontak
                </a>
            </nav>

            {{-- Copyright --}}
            <div class="text-[11px] text-gray-400 text-center md:text-right">
                © 2026 GSP
            </div>

        </div>

    </div>
</footer>