@extends('layouts.app')

@section('title', $campaign->title . ' — Niskala')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(session('success'))
        <div class="mb-6 rounded-xl bg-[#FFF6E8] border-2 border-[#F79301] p-4 text-[#1E1E1E] text-sm font-extrabold">
            ✅ {{ session('success') }}
        </div>
    @endif

    <nav class="text-xs font-bold text-[#1E1E1E]/70 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-[#CD2E0E]">Beranda</a>
        <span>/</span>
        <a href="{{ route('campaigns.index') }}" class="hover:text-[#CD2E0E]">Kampanye Donasi</a>
        <span>/</span>
        <span class="text-[#CD2E0E] truncate">{{ $campaign->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl overflow-hidden">
                @if($campaign->thumbnail)
                    <div class="h-72 md:h-96 bg-[#D5D5D5] overflow-hidden border-b-2 border-[#D5D5D5]">
                        <img src="{{ $campaign->thumbnail }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="px-3 py-1 rounded-lg text-xs font-extrabold bg-[#CD2E0E] text-white">
                            {{ $campaign->category->name }}
                        </span>
                        @if($campaign->disaster)
                            <a href="{{ route('disasters.show', $campaign->disaster->slug) }}" class="px-3 py-1 rounded-lg text-xs font-extrabold bg-[#F79301] text-[#1E1E1E] hover:bg-[#D97E00]">
                                📍 Lihat Peta Bencana: {{ $campaign->disaster->title }} ({{ number_format($campaign->disaster->impact_radius_km, 1) }} KM)
                            </a>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#1E1E1E] leading-snug">
                        {{ $campaign->title }}
                    </h1>

                    <p class="mt-2 text-xs font-bold text-[#1E1E1E]/70">
                        Penyelenggara: <strong class="text-[#CD2E0E]">{{ $campaign->author->name ?? 'Tim Kemanusiaan Niskala' }}</strong>
                    </p>

                    <div class="mt-6 bg-[#F7F7F7] border-2 border-[#D5D5D5] rounded-2xl p-5">
                        <div class="flex flex-wrap justify-between items-end gap-2 mb-2">
                            <div>
                                <span class="text-xs font-bold text-[#1E1E1E]/70 block">Dana Terkumpul</span>
                                <span class="text-2xl font-extrabold text-[#CD2E0E]">
                                    Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-[#1E1E1E]/70 block">Target Kebutuhan</span>
                                <span class="text-sm font-extrabold text-[#1E1E1E]">
                                    Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="w-full bg-[#D5D5D5] h-3.5 rounded-full overflow-hidden">
                            <div class="bg-[#F79301] h-full rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                        </div>

                        <div class="flex justify-between text-xs font-bold text-[#1E1E1E]/80 mt-2.5">
                            <span><strong>{{ $campaign->verifiedDonations->count() }}</strong> Donatur berpartisipasi</span>
                            <span>
                                @if($campaign->days_remaining !== null)
                                    <strong>{{ $campaign->days_remaining }}</strong> hari tersisa
                                @else
                                    Penggalangan Terbuka
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="mt-7 pt-6 border-t-2 border-[#D5D5D5]">
                        <h2 class="text-lg font-extrabold text-[#CD2E0E] mb-3">Kisah & Rencana Penyaluran Bantuan</h2>
                        <div class="text-sm text-[#1E1E1E] leading-relaxed space-y-4">
                            {!! nl2br(e($campaign->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Donatur -->
            <div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 md:p-8">
                <h2 class="text-lg font-extrabold text-[#CD2E0E] mb-4">
                    Daftar Donatur & Doa ({{ $campaign->verifiedDonations->count() }})
                </h2>

                <div class="space-y-3">
                    @forelse($campaign->verifiedDonations as $donation)
                        <div class="p-4 rounded-xl bg-[#F7F7F7] border-2 border-[#D5D5D5] flex justify-between items-start gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-sm text-[#1E1E1E]">{{ $donation->display_name }}</span>
                                    <span class="text-xs font-semibold text-[#1E1E1E]/60">• {{ $donation->created_at->diffForHumans() }}</span>
                                </div>
                                @if($donation->message)
                                    <p class="mt-1.5 text-sm text-[#1E1E1E]/80 italic">"{{ $donation->message }}"</p>
                                @endif
                            </div>
                            <span class="px-3 py-1 rounded-lg bg-[#F79301] text-[#1E1E1E] text-xs font-extrabold shrink-0">
                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm font-bold text-[#1E1E1E]/70 text-center py-6">
                            Jadilah donatur pertama pada kampanye ini.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Form Kirim Donasi -->
        <div class="lg:col-span-5">
            <div class="bg-white border-2 border-[#CD2E0E] rounded-2xl p-6 md:p-8 sticky top-24">
                <h2 class="text-xl font-extrabold text-[#CD2E0E]">Salurkan Donasi Terbaik</h2>
                <p class="text-xs font-semibold text-[#1E1E1E]/70 mt-1 mb-5">
                    Pilih nominal cepat atau masukkan jumlah donasi Anda di bawah ini.
                </p>

                <form action="{{ route('campaigns.donate', $campaign->slug) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-2">Nominal Cepat</label>
                        <div class="grid grid-cols-2 gap-2.5">
                            @foreach([50000, 100000, 250000, 500000] as $preset)
                                <button
                                    type="button"
                                    onclick="document.getElementById('amountInput').value = '{{ $preset }}'"
                                    class="py-2.5 px-3 rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] hover:bg-[#F79301] hover:border-[#1E1E1E] text-xs font-extrabold text-[#1E1E1E] transition cursor-pointer"
                                >
                                    Rp {{ number_format($preset, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="amountInput" class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Nominal Donasi (Rp)</label>
                        <input
                            type="number"
                            id="amountInput"
                            name="amount"
                            value="{{ old('amount', 100000) }}"
                            min="10000"
                            step="5000"
                            required
                            class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-extrabold text-[#CD2E0E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Nama Lengkap</label>
                        <input
                            type="text"
                            name="donor_name"
                            value="{{ old('donor_name', auth()->user()->name ?? '') }}"
                            required
                            placeholder="Nama Anda"
                            class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Email (Opsional)</label>
                        <input
                            type="email"
                            name="donor_email"
                            value="{{ old('donor_email', auth()->user()->email ?? '') }}"
                            placeholder="email@contoh.com"
                            class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold text-[#1E1E1E] focus:bg-white focus:outline-none focus:border-[#CD2E0E]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-3.5 py-2.5 text-sm font-semibold text-[#1E1E1E]">
                            <option value="QRIS">QRIS Nusantara (Instan)</option>
                            <option value="Transfer BSI">Transfer Bank Syariah Indonesia (BSI)</option>
                            <option value="Transfer Mandiri">Transfer Bank Mandiri</option>
                            <option value="Transfer BCA">Transfer Bank BCA</option>
                            <option value="Transfer BRI">Transfer Bank BRI</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Pesan / Doa Kebaikan (Opsional)</label>
                        <textarea
                            name="message"
                            rows="3"
                            placeholder="Tulis doa untuk para penyintas..."
                            class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm text-[#1E1E1E]"
                        >{{ old('message') }}</textarea>
                    </div>

                    <label class="flex items-center gap-2.5 text-xs font-bold text-[#1E1E1E]/80 cursor-pointer">
                        <input type="checkbox" name="is_anonymous" value="1" class="rounded border-[#D5D5D5] text-[#CD2E0E]">
                        <span>Sembunyikan nama saya (Tampilkan sebagai <strong>Sahabat Niskala</strong>)</span>
                    </label>

                    <button type="submit" class="w-full bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold py-3.5 px-5 rounded-xl text-sm border-2 border-[#1E1E1E] transition cursor-pointer">
                        Kirim Donasi Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection