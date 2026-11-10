@extends('layouts.app')

@section('title', $disaster->title . ' — Niskala')

@section('content')
<article class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="text-xs font-bold text-[#1E1E1E]/70 mb-5 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-[#CD2E0E]">Beranda</a>
        <span>/</span>
        <a href="{{ route('disasters.index') }}" class="hover:text-[#CD2E0E]">Peta & Informasi Bencana</a>
        <span>/</span>
        <span class="text-[#CD2E0E] truncate">{{ $disaster->title }}</span>
    </nav>

    <!-- Header Detail Bencana Flat 2D -->
    <header class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 md:p-8 mb-8">
        <div class="flex flex-wrap items-center gap-2.5 mb-4">
            <span class="px-3.5 py-1 rounded-lg text-xs font-extrabold bg-[#CD2E0E] text-white">
                {{ $disaster->category->name }}
            </span>
            <span class="px-3.5 py-1 rounded-lg text-xs font-extrabold bg-[#F79301] text-[#1E1E1E]">
                {{ $disaster->status_label }}
            </span>
            <span class="px-3.5 py-1 rounded-lg text-xs font-extrabold bg-[#D5D5D5] text-[#1E1E1E]">
                🎯 Radius Dampak: {{ number_format($disaster->impact_radius_km, 2) }} KM
            </span>
            <span class="text-xs font-bold text-[#1E1E1E]/70 ml-auto">
                Waktu Kejadian: <strong class="text-[#1E1E1E]">{{ $disaster->occurred_at->translatedFormat('d F Y, H:i') }} WIB</strong>
            </span>
        </div>

        <h1 class="text-2xl md:text-4xl font-extrabold text-[#1E1E1E] leading-snug">
            {{ $disaster->title }}
        </h1>

        <div class="mt-4 pt-4 border-t-2 border-[#D5D5D5] grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-bold">
            <div>
                <span class="text-[#1E1E1E]/60 uppercase block">Lokasi Kejadian</span>
                <span class="text-sm font-extrabold text-[#CD2E0E]">📍 {{ $disaster->location }}</span>
            </div>
            <div>
                <span class="text-[#1E1E1E]/60 uppercase block">Titik Koordinat Pusat</span>
                <span class="text-sm font-mono font-extrabold text-[#1E1E1E]">{{ number_format($disaster->latitude, 5) }}, {{ number_format($disaster->longitude, 5) }}</span>
            </div>
            <div>
                <span class="text-[#1E1E1E]/60 uppercase block">Estimasi Radius Terdampak</span>
                <span class="text-sm font-extrabold text-[#F79301] bg-[#1E1E1E] px-2.5 py-0.5 rounded-md inline-block mt-0.5">
                    {{ number_format($disaster->impact_radius_km, 2) }} Kilometer
                </span>
            </div>
        </div>
    </header>

    <!-- PETA INTERAKTIF LOKASI & RADIUS DAMPAK BENCANA -->
    <section class="bg-white border-2 border-[#CD2E0E] rounded-2xl p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#CD2E0E] block">
                    Visualisasi Geospasial Bencana
                </span>
                <h2 class="text-xl font-extrabold text-[#1E1E1E]">
                    Peta Titik Pusat & Radius Dampak ({{ number_format($disaster->impact_radius_km, 1) }} KM)
                </h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    id="btnFocusDisasterCenter"
                    class="px-4 py-2 rounded-xl bg-[#CD2E0E] hover:bg-[#A62309] text-white font-extrabold text-xs transition cursor-pointer"
                >
                    🎯 Fokus Titik Bencana
                </button>
                <button
                    type="button"
                    id="btnDetectDetailLocation"
                    class="px-4 py-2 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold text-xs border-2 border-[#1E1E1E] transition cursor-pointer"
                >
                    📍 Deteksi Lokasi Saya
                </button>
            </div>
        </div>

        <div id="detailGeoStatus" class="hidden mb-4 p-3 rounded-xl border-2 text-xs font-bold"></div>

        <div class="rounded-xl overflow-hidden border-2 border-[#D5D5D5]">
            <div id="detailDisasterMap" class="w-full h-[420px]"></div>
        </div>

        <!-- Legenda & Disclaimer Resmi -->
        <div class="mt-4 bg-[#D5D5D5]/45 border-2 border-[#D5D5D5] rounded-xl p-4 space-y-2">
            <div class="flex flex-wrap items-center gap-6 text-xs font-extrabold">
                <span class="flex items-center gap-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-[#CD2E0E] inline-block"></span>
                    Marker Merah: Titik Pusat Bencana ({{ $disaster->location }})
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-[#CD2E0E]/30 border-2 border-[#CD2E0E] inline-block"></span>
                    Lingkaran Merah Transparan: Radius Wilayah Terdampak ({{ number_format($disaster->impact_radius_km, 2) }} KM)
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-[#F79301] border-2 border-[#1E1E1E] inline-block"></span>
                    Marker Oranye: Posisi Lokasi Pengguna
                </span>
            </div>
            <p class="text-xs text-[#1E1E1E]/85 leading-relaxed border-t border-[#D5D5D5] pt-2">
                <strong>Catatan Penting:</strong> Radius merupakan visualisasi jarak estimasi ({{ number_format($disaster->impact_radius_km, 2) }} km) dari titik pusat berdasarkan data yang dimasukkan admin, bukan jaminan batas kerusakan aktual. Untuk batas dampak yang akurat, gunakan data resmi instansi terkait (BNPB/BMKG) atau hasil survei lapangan.
            </p>
        </div>
    </section>

    <!-- Konten Detail & Sidebar Kampanye -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-6">
            @if($disaster->thumbnail)
                <div class="rounded-2xl overflow-hidden border-2 border-[#D5D5D5] max-h-[400px]">
                    <img src="{{ $disaster->thumbnail }}" alt="{{ $disaster->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="bg-[#FFF6E8] border-l-4 border-[#F79301] p-5 rounded-r-xl">
                <h2 class="text-xs font-extrabold uppercase tracking-wider text-[#CD2E0E] mb-1">
                    Ringkasan Kondisi & Kebutuhan Mendesak
                </h2>
                <p class="text-sm font-medium text-[#1E1E1E] leading-relaxed">{{ $disaster->summary }}</p>
            </div>

            <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 md:p-8 text-[#1E1E1E] leading-relaxed space-y-4">
                <h3 class="text-lg font-extrabold text-[#CD2E0E]">Deskripsi Kondisi & Informasi Penanganan Lapangan</h3>
                <div class="text-sm space-y-3">
                    {!! nl2br(e($disaster->content)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar Kampanye Donasi Terkait -->
        <aside class="lg:col-span-4 space-y-6">
            <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6">
                <h3 class="text-base font-extrabold text-[#CD2E0E] mb-1">
                    Kampanye Bantuan Terkait
                </h3>
                <p class="text-xs text-[#1E1E1E]/75 mb-4">
                    Salurkan donasi untuk membantu warga di sekitar radius bencana ini:
                </p>

                @forelse($disaster->campaigns as $campaign)
                    <div class="bg-[#F7F7F7] border-2 border-[#D5D5D5] rounded-xl p-4 mb-3 last:mb-0">
                        <h4 class="text-sm font-extrabold text-[#1E1E1E] line-clamp-2">
                            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="hover:text-[#CD2E0E]">
                                {{ $campaign->title }}
                            </a>
                        </h4>

                        <div class="mt-3">
                            <div class="w-full bg-[#D5D5D5] h-2.5 rounded-full overflow-hidden">
                                <div class="bg-[#F79301] h-full rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs mt-1.5 font-bold">
                                <span class="text-[#CD2E0E]">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                <span>{{ $campaign->progress_percentage }}%</span>
                            </div>
                        </div>

                        <a href="{{ route('campaigns.show', $campaign->slug) }}" class="mt-3 block w-full text-center bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] text-xs font-extrabold py-2.5 rounded-lg border-2 border-[#1E1E1E] transition">
                            Donasi Sekarang
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-[#1E1E1E]/70 italic">Belum ada kampanye spesifik untuk laporan ini.</p>
                    <a href="{{ route('campaigns.index') }}" class="mt-3 inline-block text-xs font-extrabold text-[#CD2E0E] underline">
                        Lihat Kampanye Lainnya &rarr;
                    </a>
                @endforelse
            </div>
        </aside>
    </div>
</article>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('detailDisasterMap');
    if (!mapEl || typeof window.L === 'undefined') return;

    const mainLat = {{ (float) $disaster->latitude }};
    const mainLng = {{ (float) $disaster->longitude }};
    const mainRadiusKm = {{ (float) $disaster->impact_radius_km }};
    const otherDisasters = @json($otherDisasters);

    const map = L.map('detailDisasterMap').setView([mainLat, mainLng], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Marker Utama & Lingkaran Radius Bencana Ini
    const mainMarker = L.marker([mainLat, mainLng], {
        icon: window.createDisasterMarkerIcon()
    }).addTo(map);

    const mainCircle = L.circle([mainLat, mainLng], {
        color: '#CD2E0E',
        weight: 3,
        fillColor: '#CD2E0E',
        fillOpacity: 0.25,
        radius: mainRadiusKm * 1000
    }).addTo(map);

    mainMarker.bindPopup(`
        <div style="min-width:220px;padding:4px;">
            <span style="display:inline-block;padding:2px 8px;border-radius:6px;background:#CD2E0E;color:#fff;font-size:10px;font-weight:800;">
                TITIK PUSAT BENCANA
            </span>
            <h3 style="margin:6px 0 2px;font-size:14px;font-weight:800;color:#1E1E1E;">{{ addslashes($disaster->title) }}</h3>
            <p style="margin:0;font-size:11px;color:#CD2E0E;font-weight:700;">📍 {{ addslashes($disaster->location) }}</p>
            <p style="margin:4px 0 0;font-size:11px;color:#1E1E1E;">
                <strong>Radius Dampak:</strong> ${mainRadiusKm} KM<br>
                <strong>Koordinat:</strong> ${mainLat.toFixed(5)}, ${mainLng.toFixed(5)}
            </p>
        </div>
    `).openPopup();

    // Tampilkan juga marker bencana lain sebagai referensi
    otherDisasters.forEach((d) => {
        if (!d.latitude || !d.longitude) return;
        const m = L.marker([d.latitude, d.longitude], {
            icon: window.createDisasterMarkerIcon()
        }).addTo(map);

        L.circle([d.latitude, d.longitude], {
            color: '#CD2E0E',
            weight: 1.5,
            fillColor: '#CD2E0E',
            fillOpacity: 0.12,
            radius: (parseFloat(d.impact_radius_km) || 5) * 1000
        }).addTo(map);

        m.bindPopup(`
            <div style="min-width:190px;padding:4px;">
                <strong style="font-size:12px;color:#1E1E1E;">${d.title}</strong>
                <p style="margin:3px 0;font-size:11px;color:#CD2E0E;">📍 ${d.location} (${d.impact_radius_km} KM)</p>
                <a href="${d.url}" style="font-size:11px;font-weight:800;color:#F79301;">Buka Bencana Ini &rarr;</a>
            </div>
        `);
    });

    map.fitBounds(mainCircle.getBounds(), { padding: [30, 30] });

    document.getElementById('btnFocusDisasterCenter')?.addEventListener('click', function () {
        map.fitBounds(mainCircle.getBounds(), { padding: [30, 30] });
        mainMarker.openPopup();
    });

    document.getElementById('btnDetectDetailLocation')?.addEventListener('click', function () {
        window.detectUserLocationOnMap(map, 'detailGeoStatus');
    });
});
</script>
@endpush