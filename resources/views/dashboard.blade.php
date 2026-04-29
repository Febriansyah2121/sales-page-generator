@extends('layouts.app')

@section('content')
<div class="space-y-8">
    {{-- Hero Welcome --}}
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}! 🎉</h1>
        <p class="text-blue-100">Buat sales page berkualitas dengan bantuan AI dalam hitungan detik.</p>
    </div>

    {{-- Quick Action --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Buat Sales Page Baru</h2>
                    <p class="text-gray-500 text-sm">Masukkan data produk, AI akan membuatkan halaman jualan</p>
                </div>
                <a href="{{ route('sales-pages.create') }}" class="ml-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">
                    Buat →
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Riwayat Sales Page</h2>
                    <p class="text-gray-500 text-sm">Lihat semua sales page yang sudah dibuat</p>
                </div>
                <a href="{{ route('sales-pages.index') }}" class="ml-auto bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-xl transition">
                    Lihat →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection