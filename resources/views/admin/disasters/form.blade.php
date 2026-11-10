@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Lokasi Bencana — Admin Niskala')
@section('header', ($isEdit ? 'Perbarui' : 'Tambah') . ' Lokasi, Radius & Informasi Bencana Alam')

@section('content')
<div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 sm:p-8 max-w-5xl">
    <form action="{{ $isEdit ? route('admin.disasters.update', $disaster) : route('admin.disasters.store') }}" method="POST" class="space-y-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <!-- Bagian 1: Identitas Bencana -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Nama / Judul Bencana</label>
                <input type="text" name="title" value="{{ old('title', $disaster->title) }}" required placeholder="Contoh: Erupsi & Awan Panas Lereng Semeru" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Kategori Bencana</label>
                <select name="category_id" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $disaster->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Nama Lokasi / Wilayah</label>
                <input type="text" name="location" value="{{ old('location', $disaster->location) }}" required placeholder="Kab. Lumajang, Jawa Timur" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Waktu Kejadian</label>
                <input type="datetime-local" name="occurred_at" value="{{ old('occurred_at', optional($disaster->occurred_at)->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Status Penanganan</label>
                <select name="status" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
                    @foreach(['tanggap_darurat' => 'Tanggap Darurat', 'siaga' => 'Status Siaga', 'pemulihan' => 'Masa Pemulihan', 'selesai' => 'Selesai'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('status', $disaster->status) === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Bagian 2: Pengaturan Titik Pusat Koordinat & Pratinjau Radius Peta -->
        <div class="bg-[#F7F7F7] border-2 border-[#CD2E0E] rounded-2xl p-5 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <span class="text-xs font-extrabold uppercase text-[#CD2E0E] block">Pengaturan Geospasial Bencana</span>
                    <h3 class="text-base font-extrabold text-[#1E1E1E]">
                        Pilih Titik Pusat Bencana & Atur Radius Wilayah Terdampak (KM)
                    </h3>
                    <p class="text-xs text-[#1E1E1E]/75">
                        Klik langsung pada peta atau seret jarum merah untuk menentukan titik pusat bencana. Lingkaran merah transparan akan otomatis menyesuaikan nilai radius (km).
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="latInput" class="block text-xs font-extrabold uppercase text-[#1E1E1E] mb-1">Latitude (Garis Lintang)</label>
                    <input
                        type="number"
                        step="0.0000001"
                        id="latInput"
                        name="latitude"
                        value="{{ old('latitude', $disaster->latitude ?? -7.5407170) }}"
                        required
                        class="w-full rounded-xl border-2 border-[#D5D5D5] bg-white px-3.5 py-2.5 text-sm font-mono font-bold text-[#CD2E0E]"
                    >
                </div>
                <div>
                    <label for="lngInput" class="block text-xs font-extrabold uppercase text-[#1E1E1E] mb-1">Longitude (Garis Bujur)</label>
                    <input
                        type="number"
                        step="0.0000001"
                        id="lngInput"
                        name="longitude"
                        value="{{ old('longitude', $disaster->longitude ?? 110.4457240) }}"
                        required
                        class="w-full rounded-xl border-2 border-[#D5D5D5] bg-white px-3.5 py-2.5 text-sm font-mono font-bold text-[#CD2E0E]"
                    >
                </div>
                <div>
                    <label for="radiusInput" class="block text-xs font-extrabold uppercase text-[#1E1E1E] mb-1">Radius Dampak (Kilometer)</label>
                    <div class="flex items-center gap-2">
                        <input
                            type="number"
                            step="0.1"
                            min="0.1"
                            max="500"
                            id="radiusInput"
                            name="impact_radius_km"
                            value="{{ old('impact_radius_km', $disaster->impact_radius_km ?? 10.0) }}"
                            required
                            class="w-full rounded-xl border-2 border-[#F79301] bg-white px-3.5 py-2.5 text-sm font-extrabold text-[#1E1E1E]"
                        >
                        <span class="px-3 py-2.5 rounded-xl bg-[#F79301] text-[#1E1E1E] font-extrabold text-xs">KM</span>
                    </div>
                </div>
            </div>

            <!-- Slider Cepat Radius -->
            <div>
                <label for="radiusSlider" class="block text-xs font-bold text-[#1E1E1E]/80 mb-1">
                    Geser untuk Pratinjau Cepat Radius Dampak (0.5 KM — 100 KM):
                </label>
                <input
                    type="range"
                    id="radiusSlider"
                    min="0.5"
                    max="100"
                    step="0.5"
                    value="{{ old('impact_radius_km', $disaster->impact_radius_km ?? 10.0) }}"
                    class="w-full accent-[#CD2E0E] cursor-pointer"
                >
            </div>

            <!-- Peta Pratinjau Admin -->
            <div class="rounded-xl overflow-hidden border-2 border-[#D5D5D5]">
                <div id="adminDisasterPickerMap" class="w-full h-[380px]"></div>
            </div>
        </div>

        <!-- Bagian 3: Narasi & Dokumentasi -->
        <div>
            <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">URL Gambar Thumbnail (Opsional)</label>
            <input type="url" name="thumbnail" value="{{ old('thumbnail', $disaster->thumbnail) }}" placeholder="https://images.unsplash.com/..." class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm">
        </div>

        <div>
            <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Ringkasan Dampak & Kebutuhan Mendesak</label>
            <textarea name="summary" rows="3" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm">{{ old('summary', $disaster->summary) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-extrabold uppercase text-[#CD2E0E] mb-1.5">Kronologi & Informasi Penanganan Lengkap</label>
            <textarea name="content" rows="6" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm">{{ old('content', $disaster->content) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-3 rounded-xl bg-[#CD2E0E] hover:bg-[#A62309] text-white text-xs font-extrabold cursor-pointer">
                💾 Simpan Lokasi & Data Bencana ke PostgreSQL
            </button>
            <a href="{{ route('admin.disasters.index') }}" class="px-5 py-3 rounded-xl border-2 border-[#D5D5D5] text-xs font-extrabold text-[#1E1E1E]">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('adminDisasterPickerMap');
    if (!mapEl || typeof window.L === 'undefined') return;

    const latInput = document.getElementById('latInput');
    const lngInput = document.getElementById('lngInput');
    const radiusInput = document.getElementById('radiusInput');
    const radiusSlider = document.getElementById('radiusSlider');

    let currentLat = parseFloat(latInput.value) || -7.5407170;
    let currentLng = parseFloat(lngInput.value) || 110.4457240;
    let currentRadiusKm = parseFloat(radiusInput.value) || 10.0;

    const map = L.map('adminDisasterPickerMap').setView([currentLat, currentLng], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([currentLat, currentLng], {
        icon: window.createDisasterMarkerIcon(),
        draggable: true
    }).addTo(map);

    const circle = L.circle([currentLat, currentLng], {
        color: '#CD2E0E',
        weight: 2.5,
        fillColor: '#CD2E0E',
        fillOpacity: 0.25,
        radius: currentRadiusKm * 1000
    }).addTo(map);

    function updateMapPreview(lat, lng, radiusKm, pan = false) {
        marker.setLatLng([lat, lng]);
        circle.setLatLng([lat, lng]);
        circle.setRadius(Math.max(0.1, radiusKm) * 1000);
        if (pan) {
            map.panTo([lat, lng]);
        }
    }

    // Saat peta diklik oleh Admin
    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
        updateMapPreview(lat, lng, parseFloat(radiusInput.value) || 5, true);
    });

    // Saat marker digeser oleh Admin
    marker.on('dragend', function () {
        const pos = marker.getLatLng();
        latInput.value = pos.lat.toFixed(7);
        lngInput.value = pos.lng.toFixed(7);
        updateMapPreview(pos.lat, pos.lng, parseFloat(radiusInput.value) || 5, true);
    });

    // Saat input angka koordinat atau radius diubah manual
    [latInput, lngInput].forEach((el) => {
        el.addEventListener('input', function () {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                updateMapPreview(lat, lng, parseFloat(radiusInput.value) || 5, true);
            }
        });
    });

    radiusInput.addEventListener('input', function () {
        const r = parseFloat(radiusInput.value) || 1;
        radiusSlider.value = Math.min(100, r);
        updateMapPreview(parseFloat(latInput.value) || currentLat, parseFloat(lngInput.value) || currentLng, r, false);
    });

    radiusSlider.addEventListener('input', function () {
        const r = parseFloat(radiusSlider.value) || 1;
        radiusInput.value = r;
        updateMapPreview(parseFloat(latInput.value) || currentLat, parseFloat(lngInput.value) || currentLng, r, false);
    });
});
</script>
@endpush