@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Verifikasi WhatsApp</h2>
            <p class="text-gray-500 mt-2">Verifikasi nomor WhatsApp Anda untuk mengaktifkan akun</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- SIMULASI OTP - TAMPILKAN KODE OTP DI HALAMAN (UNTUK TESTING) --}}
        @if(session('simulation_otp'))
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🔐</span>
                    <div>
                        <strong class="font-semibold">Mode Simulasi</strong><br>
                        Kode OTP Anda: <strong class="text-lg">{{ session('simulation_otp') }}</strong><br>
                        <span class="text-xs">(Kode ini hanya muncul untuk testing, nanti akan diganti dengan WhatsApp sebenarnya)</span>
                    </div>
                </div>
            </div>
        @endif

        @if(!Auth::user()->phone_verified_at)
            @if(!Auth::user()->phone)
                <form method="POST" action="{{ route('send.otp') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="tel" name="phone" id="phone" required 
                            placeholder="085161445248"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Masukkan nomor WhatsApp aktif (contoh: 085161445248)</p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Kirim Kode OTP
                    </button>
                </form>
            @else
                <div class="text-center mb-6">
                    <p class="text-gray-600">Kode OTP telah dikirim ke:</p>
                    <p class="font-medium text-gray-900">{{ Auth::user()->phone }}</p>
                </div>

                <form method="POST" action="{{ route('verify.otp') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Kode OTP (6 digit)</label>
                        <input type="text" name="otp" id="otp" required maxlength="6"
                            placeholder="123456"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Verifikasi Sekarang
                    </button>
                </form>

                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('resend.otp') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-700">
                            Kirim ulang kode OTP
                        </button>
                    </form>
                </div>
            @endif
        @else
            <div class="text-center">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                    ✅ WhatsApp sudah diverifikasi!
                </div>
                <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Ke Dashboard →
                </a>
            </div>
        @endif
    </div>
</div>
@endsection