<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Niskala — Informasi Bencana Alam & Penggalangan Dana Sosial')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7F7F7] text-[#1E1E1E] font-sans antialiased selection:bg-[#CD2E0E] selection:text-white min-h-screen flex flex-col">

    <!-- Top Strip Identitas 2D -->
    <div class="h-2 w-full bg-[#CD2E0E] flex">
        <div class="w-1/3 h-full bg-[#CD2E0E]"></div>
        <div class="w-1/3 h-full bg-[#F79301]"></div>
        <div class="w-1/3 h-full bg-[#CD2E0E]"></div>
    </div>

    <!-- Navbar Flat 2D Modern -->
    <header class="sticky top-0 z-50 bg-white border-b-2 border-[#D5D5D5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Identity -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-[#CD2E0E] text-white flex items-center justify-center font-extrabold text-xl border-2 border-[#1E1E1E] group-hover:bg-[#F79301] group-hover:text-[#1E1E1E] transition">
                    N
                </div>
                <div>
                    <span class="text-2xl font-extrabold tracking-tight text-[#CD2E0E] block leading-none">
                        NISKALA
                    </span>
                    <span class="text-[10px] font-bold text-[#1E1E1E]/70 tracking-widest uppercase mt-1 block">
                        Tanggap Bencana & Donasi
                    </span>
                </div>
            </a>

            <!-- Navigasi Utama -->
            <nav class="hidden md:flex items-center gap-2 bg-[#D5D5D5]/50 p-1.5 rounded-xl border-2 border-[#D5D5D5]">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition {{ request()->routeIs('home') ? 'bg-[#CD2E0E] text-white' : 'text-[#1E1E1E] hover:bg-[#D5D5D5]' }}">
                    Beranda
                </a>
                <a href="{{ route('disasters.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition {{ request()->routeIs('disasters.*') ? 'bg-[#CD2E0E] text-white' : 'text-[#1E1E1E] hover:bg-[#D5D5D5]' }}">
                    Peta & Info Bencana
                </a>
                <a href="{{ route('campaigns.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition {{ request()->routeIs('campaigns.*') ? 'bg-[#CD2E0E] text-white' : 'text-[#1E1E1E] hover:bg-[#D5D5D5]' }}">
                    Kampanye Donasi
                </a>
            </nav>

            <!-- Tombol Aksi & Akun -->
            <div class="flex items-center gap-2.5">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-[#CD2E0E] hover:bg-[#A62309] text-white text-xs font-extrabold transition">
                            Panel Admin
                        </a>
                    @endif

                    <a href="{{ route('user.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] text-xs font-extrabold transition">
                        Akun Saya
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 rounded-xl border-2 border-[#D5D5D5] bg-white hover:border-[#CD2E0E] hover:text-[#CD2E0E] text-xs font-bold text-[#1E1E1E] transition cursor-pointer">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl border-2 border-[#D5D5D5] hover:border-[#CD2E0E] text-sm font-bold text-[#1E1E1E] transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] text-sm font-extrabold border-2 border-[#1E1E1E] transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>

        <!-- Navigasi Mobile -->
        <div class="md:hidden border-t-2 border-[#D5D5D5] bg-white px-4 py-2.5 flex justify-around text-xs font-bold">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-[#CD2E0E] font-extrabold underline' : 'text-[#1E1E1E]' }}">Beranda</a>
            <a href="{{ route('disasters.index') }}" class="{{ request()->routeIs('disasters.*') ? 'text-[#CD2E0E] font-extrabold underline' : 'text-[#1E1E1E]' }}">Peta Bencana</a>
            <a href="{{ route('campaigns.index') }}" class="{{ request()->routeIs('campaigns.*') ? 'text-[#CD2E0E] font-extrabold underline' : 'text-[#1E1E1E]' }}">Kampanye Donasi</a>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer Flat 2D -->
    <footer class="bg-[#CD2E0E] text-white mt-20 border-t-4 border-[#F79301]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#F79301] text-[#1E1E1E] font-extrabold text-xl flex items-center justify-center border-2 border-white">
                            N
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-white">NISKALA</span>
                    </div>
                    <p class="text-sm text-white/90 leading-relaxed max-w-md">
                        Platform informasi bencana alam interaktif dengan pemetaan radius wilayah terdampak serta penggalangan dana sosial yang transparan dan humanis.
                    </p>
                </div>

                <div class="md:col-span-3 space-y-3">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-[#F79301]">Navigasi Cepat</h3>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-[#F79301] transition">Beranda Utama</a></li>
                        <li><a href="{{ route('disasters.index') }}" class="hover:text-[#F79301] transition">Peta & Informasi Bencana</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-[#F79301] transition">Program Donasi Kemanusiaan</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-3">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-[#F79301]">Catatan Data Geospasial</h3>
                    <p class="text-xs text-white/90 leading-relaxed">
                        Lingkaran radius bencana pada peta adalah visualisasi estimasi jarak dari titik pusat berdasarkan input data admin, bukan batas kerusakan mutlak di lapangan.
                    </p>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-white/25 flex flex-col sm:flex-row items-center justify-between text-xs text-white/90">
                <p>&copy; {{ date('Y') }} Niskala Indonesia. Seluruh hak cipta dilindungi.</p>
                <p class="mt-2 sm:mt-0 font-bold text-[#F79301]">Merah #CD2E0E • Abu-abu #D5D5D5 • Oranye #F79301</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>