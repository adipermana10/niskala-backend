@extends('layouts.app')

@section('title', 'Daftar Akun — Niskala')

@section('content')
<section class="py-14 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto bg-white border-2 border-[#D5D5D5] rounded-2xl overflow-hidden">
        <div class="bg-[#CD2E0E] p-7 text-center text-white border-b-4 border-[#F79301]">
            <span class="inline-block px-3 py-1 rounded-lg bg-[#F79301] text-[#1E1E1E] text-[11px] font-extrabold uppercase tracking-wider mb-2">
                Registrasi Sahabat Niskala
            </span>
            <h1 class="text-2xl font-extrabold">Buat Akun Baru</h1>
        </div>

        <div class="p-7">
            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1">Kata Sandi</label>
                        <input type="password" name="password" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold py-3 px-5 rounded-xl text-sm border-2 border-[#1E1E1E] transition cursor-pointer">
                    Daftar Sekarang
                </button>
            </form>
        </div>
    </div>
</section>
@endsection