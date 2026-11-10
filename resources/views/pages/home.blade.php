@extends('layouts.app')

@section('title', 'Niskala — Peta Informasi Bencana & Penggalangan Dana Sosial')

@section('content')
<!-- 1. HERO SECTION FLAT 2D DENGAN ILUSTRASI VEKTOR -->
<section class="bg-[#CD2E0E] text-white border-b-4 border-[#F79301] py-16 lg:py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Teks Utama -->
            <div class="lg:col-span-7 space-y-6 gsap-fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#F79301] text-[#1E1E1E] text-xs font-extrabold uppercase tracking-wider">
                    <span>📡 Pantauan Geospasial & Solidaritas Sosial</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Tanggap Informasi Bencana, <span class="text-[#F79301] underline decoration-4">Nyata</span> dalam Aksi Kemanusiaan.
                </h1>

                <p class="text-base sm:text-lg text-white/90 leading-relaxed max-w-2xl">
                    Pantau titik pusat bencana alam beserta estimasi radius wilayah terdampak secara interaktif, dan salurkan bantuan terbaik Anda bagi para penyintas di seluruh Nusantara.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('campaigns.index') }}" class="px-7 py-4 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold text-sm border-2 border-[#1E1E1E] transition hover-wobble">
                        Salurkan Donasi Sekarang
                    </a>
                    <a href="#peta-bencana-interaktif" class="px-7 py-4 rounded-xl bg-white hover:bg-[#D5D5D5] text-[#CD2E0E] font-extrabold text-sm border-2 border-[#1E1E1E] transition">
                        Jelajahi Peta Radius Bencana
                    </a>
                </div>
            </div>

            <!-- Ilustrasi Flat 2D Bertema Alam, Bencana & Kepedulian Sosial -->
            <div class="lg:col-span-5 gsap-fade-up">
                <div class="bg-white text-[#1E1E1E] rounded-2xl p-6 border-4 border-[#D5D5D5] relative">
                    <!-- Ilustrasi SVG Flat 2D -->
                    <div class="bg-[#D5D5D5]/35 rounded-xl p-4 mb-5 flex items-center justify-center animate-float-2d">
                        <svg viewBox="0 0 360 190" class="w-full h-44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Latar Langit & Matahari Oranye Flat 2D -->
                            <rect width="360" height="190" rx="14" fill="#F7F7F7"/>
                            <circle cx="290" cy="52" r="26" fill="#F79301"/>
                            <!-- Gunung & Alam Flat 2D -->
                            <path d="M20 165L105 55L185 165H20Z" fill="#D5D5D5"/>
                            <path d="M120 165L210 42L305 165H120Z" fill="#CD2E0E"/>
                            <!-- Lingkaran Radar / Radius Bencana 2D -->
                            <circle cx="210" cy="42" r="34" fill="#CD2E0E" fill-opacity="0.22" stroke="#CD2E0E" stroke-width="2" stroke-dasharray="4 4"/>
                            <circle cx="210" cy="42" r="7" fill="#F79301" stroke="#FFFFFF" stroke-width="2"/>
                            <!-- Posko & Kotak Bantuan Donasi -->
                            <rect x="48" y="118" width="68" height="47" rx="4" fill="#F79301" stroke="#1E1E1E" stroke-width="3"/>
                            <path d="M42 120L82 92L122 120H42Z" fill="#CD2E0E" stroke="#1E1E1E" stroke-width="3"/>
                            <rect x="74" y="132" width="16" height="16" rx="2" fill="#FFFFFF"/>
                            <path d="M82 135V145M77 140H87" stroke="#CD2E0E" stroke-width="2.5" stroke-linecap="round"/>
                            <!-- Garis Tanah -->
                            <line x1="15" y1="165" x2="345" y2="165" stroke="#1E1E1E" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <!-- Statistik Ringkas 2D -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3.5 rounded-xl bg-[#D5D5D5]/40 border-2 border-[#D5D5D5]">
                            <span class="text-[11px] font-bold uppercase text-[#1E1E1E]/70 block">Total Donasi Terkumpul</span>
                            <span class="text-base sm:text-lg font-extrabold text-[#CD2E0E] mt-0.5 block">
                                Rp {{ number_format($stats['total_donations'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-[#D5D5D5]/40 border-2 border-[#D5D5D5]">
                            <span class="text-[11px] font-bold uppercase text-[#1E1E1E]/70 block">Titik Bencana Terpantau</span>
                            <span class="text-base sm:text-lg font-extrabold text-[#CD2E0E] mt-0.5 block">
                                {{ $stats['total_disasters'] ?? 0 }} Lokasi Radius
                            </span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-[#D5D5D5]/40 border-2 border-[#D5D5D5]">
                            <span class="text-[11px] font-bold uppercase text-[#1E1E1E]/70 block">Kampanye Aktif</span>
                            <span class="text-base sm:text-lg font-extrabold text-[#1E1E1E] mt-0.5 block">
                                {{ $stats['active_campaigns'] ?? 0 }} Program
                            </span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-[#F79301]/25 border-2 border-[#F79301]">
                            <span class="text-[11px] font-bold uppercase text-[#1E1E1E] block">Partisipasi Donatur</span>
                            <span class="text-base sm:text-lg font-extrabold text-[#CD2E0E] mt-0.5 block">
                                {{ $stats['total_donors'] ?? 0 }} Sahabat
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. PETA INTERAKTIF LOKASI BENCANA & DETEKSI LOKASI PENGGUNA -->
<section id="peta-bencana-interaktif" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 sm:p-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b-2 border-[#D5D5D5]">
            <div>
                <span class="inline-block px-3 py-1 rounded-lg bg-[#CD2E0E] text-white text-xs font-extrabold uppercase tracking-wider mb-2">
                    Peta Geospasial OpenStreetMap
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1E1E]">
                    Peta Titik Pusat & Radius Dampak Bencana
                </h2>
                <p class="text-sm text-[#1E1E1E]/75 mt-1">
                    Klik marker jarum merah untuk melihat detail bencana, radius dampak (km), dan akses laporan lengkapnya.
                </p>
            </div>

            <!-- Tombol Deteksi Lokasi Saya -->
            <div class="flex flex-wrap items-center gap-3">
                <button
                    type="button"
                    id="btnDetectHomeLocation"
                    class="px-5 py-3 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold text-xs border-2 border-[#1E1E1E] transition cursor-pointer flex items-center gap-2 hover-wobble"
                >
                    <span>📍</span> Deteksi Lokasi Saya
                </button>
                <a href="{{ route('disasters.index') }}" class="px-4 py-3 rounded-xl bg-[#D5D5D5] hover:bg-[#CD2E0E] hover:text-white text-[#1E1E1E] font-bold text-xs transition">
                    Filter & Cari Bencana &rarr;
                </a>
            </div>
        </div>

        <!-- Notifikasi Status Geolocation -->
        <div id="homeGeoStatus" class="hidden mt-4 p-3.5 rounded-xl border-2 text-xs font-bold"></div>

        <!-- Kontainer Peta Leaflet -->
        <div class="mt-5 rounded-2xl overflow-hidden border-2 border-[#D5D5D5]">
            <div id="homeDisasterMap" class="w-full h-[440px] sm:h-[500px]"></div>
        </div>

        <!-- Legenda Peta & Penjelasan Estimasi Radius -->
        <div class="mt-5 bg-[#D5D5D5]/40 border-2 border-[#D5D5D5] rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
            <div class="flex flex-wrap items-center gap-6 font-bold">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-[#CD2E0E] border-2 border-white inline-block"></span>
                    <span>Jarum Merah: Titik Pusat Bencana</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-[#CD2E0E]/25 border-2 border-[#CD2E0E] inline-block"></span>
                    <span>Lingkaran Merah Pudar: Estimasi Radius Wilayah Terdampak (km)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-[#F79301] border-2 border-[#1E1E1E] inline-block"></span>
                    <span>Titik Oranye: Posisi Lokasi Anda</span>
                </div>
            </div>
            <p class="text-[11px] text-[#1E1E1E]/80 font-medium">
                *Catatan: Lingkaran radius adalah visualisasi estimasi jarak dari titik pusat berdasarkan data admin, bukan batas kerusakan aktual.
            </p>
        </div>
    </div>
</section>

<!-- 3. KATEGORI PENANGANAN BENCANA & SOSIAL -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('campaigns.index', ['category' => $category->slug]) }}" class="flat-card p-5 flex items-center justify-between group">
                <div>
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-[#CD2E0E] block">
                        Kategori Program
                    </span>
                    <h3 class="text-base font-extrabold text-[#1E1E1E] group-hover:text-[#CD2E0E] mt-0.5 transition">
                        {{ $category->name }}
                    </h3>
                    <p class="text-xs font-semibold text-[#1E1E1E]/70 mt-1">
                        {{ $category->campaigns_count ?? 0 }} Kampanye Bantuan
                    </p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-[#F79301] text-[#1E1E1E] flex items-center justify-center font-extrabold text-sm border-2 border-[#1E1E1E]">
                    &rarr;
                </span>
            </a>
        @endforeach
    </div>
</section>

<!-- 4. LAPORAN BENCANA ALAM TERKINI -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <span class="inline-block px-3 py-1 rounded-lg bg-[#CD2E0E] text-white text-xs font-extrabold uppercase tracking-wider mb-2">
                Update Situasi
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1E1E]">
                Informasi Bencana Alam Terkini
            </h2>
        </div>
        <a href="{{ route('disasters.index') }}" class="px-5 py-2.5 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-xs font-extrabold text-[#1E1E1E] border-2 border-[#1E1E1E] transition">
            Lihat Semua Laporan &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
        @forelse($latestDisasters as $disaster)
            <article class="flat-card overflow-hidden flex flex-col">
                <div class="relative h-52 bg-[#D5D5D5] overflow-hidden border-b-2 border-[#D5D5D5]">
                    @if($disaster->thumbnail)
                        <img src="{{ $disaster->thumbnail }}" alt="{{ $disaster->title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-lg text-xs font-extrabold bg-[#CD2E0E] text-white">
                            {{ $disaster->category->name }}
                        </span>
                        <span class="px-3 py-1 rounded-lg text-xs font-extrabold bg-[#F79301] text-[#1E1E1E]">
                            Radius {{ number_format($disaster->impact_radius_km, 1) }} KM
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-bold text-[#CD2E0E] mb-1.5">
                            📍 {{ $disaster->location }} • {{ $disaster->occurred_at->translatedFormat('d M Y') }}
                        </p>
                        <h3 class="text-lg font-extrabold text-[#1E1E1E] hover:text-[#CD2E0E] transition line-clamp-2">
                            <a href="{{ route('disasters.show', $disaster->slug) }}">
                                {{ $disaster->title }}
                            </a>
                        </h3>
                        <p class="mt-2.5 text-sm text-[#1E1E1E]/80 line-clamp-3 leading-relaxed">
                            {{ $disaster->summary }}
                        </p>
                    </div>

                    <div class="mt-5 pt-4 border-t-2 border-[#D5D5D5] flex items-center justify-between">
                        <span class="text-xs font-bold text-[#1E1E1E]/70">{{ $disaster->status_label }}</span>
                        <a href="{{ route('disasters.show', $disaster->slug) }}" class="text-xs font-extrabold text-[#CD2E0E] hover:underline">
                            Detail & Peta Radius &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-3 bg-white border-2 border-[#D5D5D5] rounded-2xl p-8 text-center text-sm font-bold">
                Belum ada laporan bencana terbaru.
            </div>
        @endforelse
    </div>
</section>

<!-- 5. KAMPANYE DONASI PRIORITAS -->
<section class="bg-[#D5D5D5]/45 border-y-2 border-[#D5D5D5] py-16 mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="inline-block px-3 py-1 rounded-lg bg-[#F79301] text-[#1E1E1E] text-xs font-extrabold uppercase tracking-wider mb-2">
                    Aksi Kemanusiaan
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1E1E]">
                    Kampanye Penggalangan Dana
                </h2>
            </div>
            <a href="{{ route('campaigns.index') }}" class="px-5 py-2.5 rounded-xl bg-[#CD2E0E] hover:bg-[#A62309] text-xs font-extrabold text-white transition">
                Jelajahi Semua Kampanye &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
            @forelse($featuredCampaigns as $campaign)
                <article class="flat-card overflow-hidden flex flex-col">
                    <div class="relative h-52 bg-[#D5D5D5] overflow-hidden border-b-2 border-[#D5D5D5]">
                        @if($campaign->thumbnail)
                            <img src="{{ $campaign->thumbnail }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-lg text-xs font-extrabold bg-[#CD2E0E] text-white">
                            {{ $campaign->category->name }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            @if($campaign->disaster)
                                <p class="text-xs font-bold text-[#CD2E0E] mb-1">
                                    📍 {{ $campaign->disaster->location }}
                                </p>
                            @endif
                            <h3 class="text-lg font-extrabold text-[#1E1E1E] hover:text-[#CD2E0E] line-clamp-2">
                                <a href="{{ route('campaigns.show', $campaign->slug) }}">
                                    {{ $campaign->title }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-[#1E1E1E]/75 line-clamp-2">
                                {{ $campaign->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t-2 border-[#D5D5D5]">
                            <div class="flex justify-between text-xs font-bold mb-1.5">
                                <span>Terkumpul</span>
                                <span class="text-[#CD2E0E] font-extrabold">{{ $campaign->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-[#D5D5D5] h-3 rounded-full overflow-hidden">
                                <div class="bg-[#F79301] h-full rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                            </div>

                            <div class="flex justify-between items-baseline mt-3">
                                <div>
                                    <span class="text-[11px] font-bold text-[#1E1E1E]/60 uppercase block">Dana Terkumpul</span>
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
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 bg-white border-2 border-[#D5D5D5] rounded-2xl p-8 text-center text-sm font-bold">
                    Belum ada kampanye aktif.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapContainer = document.getElementById('homeDisasterMap');
    if (!mapContainer || typeof window.L === 'undefined') return;

    const disasters = @json($mapDisasters);
    const map = L.map('homeDisasterMap').setView([-2.5489, 118.0149], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const bounds = [];

    disasters.forEach((item) => {
        if (!item.latitude || !item.longitude) return;

        const center = [item.latitude, item.longitude];
        bounds.push(center);

        // Marker Jarum Merah Titik Pusat Bencana (#CD2E0E)
        const marker = L.marker(center, {
            icon: window.createDisasterMarkerIcon()
        }).addTo(map);

        // Lingkaran Radius Dampak Merah Transparan (km -> meter)
        const radiusMeters = (parseFloat(item.impact_radius_km) || 5) * 1000;
        L.circle(center, {
            color: '#CD2E0E',
            weight: 2,
            fillColor: '#CD2E0E',
            fillOpacity: 0.22,
            radius: radiusMeters
        }).addTo(map);

        marker.bindPopup(`
            <div style="min-width:220px;padding:4px;">
                <span style="display:inline-block;padding:2px 8px;border-radius:6px;background:#CD2E0E;color:#fff;font-size:10px;font-weight:800;text-transform:uppercase;">
                    ${item.category}
                </span>
                <h3 style="margin:6px 0 2px;font-size:14px;font-weight:800;color:#1E1E1E;">${item.title}</h3>
                <p style="margin:0;font-size:11px;color:#CD2E0E;font-weight:700;">📍 ${item.location}</p>
                <p style="margin:4px 0;font-size:11px;color:#1E1E1E;">
                    <strong>Status:</strong> ${item.status_label}<br>
                    <strong>Estimasi Radius:</strong> ${item.impact_radius_km} KM
                </p>
                <a href="${item.url}" style="display:inline-block;margin-top:6px;padding:6px 10px;background:#F79301;color:#1E1E1E;font-weight:800;font-size:11px;border-radius:6px;text-decoration:none;border:1px solid #1E1E1E;">
                    Lihat Detail & Peta &rarr;
                </a>
            </div>
        `);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [45, 45], maxZoom: 10 });
    }

    const detectBtn = document.getElementById('btnDetectHomeLocation');
    if (detectBtn) {
        detectBtn.addEventListener('click', function () {
            window.detectUserLocationOnMap(map, 'homeGeoStatus');
        });
    }
});
</script>
@endpush