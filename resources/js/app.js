import { gsap } from 'gsap';
import L from 'leaflet';

window.gsap = gsap;
window.L = L;

/**
 * Pembuat Ikon Jarum Merah Flat 2D (#CD2E0E) untuk Titik Pusat Bencana
 */
window.createDisasterMarkerIcon = function () {
    return L.divIcon({
        className: 'custom-disaster-pin',
        html: `
            <div style="position:relative;width:34px;height:42px;display:flex;align-items:center;justify-content:center;">
                <svg width="34" height="42" viewBox="0 0 34 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 0C7.611 0 0 7.611 0 17C0 28.05 17 42 17 42C17 42 34 28.05 34 17C34 7.611 26.389 0 17 0Z" fill="#CD2E0E"/>
                    <circle cx="17" cy="16" r="7" fill="#FFFFFF"/>
                    <circle cx="17" cy="16" r="3.5" fill="#F79301"/>
                </svg>
            </div>
        `,
        iconSize: [34, 42],
        iconAnchor: [17, 42],
        popupAnchor: [0, -38],
    });
};

/**
 * Pembuat Ikon Lokasi Pengguna Flat 2D (#F79301) agar berbeda dari Marker Bencana
 */
window.createUserLocationIcon = function () {
    return L.divIcon({
        className: 'custom-user-pin',
        html: `
            <div style="position:relative;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                <div style="width:26px;height:26px;border-radius:9999px;background:#F79301;border:3px solid #1E1E1E;display:flex;align-items:center;justify-content:center;">
                    <div style="width:8px;height:8px;border-radius:9999px;background:#FFFFFF;"></div>
                </div>
            </div>
        `,
        iconSize: [32, 32],
        iconAnchor: [16, 16],
        popupAnchor: [0, -16],
    });
};

/**
 * Fungsi Geolocation API Browser untuk Tombol "Deteksi Lokasi Saya"
 */
window.detectUserLocationOnMap = function (mapInstance, statusElementId) {
    const statusEl = document.getElementById(statusElementId);
    const showStatus = (message, isError = false) => {
        if (!statusEl) return;
        statusEl.classList.remove('hidden');
        statusEl.textContent = message;
        statusEl.style.borderColor = isError ? '#CD2E0E' : '#F79301';
        statusEl.style.backgroundColor = isError ? '#FDECE9' : '#FFF6E8';
        statusEl.style.color = isError ? '#CD2E0E' : '#1E1E1E';
    };

    if (!navigator.geolocation) {
        showStatus('Browser Anda tidak mendukung fitur deteksi lokasi Geolocation. Silakan geser peta secara manual.', true);
        return;
    }

    showStatus('Mendeteksi titik lokasi perangkat Anda...', false);

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            if (window._niskalaUserMarker) {
                mapInstance.removeLayer(window._niskalaUserMarker);
            }

            window._niskalaUserMarker = L.marker([lat, lng], {
                icon: window.createUserLocationIcon(),
            })
                .addTo(mapInstance)
                .bindPopup(`
                    <div style="padding:4px;">
                        <strong style="color:#F79301;font-size:12px;text-transform:uppercase;">Lokasi Anda Saat Ini</strong>
                        <p style="margin:4px 0 0;font-size:12px;color:#1E1E1E;">Koordinat: ${lat.toFixed(5)}, ${lng.toFixed(5)}</p>
                    </div>
                `)
                .openPopup();

            mapInstance.flyTo([lat, lng], 11, { duration: 1.4 });
            showStatus('Lokasi Anda berhasil ditampilkan pada peta (Penanda Oranye). Koordinat ini tidak disimpan ke server.', false);
        },
        (error) => {
            let msg = 'Izin lokasi ditolak atau tidak tersedia. Anda tetap dapat menggunakan dan menggeser peta secara manual.';
            if (error.code === error.TIMEOUT) {
                msg = 'Waktu permintaan lokasi habis. Silakan gunakan peta secara manual atau coba kembali.';
            }
            showStatus(msg, true);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0,
        }
    );
};

document.addEventListener('DOMContentLoaded', () => {
    const fadeUpElements = document.querySelectorAll('.gsap-fade-up');
    if (fadeUpElements.length > 0) {
        gsap.fromTo(
            fadeUpElements,
            { opacity: 0, y: 20 },
            {
                opacity: 1,
                y: 0,
                duration: 0.65,
                stagger: 0.1,
                ease: 'power2.out',
            }
        );
    }
});