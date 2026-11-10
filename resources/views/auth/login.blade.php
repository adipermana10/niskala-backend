@extends('layouts.app')

@section('title', 'Masuk Akun — Niskala')

@section('content')
<section class="py-14 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white border-2 border-[#D5D5D5] rounded-2xl overflow-hidden">
        <div class="bg-[#CD2E0E] p-7 text-center text-white border-b-4 border-[#F79301]">
            <span class="inline-block px-3 py-1 rounded-lg bg-[#F79301] text-[#1E1E1E] text-[11px] font-extrabold uppercase tracking-wider mb-2">
                Autentikasi Niskala
            </span>
            <h1 class="text-2xl font-extrabold">Masuk ke Akun Anda</h1>
            <p class="text-xs text-white/90 mt-1">Kelola donasi dan pantau informasi bencana terkini.</p>
        </div>

        <div class="p-7">
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-[#FDECE9] border-2 border-[#CD2E0E] text-xs font-bold text-[#CD2E0E]">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="emailInput" class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Alamat Email</label>
                    <input type="email" id="emailInput" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
                </div>

                <div>
                    <label for="passwordInput" class="block text-xs font-extrabold text-[#1E1E1E] uppercase mb-1.5">Kata Sandi</label>
                    <input type="password" id="passwordInput" name="password" required class="w-full rounded-xl border-2 border-[#D5D5D5] bg-[#F7F7F7] px-4 py-2.5 text-sm font-semibold focus:bg-white focus:border-[#CD2E0E] focus:outline-none">
                </div>

                <button type="submit" class="w-full bg-[#F79301] hover:bg-[#D97E00] text-[#1E1E1E] font-extrabold py-3 px-5 rounded-xl text-sm border-2 border-[#1E1E1E] transition cursor-pointer">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-6 pt-5 border-t-2 border-[#D5D5D5]">
                <p class="text-[11px] font-extrabold uppercase text-center text-[#1E1E1E]/70 mb-2.5">
                    Uji Cepat Akun Seeder
                </p>
                <div class="grid grid-cols-2 gap-2.5">
                    <button
                        type="button"
                        onclick="document.getElementById('emailInput').value='admin@niskala.id'; document.getElementById('passwordInput').value='password123';"
                        class="py-2 px-3 rounded-xl bg-[#CD2E0E] text-white text-xs font-extrabold cursor-pointer"
                    >
                        🔑 Akun Admin
                    </button>
                    <button
                        type="button"
                        onclick="document.getElementById('emailInput').value='raka@niskala.id'; document.getElementById('passwordInput').value='password123';"
                        class="py-2 px-3 rounded-xl bg-[#D5D5D5] text-[#1E1E1E] text-xs font-extrabold cursor-pointer"
                    >
                        👤 Akun Donatur
                    </button>
                </div>
            </div>

            <p class="mt-5 text-center text-xs font-bold text-[#1E1E1E]/80">
                Belum punya akun? <a href="{{ route('register') }}" class="text-[#CD2E0E] underline">Daftar di sini</a>
            </p>
        </div>
    </div>
</section>
@endsection