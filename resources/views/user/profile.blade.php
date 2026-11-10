@extends('layouts.app')

@section('title', 'Pengaturan Profil — Niskala')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-[#1B4332]">Pengaturan Profil Akun</h1>
            <p class="text-sm text-[#4A5750] mt-1">Kelola informasi pribadi dan keamanan akun Niskala Anda.</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 rounded-xl border border-[#D2C49E] text-xs font-bold text-[#1B4332] hover:bg-[#F4EFE6]">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-[#D8F3DC] border border-[#52B788] text-sm font-semibold text-[#1B4332]">
            🌿 {{ session('success') }}
        </div>
    @endif

    <!-- Form Biodata -->
    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 sm:p-8 shadow-xs">
        <h2 class="text-lg font-serif font-bold text-[#1B4332] mb-4">Informasi Pribadi</h2>
        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-3 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Nomor Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-3 text-sm">
            </div>

            <button type="submit" class="px-6 py-3 rounded-xl bg-[#1B4332] hover:bg-[#2D6A4F] text-white text-xs font-bold cursor-pointer">
                Simpan Perubahan Profil
            </button>
        </form>
    </div>

    <!-- Form Ganti Password -->
    <div class="bg-white border border-[#E6DEC8] rounded-3xl p-6 sm:p-8 shadow-xs">
        <h2 class="text-lg font-serif font-bold text-[#1B4332] mb-4">Perbarui Kata Sandi</h2>
        <form action="{{ route('user.profile.password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-3 text-sm">
                    @error('current_password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Kata Sandi Baru</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-3 text-sm">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-[#4A5750] mb-1.5">Konfirmasi Sandi Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-xl border border-[#D2C49E] bg-[#FAF8F5] px-4 py-3 text-sm">
                </div>
            </div>

            <button type="submit" class="px-6 py-3 rounded-xl bg-[#1B4332] hover:bg-[#2D6A4F] text-white text-xs font-bold cursor-pointer">
                Perbarui Kata Sandi
            </button>
        </form>
    </div>
</div>
@endsection