<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Showroom - Gratama</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-gray-800">Portal Showroom</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan login untuk mengelola unit Anda</p>
        </div>

        <!-- Alert Error Jika Login Gagal -->
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('showrooms.login.post') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor KTP Pemilik</label>
                <input type="text" name="clprnoktp" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#800000] focus:border-[#800000] focus:outline-none transition-colors" 
                       required 
                       placeholder="Masukkan No KTP">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#800000] focus:border-[#800000] focus:outline-none transition-colors" 
                       required 
                       placeholder="Password Anda">
                <p class="text-xs text-gray-400 mt-2">*Gunakan Nomor KTP sebagai password untuk login pertama kali.</p>
            </div>

            <button type="submit" class="w-full bg-[#800000] hover:bg-red-900 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                Masuk ke Dasbor
            </button>
        </form>
    </div>

</body>
</html>