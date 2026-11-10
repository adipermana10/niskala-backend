@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit' : 'Buat') . ' Kampanye — Admin Niskala')
@section('header', ($isEdit ? 'Perbarui' : 'Buat') . ' Kampanye Penggalangan Dana')

@section('content')
<div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 sm:p-8 max-w-4xl">
    <form action="{{ $isEdit ? route('admin.campaigns.update', $campaign) : route('admin.campaigns.store') }}" method="POST" class="space-y-5">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
            <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Judul Kampanye Donasi</label>
            <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Kategori</label>
                <select name="category_id" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $campaign->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Terkait Laporan Bencana (Opsional)</label>
                <select name="disaster_id" class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
                    <option value="">-- Kampanye Sosial Umum --</option>
                    @foreach($disasters as $disaster)
                        <option value="{{ $disaster->id }}" @selected(old('disaster_id', $campaign->disaster_id) == $disaster->id)>{{ $disaster->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Target Dana (Rp)</label>
                <input type="number" name="target_amount" value="{{ old('target_amount', $campaign->target_amount ?? 50000000) }}" min="100000" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Batas Waktu (Deadline)</label>
                <input type="date" name="deadline" value="{{ old('deadline', optional($campaign->deadline)->format('Y-m-d') ?? now()->addDays(30)->format('Y-m-d')) }}" class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Status Kampanye</label>
                <select name="status" class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
                    @foreach(['active' => 'Aktif', 'draft' => 'Draft', 'completed' => 'Selesai', 'closed' => 'Ditutup'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('status', $campaign->status ?? 'active') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">URL Gambar Thumbnail (Opsional)</label>
            <input type="url" name="thumbnail" value="{{ old('thumbnail', $campaign->thumbnail) }}" placeholder="https://images.unsplash.com/..." class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Deskripsi & Rencana Penyaluran Dana</label>
            <textarea name="description" rows="6" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-2.5 text-sm">{{ old('description', $campaign->description) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-3 rounded-xl bg-[#1B4332] hover:bg-[#2D6A4F] text-white text-xs font-bold cursor-pointer">
                Simpan Kampanye
            </button>
            <a href="{{ route('admin.campaigns.index') }}" class="px-5 py-3 rounded-xl border border-[#D2C49E] text-xs font-bold text-[#4A5750]">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection