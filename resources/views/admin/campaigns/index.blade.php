@extends('layouts.admin')

@section('title', 'Kelola Kampanye Donasi — Admin Niskala')
@section('header', 'Manajemen Kampanye Penggalangan Dana')

@section('content')
<div class="flex justify-between items-center">
    <p class="text-sm text-[#4A5750]">Daftar seluruh program penggalangan dana bencana dan sosial.</p>
    <a href="{{ route('admin.campaigns.create') }}" class="px-5 py-2.5 rounded-xl bg-[#1B4332] hover:bg-[#2D6A4F] text-white text-xs font-bold">
        + Buat Kampanye Baru
    </a>
</div>

<div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b border-[#E6DEC8] text-xs uppercase text-[#4A5750]">
                <th class="py-3 px-3">Judul Kampanye</th>
                <th class="py-3 px-3">Kategori</th>
                <th class="py-3 px-3">Terkumpul / Target</th>
                <th class="py-3 px-3">Status</th>
                <th class="py-3 px-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#F4EFE6]">
            @foreach($campaigns as $campaign)
                <tr>
                    <td class="py-3.5 px-3">
                        <p class="font-bold text-[#1C2521]">{{ $campaign->title }}</p>
                        @if($campaign->disaster)
                            <span class="text-xs text-[#2D6A4F]">📍 {{ $campaign->disaster->title }}</span>
                        @endif
                    </td>
                    <td class="py-3.5 px-3 text-xs">{{ $campaign->category->name ?? '-' }}</td>
                    <td class="py-3.5 px-3 text-xs">
                        <strong class="text-[#1B4332]">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</strong>
                        <span class="block text-[#4A5750]">dari Rp {{ number_format($campaign->target_amount, 0, ',', '.') }} ({{ $campaign->progress_percentage }}%)</span>
                    </td>
                    <td class="py-3.5 px-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#D8F3DC] text-[#1B4332]">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </td>
                    <td class="py-3.5 px-3 text-right space-x-2">
                        <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="px-3 py-1.5 rounded-lg bg-[#F4EFE6] text-[#1B4332] text-xs font-bold">Edit</a>
                        <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Hapus kampanye ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 text-xs font-bold cursor-pointer">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $campaigns->links() }}</div>
</div>
@endsection