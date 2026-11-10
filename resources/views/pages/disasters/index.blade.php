@extends('layouts.app')

@section('title', 'Peta & Informasi Bencana Alam — Niskala')

@section('content')
<!-- Header Flat 2D -->
<section class="bg-[#CD2E0E] text-white py-14 border-b-4 border-[#F79301]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="inline-block px-3.5 py-1 rounded-lg bg-[#F79301] text-[#1E1E1E] text-xs font-extrabold tracking-wider uppercase mb-3">
            Sistem Informasi Geospasial Bencana
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">
            Peta Lokasi & Radius Dampak Bencana Alam
        </h1>
        <p class="mt-3 text-white/90 max-w-2xl text-base leading-relaxed">
            Gunakan filter pencarian di bawah ini untuk memantau titik lokasi bencana beserta estimasi radius wilayah terdampak di seluruh Indonesia.
        </p>
    </div>
</section>

<!-- Bar Pencarian & Filter -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-7 relative z-20">
    <form action="{{ route('disasters.index') }}" method="GET" class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        <div class="md:col-span-5">
            <label class="block text-xs font-extrabold text-[#CD2E0E] uppercase tracking-wider mb-1.5">Cari Nama Bencana / Wilayah</label>
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Contoh: Semeru, Banjir Agam, Garut..."
                class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]"
            >
        </div>

        <div class="md:col-span-3">
            <label class="block text-xs font-extrabold text-[#CD2E0E] uppercase tracking-wider mb-1.5">Kategori Bencana</label>
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
            <label class="block text-xs font-extrabold text-[#CD2E0E] uppercase tracking-wider mb-1.5">Status</label>
            <select name="status" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-3.5 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]">
                <option value="">Semua Status</option>
                <option value="tanggap_darurat" @selected(request('status') === 'tanggap_darurat')>Tanggap Darurat</option>
                <option value="siaga" @selected(request('status') === 'siaga')>Status Siaga</option>
                <option value="pemulihan" @selected(request('status') === 'pemulihan')>Masa Pemulihan</option>
                <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
            </select>
        </div>

        <div class="md:col-span-2 flex gap-2">
            <button type="submit" class="w-full bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold py-2.5 px-4 rounded-xl text-sm border-2 border-[#1E1E1E] transition cursor-pointer">
                Terapkan
            </button>
            @if(request()->anyFilled(['q', 'category', 'status']))
                <a href="{{ route('disasters.index') }}" class="px-3.5 py-2.5 rounded-xl border-2 border-[#D5D5D5] text-[#1E1E1E] hover:border-[#CD2E0E] text-sm font-bold">
                    Reset
                </a>
            @endif
        </div>
    </form>
</section>

<!-- Peta Interaktif Hasil Filter & Tombol Deteksi Lokasi -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
    <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div>
                <h2 class="text-lg font-extrabold text-[#1E1E1E]">
                    Peta Sebaran Titik Pusat & Radius Dampak ({{ $mapDisasters->count() }} Lokasi)
                </h2>
                <p class="text-xs text-[#1E1E1E]/70">
                    Klik marker merah pada peta untuk membaca ringkasan kejadian dan radius dampaknya.
                </p>
            </div>
            <button
                type="button"
                id="btnDetectListLocation"
                class="px-4 py-2.5 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold text-xs border-2 border-[#1E1E1E] transition cursor-pointer self-start sm:self-auto"
            >
                📍 Deteksi Lokasi Saya
            </button>
        </div>

        <div id="listGeoStatus" class="hidden mb-4 p-3 rounded-xl border-2 text-xs font-bold"></div>

        <div class="rounded-xl overflow-hidden border-2 border-[#D5D5D5]">
            <div id="disastersIndexMap" class="w-full h-[380px] sm:h-[440px]"></div>
        </div>

        <!-- Legenda -->
        <div class="mt-4 flex flex-wrap items-center justify-between gap-4 text-xs font-bold bg-[#D5D5D5]/40 p-3.5 rounded-xl border border-[#D5D5D5]">
            <div class="flex flex-wrap items-center gap-5">
                <span class="flex items-center gap-2"><span class="w-3.5 h-3.5 rounded-full bg-[#CD2E0E] inline-block"></span> Titik Pusat Bencana</span>
                <span class="flex items-center gap-2"><span class="w-3.5 h-3.5 rounded-full bg-[#CD2E0E]/30 border border-[#CD2E0E] inline-block"></span> Radius Wilayah Terdampak (KM)</span>
                <span class="flex items-center gap-2"><span class="w-3.5 h-3.5 rounded-full bg-[#F79301] border border-[#1E1E1E] inline-block"></span> Lokasi Pengguna</span>
            </div>
            <span class="text-[11px] font-medium text-[#1E1E1E]/75">
                *Visualisasi radius merupakan estimasi jarak dari titik pusat berdasarkan data admin.
            </span>
        </div>
    </div>
</section>

<!-- Daftar Kartu Informasi Bencana -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if($disasters->isEmpty())
        <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-12 text-center">
            <h3 class="text-xl font-extrabold text-[#CD2E0E]">Belum Ada Laporan Bencana yang Sesuai</h3>
            <p class="text-sm text-[#1E1E1E]/75 mt-2">Silakan ubah kata kunci pencarian atau pilih filter kategori lainnya.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($disasters as $disaster)
                <article class="flat-card overflow-hidden flex flex-col">
                    <div class="relative h-52 overflow-hidden bg-[#D5D5D5] border-b-2 border-[#D5D5D5]">
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
                            <div class="flex items-center gap-2 text-xs font-bold text-[#CD2E0E] mb-2">
                                <span>📍 {{ $disaster->location }}</span>
                                <span>•</span>
                                <span>{{ $disaster->occurred_at->translatedFormat('d M Y') }}</span>
                            </div>

                            <h2 class="text-lg font-extrabold text-[#1E1E1E] hover:text-[#CD2E0E] transition line-clamp-2">
                                <a href="{{ route('disasters.show', $disaster->slug) }}">
                                    {{ $disaster->title }}
                                </a>
                            </h2>

                            <p class="mt-2.5 text-sm text-[#1E1E1E]/80 line-clamp-3 leading-relaxed">
                                {{ $disaster->summary }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t-2 border-[#D5D5D5] flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-md bg-[#D5D5D5]/60 text-[11px] font-extrabold text-[#1E1E1E]">
                                {{ $disaster->status_label }}
                            </span>
                            <a href="{{ route('disasters.show', $disaster->slug) }}" class="text-xs font-extrabold uppercase text-[#CD2E0E] hover:underline">
                                Buka Peta & Laporan &rarr;
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $disasters->links() }}
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('disastersIndexMap');
    if (!mapEl || typeof window.L === 'undefined') return;

    const disasters = @json($mapDisasters);
    const map = L.map('disastersIndexMap').setView([-2.5489, 118.0149], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const bounds = [];

    disasters.forEach((item) => {
        if (!item.latitude || !item.longitude) return;
        const pos = [item.latitude, item.longitude];
        bounds.push(pos);

        const marker = L.marker(pos, { icon: window.createDisasterMarkerIcon() }).addTo(map);

        L.circle(pos, {
            color: '#CD2E0E',
            weight: 2,
            fillColor: '#CD2E0E',
            fillOpacity: 0.22,
            radius: (parseFloat(item.impact_radius_km) || 5) * 1000
        }).addTo(map);

        marker.bindPopup(`
            <div style="min-width:210px;padding:4px;">
                <span style="display:inline-block;padding:2px 8px;border-radius:6px;background:#CD2E0E;color:#fff;font-size:10px;font-weight:800;">
                    ${item.category}
                </span>
                <h3 style="margin:6px 0 2px;font-size:13px;font-weight:800;color:#1E1E1E;">${item.title}</h3>
                <p style="margin:0;font-size:11px;color:#CD2E0E;font-weight:700;">📍 ${item.location}</p>
                <p style="margin:4px 0;font-size:11px;color:#1E1E1E;">
                    <strong>Status:</strong> ${item.status_label}<br>
                    <strong>Radius Dampak:</strong> ${item.impact_radius_km} KM
                </p>
                <a href="${item.url}" style="display:inline-block;margin-top:6px;padding:5px 10px;background:#F79301;color:#1E1E1E;font-weight:800;font-size:11px;border-radius:6px;text-decoration:none;border:1px solid #1E1E1E;">
                    Detail Laporan &rarr;
                </a>
            </div>
        `);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [40, 40], maxZoom: 11 });
    }

    const btn = document.getElementById('btnDetectListLocation');
    if (btn) {
        btn.addEventListener('click', function () {
            window.detectUserLocationOnMap(map, 'listGeoStatus');
        });
    }
});
</script>
@endpush