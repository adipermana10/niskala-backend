@extends('layouts.admin')

@section('title', 'Kelola Kategori — Admin Niskala')
@section('header', 'Manajemen Kategori Bencana & Kampanye')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Form Tambah Kategori -->
    <div class="lg:col-span-4 bg-white border border-[#E6DEC8] rounded-3xl p-6 h-fit">
        <h2 class="text-base font-serif font-bold text-[#1B4332] mb-4">Tambah Kategori Baru</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1">Nama Kategori</label>
                <input type="text" name="name" required placeholder="Contoh: Kekeringan Ekstrem" class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-3.5 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1">Deskripsi Singkat</label>
                <textarea name="description" rows="3" placeholder="Penjelasan fokus kategori..." class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-3.5 py-2.5 text-sm"></textarea>
            </div>
            <button type="submit" class="w-full bg-[#1B4332] hover:bg-[#2D6A4F] text-white font-bold py-3 rounded-xl text-xs cursor-pointer">
                + Simpan Kategori
            </button>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="lg:col-span-8 bg-white border border-[#E6DEC8] rounded-3xl p-6">
        <h2 class="text-base font-serif font-bold text-[#1B4332] mb-4">Daftar Kategori Terdaftar</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#E6DEC8] text-xs uppercase text-[#4A5750]">
                        <th class="py-3 px-3">Nama Kategori</th>
                        <th class="py-3 px-3">Bencana</th>
                        <th class="py-3 px-3">Kampanye</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4EFE6]">
                    @foreach($categories as $category)
                        <tr>
                            <td class="py-3.5 px-3">
                                <p class="font-bold text-[#1B4332]">{{ $category->name }}</p>
                                <p class="text-xs text-[#4A5750]">{{ $category->description }}</p>
                            </td>
                            <td class="py-3.5 px-3 text-xs font-semibold">{{ $category->disasters_count }} laporan</td>
                            <td class="py-3.5 px-3 text-xs font-semibold">{{ $category->campaigns_count }} program</td>
                            <td class="py-3.5 px-3 text-right">
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection