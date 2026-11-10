<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin — Niskala')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col lg:flex-row bg-[#F7F7F7] text-[#1E1E1E] font-sans">

    <!-- Sidebar Admin Flat 2D (#CD2E0E & #F79301) -->
    <aside class="w-full lg:w-72 bg-[#CD2E0E] text-white shrink-0 flex flex-col justify-between border-r-2 border-[#D5D5D5]">
        <div class="p-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3 pb-6 border-b border-white/25">
                <div class="w-10 h-10 rounded-xl bg-[#F79301] text-[#1E1E1E] flex items-center justify-center font-extrabold text-xl border-2 border-white">
                    N
                </div>
                <div>
                    <span class="text-xl font-extrabold block leading-none">NISKALA ADMIN</span>
                    <span class="text-[10px] text-[#F79301] font-bold uppercase tracking-widest">Manajemen Bencana & Peta</span>
                </div>
            </a>

            <nav class="mt-6 space-y-2 text-sm font-bold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#F79301] text-[#1E1E1E]' : 'text-white hover:bg-black/15' }}">
                    <span>📊</span> Ringkasan Dashboard
                </a>
                <a href="{{ route('admin.disasters.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.disasters.*') ? 'bg-[#F79301] text-[#1E1E1E]' : 'text-white hover:bg-black/15' }}">
                    <span>📍</span> Lokasi & Info Bencana
                </a>
                <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.campaigns.*') ? 'bg-[#F79301] text-[#1E1E1E]' : 'text-white hover:bg-black/15' }}">
                    <span>🤝</span> Kelola Kampanye
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#F79301] text-[#1E1E1E]' : 'text-white hover:bg-black/15' }}">
                    <span>🏷️</span> Kategori Program
                </a>
                <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.donations.*') ? 'bg-[#F79301] text-[#1E1E1E]' : 'text-white hover:bg-black/15' }}">
                    <span>💳</span> Data & Verifikasi Donasi
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-white/25 space-y-2.5">
            <a href="{{ route('home') }}" class="block w-full text-center py-2.5 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-xs font-extrabold text-[#1E1E1E] transition">
                🌐 Lihat Website Publik
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-xs font-bold text-white transition cursor-pointer">
                    Keluar Sesi Admin
                </button>
            </form>
        </div>
    </aside>

    <!-- Area Konten Utama Admin -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b-2 border-[#D5D5D5] px-6 py-4 flex items-center justify-between">
            <h1 class="text-lg font-extrabold text-[#CD2E0E]">@yield('header', 'Dashboard Admin')</h1>
            <span class="text-xs font-bold px-3 py-1.5 rounded-lg bg-[#D5D5D5]/60 text-[#1E1E1E]">
                Admin: <strong>{{ auth()->user()->name }}</strong>
            </span>
        </header>

        <main class="p-6 sm:p-8 flex-1 space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-[#FFF6E8] border-2 border-[#F79301] text-sm font-bold text-[#1E1E1E]">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-[#FDECE9] border-2 border-[#CD2E0E] text-xs font-bold text-[#CD2E0E] space-y-1">
                    @foreach($errors->all() as $err)
                        <div>• {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>