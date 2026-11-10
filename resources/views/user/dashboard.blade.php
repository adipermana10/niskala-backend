@extends('layouts.app')

@section('title', 'Dashboard Donatur — Niskala')

@section('content')
<section class="bg-batik-kawung text-[#FAF8F5] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-[#D2C49E]">Ruang Kebaikan Sahabat</span>
            <h1 class="text-3xl font-serif font-bold mt-1">Halo, {{ $user->name }}</h1>
            <p class="text-sm text-[#E6DEC8] mt-1">Terima kasih telah menjadi bagian dari kepedulian nyata bersama Niskala.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('user.profile.edit') }}" class="px-4 py-2.5 rounded-xl bg-[#FAF8F5] text-[#1B4332] text-xs font-bold shadow-xs hover:bg-[#E6DEC8] transition">
                ⚙️ Pengaturan Profil
            </a>
            <a href="{{ route('campaigns.index') }}" class="px-4 py-2.5 rounded-xl bg-[#D2C49E] text-[#122E22] text-xs font-bold shadow-xs hover:bg-[#E6DEC8] transition">
                + Donasi Baru
            </a>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-[#D8F3DC] border border-[#52B788] text-sm font-semibold text-[#1B4332]">
            🌿 {{ session('success') }}
        </div>
    @endif

    <!-- Ringkasan Kontribusi -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-[#4A5750]">Total Donasi Terverifikasi</span>
            <p class="text-3xl font-serif font-bold text-[#1B4332] mt-2">
                Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-[#4A5750]">Frekuensi Berdonasi</span>
            <p class="text-3xl font-serif font-bold text-[#1B4332] mt-2">
                {{ $stats['total_donations'] }} Transaksi
            </p>
        </div>
        <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-[#4A5750]">Kampanye yang Didukung</span>
            <p class="text-3xl font-serif font-bold text-[#1B4332] mt-2">
                {{ $stats['campaigns_count'] }} Program
            </p>
        </div>
    </div>

    <!-- Tabel Riwayat Donasi -->
    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 sm:p-8 shadow-xs">
        <h2 class="text-xl font-serif font-bold text-[#1B4332] mb-5">Riwayat Jejak Donasi Anda</h2>

        @if($donations->isEmpty())
            <div class="bg-[#F4EFE6] rounded-2xl p-10 text-center">
                <p class="text-sm text-[#4A5750]">Anda belum memiliki riwayat donasi tercatat.</p>
                <a href="{{ route('campaigns.index') }}" class="mt-4 inline-block px-5 py-2.5 rounded-xl bg-[#1B4332] text-white text-xs font-bold">
                    Mulai Berdonasi Sekarang
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6DEC8] text-xs uppercase text-[#4A5750]">
                            <th class="py-3 px-4">No. Invoice</th>
                            <th class="py-3 px-4">Kampanye</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Metode</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F4EFE6]">
                        @foreach($donations as $donation)
                            <tr class="hover:bg-[#FAF8F5]">
                                <td class="py-3.5 px-4 font-mono text-xs font-bold text-[#1B4332]">{{ $donation->invoice_number }}</td>
                                <td class="py-3.5 px-4 font-semibold text-[#1C2521]">
                                    @if($donation->campaign)
                                        <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="hover:text-[#1B4332] hover:underline">
                                            {{ $donation->campaign->title }}
                                        </a>
                                    @else
                                        <span>Kampanye Selesai</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[#1B4332]">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-xs text-[#4A5750]">{{ $donation->payment_method }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if($donation->status === 'verified') bg-[#D8F3DC] text-[#1B4332]
                                        @elseif($donation->status === 'pending') bg-amber-100 text-amber-800
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-[#4A5750]">{{ $donation->created_at->translatedFormat('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection