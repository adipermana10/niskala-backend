@extends('layouts.admin')

@section('title', 'Kelola Lokasi & Informasi Bencana — Admin Niskala')
@section('header', 'Manajemen Lokasi, Radius & Informasi Bencana')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <p class="text-sm font-medium text-[#1E1E1E]/80">
        Kelola titik pusat koordinat bencana, radius dampak (km), dan informasi penanganan lapangan.
    </p>
    <a href="{{ route('admin.disasters.create') }}" class="px-5 py-2.5 rounded-xl bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] text-xs font-extrabold border-2 border-[#1E1E1E]">
        + Tambah Lokasi Bencana Baru
    </a>
</div>

<div class="bg-white border-2 border-[#D5D5D5] rounded-2xl p-6 overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b-2 border-[#D5D5D5] text-xs uppercase font-extrabold text-[#CD2E0E]">
                <th class="py-3 px-3">Nama Bencana</th>
                <th class="py-3 px-3">Kategori</th>
                <th class="py-3 px-3">Lokasi & Koordinat</th>
                <th class="py-3 px-3">Radius Dampak</th>
                <th class="py-3 px-3">Status</th>
                <th class="py-3 px-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#D5D5D5]">
            @foreach($disasters as $disaster)
                <tr class="hover:bg-[#F7F7F7]">
                    <td class="py-3.5 px-3 font-extrabold text-[#1E1E1E]">
                        <a href="{{ route('disasters.show', $disaster->slug) }}" target="_blank" class="hover:text-[#CD2E0E] hover:underline">
                            {{ $disaster->title }}
                        </a>
                    </td>
                    <td class="py-3.5 px-3 text-xs font-bold">{{ $disaster->category->name ?? '-' }}</td>
                    <td class="py-3.5 px-3 text-xs">
                        <span class="font-bold text-[#1E1E1E] block">📍 {{ $disaster->location }}</span>
                        <span class="font-mono text-[11px] text-[#1E1E1E]/70">
                            {{ number_format($disaster->latitude, 5) }}, {{ number_format($disaster->longitude, 5) }}
                        </span>
                    </td>
                    <td class="py-3.5 px-3">
                        <span class="px-2.5 py-1 rounded-lg bg-[#CD2E0E] text-white text-xs font-extrabold">
                            {{ number_format($disaster->impact_radius_km, 1) }} KM
                        </span>
                    </td>
                    <td class="py-3.5 px-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-[#F79301]/25 text-[#1E1E1E] border border-[#F79301]">
                            {{ $disaster->status_label }}
                        </span>
                    </td>
                    <td class="py-3.5 px-3 text-right space-x-1.5">
                        <a href="{{ route('admin.disasters.edit', $disaster) }}" class="px-3 py-1.5 rounded-lg bg-[#F79301] text-[#1E1E1E] text-xs font-extrabold">
                            Edit Peta & Data
                        </a>
                        <form action="{{ route('admin.disasters.destroy', $disaster) }}" method="POST" onsubmit="return confirm('Hapus data bencana ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#CD2E0E] text-white text-xs font-extrabold cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $disasters->links() }}</div>
</div>
@endsection