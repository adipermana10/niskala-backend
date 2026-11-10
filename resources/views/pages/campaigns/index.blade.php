@extends('layouts.app')

@section('title', 'Kampanye Penggalangan Dana — Niskala')

@section('content')
<section class="bg-[#CD2E0E] text-white py-14 border-b-4 border-[#F79301]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="inline-block px-3.5 py-1 rounded-lg bg-[#F79301] text-[#1E1E1E] text-xs font-extrabold tracking-wider uppercase mb-3">
            Gotong Royong Kemanusiaan
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">
            Kampanye Donasi Bencana & Sosial
        </h1>
        <p class="mt-3 text-white/90 max-w-2xl text-base leading-relaxed">
            Setiap donasi yang Anda salurkan menjadi kekuatan nyata bagi saudara-saudara kita untuk bangkit kembali pascabencana.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-7 relative z-20">
    <form action="{{ route('campaigns.index') }}" method="GET" class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        <div class="md:col-span-5">
            <label class="block text-xs font-extrabold text-[#CD2E0E] uppercase tracking-wider mb-1.5">Cari Kampanye</label>
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari judul kampanye atau lokasi..."
                class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]"
            >
        </div>

        <div class="md:col-span-3">
            <label class="block text-xs font-extrabold text-[#CD2E0E] uppercase tracking-wider mb-1.5">Kategori</label>
            <select name="category" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-3.5 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-extrabold text-[#CD2E0E] uppercase tracking-wider mb-1.5">Urutkan</label>
            <select name="sort" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-3.5 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]">
                <option value="latest" @selected(request('sort') === 'latest')>Terbaru</option>
                <option value="urgent" @selected(request('sort') === 'urgent')>Segera Berakhir</option>
                <option value="popular" @selected(request('sort') === 'popular')>Dana Terbanyak</option>
            </select>
        </div>

        <div class="md:col-span-2 flex gap-2">
            <button type="submit" class="w-full bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold py-2.5 px-4 rounded-xl text-sm border-2 border-[#1E1E1E] transition cursor-pointer">
                Cari
            </button>
            @if(request()->anyFilled(['q', 'category', 'sort']))
                <a href="{{ route('campaigns.index') }}" class="px-3.5 py-2.5 rounded-xl border-2 border-[#D5D5D5] text-[#1E1E1E] hover:border-[#CD2E0E] text-sm font-bold">
                    Reset
                </a>
            @endif
        </div>
    </form>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($campaigns->isEmpty())
        <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-12 text-center">
            <h3 class="text-xl font-extrabold text-[#CD2E0E]">Kampanye Tidak Ditemukan</h3>
            <p class="text-sm text-[#1E1E1E]/75 mt-2">Coba gunakan kata kunci pencarian atau pilih kategori yang berbeda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($campaigns as $campaign)
                <article class="flat-card overflow-hidden flex flex-col">
                    <div class="relative h-52 bg-[#D5D5D5] overflow-hidden border-b-2 border-[#D5D5D5]">
                        @if($campaign->thumbnail)
                            <img src="{{ $campaign->thumbnail }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-lg text-xs font-extrabold bg-[#CD2E0E] text-white">
                            {{ $campaign->category->name }}
                        </span>
                        @if($campaign->days_remaining !== null)
                            <span class="absolute bottom-3 right-3 px-3 py-1 rounded-lg text-xs font-extrabold bg-[#1E1E1E] text-[#F79301]">
                                ⏳ {{ $campaign->days_remaining }} hari lagi
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            @if($campaign->disaster)
                                <p class="text-xs font-bold text-[#CD2E0E] mb-1.5">
                                    📍 {{ $campaign->disaster->location }}
                                </p>
                            @endif

                            <h2 class="text-lg font-extrabold text-[#1E1E1E] hover:text-[#CD2E0E] transition line-clamp-2">
                                <a href="{{ route('campaigns.show', $campaign->slug) }}">
                                    {{ $campaign->title }}
                                </a>
                            </h2>

                            <p class="mt-2 text-sm text-[#1E1E1E]/75 line-clamp-2">
                                {{ $campaign->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t-2 border-[#D5D5D5]">
                            <div class="flex justify-between text-xs font-bold mb-1.5">
                                <span>Progres Donasi</span>
                                <span class="text-[#CD2E0E] font-extrabold">{{ $campaign->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-[#D5D5D5] h-3 rounded-full overflow-hidden">
                                <div class="bg-[#F79301] h-full rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                            </div>

                            <div class="flex justify-between items-baseline mt-3">
                                <div>
                                    <span class="text-[11px] font-bold text-[#1E1E1E]/60 uppercase block">Terkumpul</span>
                                    <span class="text-base font-extrabold text-[#CD2E0E]">
                                        Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-bold text-[#1E1E1E]/60 uppercase block">Target</span>
                                    <span class="text-xs font-bold text-[#1E1E1E]">
                                        Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="mt-4 block w-full text-center bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold py-3 rounded-xl text-xs border-2 border-[#1E1E1E] transition">
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $campaigns->links() }}
        </div>
    @endif
</section>
@endsection