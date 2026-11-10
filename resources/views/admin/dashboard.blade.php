@extends('layouts.admin')

@section('title', 'Dashboard Admin — Niskala')
@section('header', 'Ringkasan Eksekutif Niskala')

@section('content')
<!-- Kartu Statistik Utama -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6">
        <span class="text-xs font-bold uppercase text-[#4A5750]">Total Donasi Terverifikasi</span>
        <p class="text-2xl font-serif font-bold text-[#1B4332] mt-2">
            Rp {{ number_format($stats['total_collected'], 0, ',', '.') }}
        </p>
        <span class="text-[11px] text-[#2D6A4F] font-semibold mt-1 block">{{ $stats['total_donors'] }} transaksi sukses</span>
    </div>

    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6">
        <span class="text-xs font-bold uppercase text-[#4A5750]">Kampanye Donasi</span>
        <p class="text-2xl font-serif font-bold text-[#1B4332] mt-2">
            {{ $stats['active_campaigns'] }} Aktif
        </p>
        <span class="text-[11px] text-[#4A5750] mt-1 block">Dari total {{ $stats['total_campaigns'] }} kampanye</span>
    </div>

    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6">
        <span class="text-xs font-bold uppercase text-[#4A5750]">Laporan Bencana</span>
        <p class="text-2xl font-serif font-bold text-[#1B4332] mt-2">
            {{ $stats['total_disasters'] }} Kejadian
        </p>
        <span class="text-[11px] text-[#4A5750] mt-1 block">Dalam {{ $stats['total_categories'] }} kategori</span>
    </div>

    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6">
        <span class="text-xs font-bold uppercase text-[#4A5750]">Pengguna Terdaftar</span>
        <p class="text-2xl font-serif font-bold text-[#1B4332] mt-2">
            {{ $stats['total_users'] }} Akun
        </p>
        <span class="text-[11px] text-[#4A5750] mt-1 block">Admin & Sahabat Niskala</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Donasi Terbaru -->
    <div class="lg:col-span-7 bg-white border border-[#E6DEC8] rounded-3xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-serif font-bold text-[#1B4332]">Transaksi Donasi Terbaru</h2>
            <a href="{{ route('admin.donations.index') }}" class="text-xs font-bold text-[#2D6A4F] hover:underline">Kelola Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-[#E6DEC8] text-[#4A5750] uppercase">
                        <th class="py-2.5">Donatur</th>
                        <th class="py-2.5">Kampanye</th>
                        <th class="py-2.5">Nominal</th>
                        <th class="py-2.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4EFE6]">
                    @foreach($recentDonations as $donation)
                        <tr>
                            <td class="py-3 font-bold text-[#1C2521]">{{ $donation->donor_name }}</td>
                            <td class="py-3 text-[#4A5750] truncate max-w-[180px]">{{ $donation->campaign->title ?? '-' }}</td>
                            <td class="py-3 font-bold text-[#1B4332]">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                            <td class="py-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#D8F3DC] text-[#1B4332]">
                                    {{ $donation->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aksi Cepat Admin -->
    <div class="lg:col-span-5 bg-[#F4EFE6] border border-[#D2C49E] rounded-3xl p-6 space-y-4">
        <h2 class="text-base font-serif font-bold text-[#1B4332]">Pintasan Pengelolaan</h2>
        <div class="grid grid-cols-1 gap-3">
            <a href="{{ route('admin.campaigns.create') }}" class="p-4 rounded-2xl bg-white border border-[#E6DEC8] hover:border-[#1B4332] flex items-center justify-between transition">
                <span class="text-sm font-bold text-[#1B4332]">+ Buat Kampanye Donasi Baru</span>
                <span>&rarr;</span>
            </a>
            <a href="{{ route('admin.disasters.create') }}" class="p-4 rounded-2xl bg-white border border-[#E6DEC8] hover:border-[#1B4332] flex items-center justify-between transition">
                <span class="text-sm font-bold text-[#1B4332]">+ Tambah Laporan Bencana Alam</span>
                <span>&rarr;</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="p-4 rounded-2xl bg-white border border-[#E6DEC8] hover:border-[#1B4332] flex items-center justify-between transition">
                <span class="text-sm font-bold text-[#1B4332]">🏷️ Kelola Kategori Bencana & Kampanye</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>
</div>
@endsection