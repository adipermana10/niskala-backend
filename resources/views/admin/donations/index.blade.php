@extends('layouts.admin')

@section('title', 'Manajemen Donasi — Admin Niskala')
@section('header', 'Data Transaksi & Verifikasi Donasi')

@section('content')
<div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b border-[#E6DEC8] text-xs uppercase text-[#4A5750]">
                <th class="py-3 px-3">Invoice</th>
                <th class="py-3 px-3">Donatur</th>
                <th class="py-3 px-3">Kampanye</th>
                <th class="py-3 px-3">Nominal & Metode</th>
                <th class="py-3 px-3">Status</th>
                <th class="py-3 px-3 text-right">Ubah Status / Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#F4EFE6]">
            @foreach($donations as $donation)
                <tr>
                    <td class="py-3.5 px-3 font-mono text-xs font-bold text-[#1B4332]">{{ $donation->invoice_number }}</td>
                    <td class="py-3.5 px-3">
                        <p class="font-bold text-[#1C2521]">{{ $donation->donor_name }}</p>
                        <span class="text-xs text-[#4A5750]">{{ $donation->donor_email ?? 'Tanpa email' }}</span>
                    </td>
                    <td class="py-3.5 px-3 text-xs text-[#4A5750] max-w-xs truncate">{{ $donation->campaign->title ?? '-' }}</td>
                    <td class="py-3.5 px-3">
                        <strong class="text-[#1B4332]">Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong>
                        <span class="block text-xs text-[#4A5750]">{{ $donation->payment_method }}</span>
                    </td>
                    <td class="py-3.5 px-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold
                            @if($donation->status === 'verified') bg-[#D8F3DC] text-[#1B4332]
                            @elseif($donation->status === 'pending') bg-amber-100 text-amber-800
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </td>
                    <td class="py-3.5 px-3 text-right">
                        <form action="{{ route('admin.donations.status', $donation) }}" method="POST" class="inline-flex items-center gap-1.5">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="rounded-lg border border-[#D2C49E] bg-[#FAF8F5] px-2.5 py-1 text-xs font-semibold">
                                <option value="verified" @selected($donation->status === 'verified')>Verified</option>
                                <option value="pending" @selected($donation->status === 'pending')>Pending</option>
                                <option value="rejected" @selected($donation->status === 'rejected')>Rejected</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $donations->links() }}</div>
</div>
@endsection