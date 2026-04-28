@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('sales-pages.index') }}" class="text-gray-500 hover:text-gray-700 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 md:p-8">
        <h1 class="text-xl font-bold text-gray-900 mb-2">Buat Sales Page Baru</h1>
        <p class="text-gray-500 text-sm mb-6">Isi data produk, AI akan membuatkan halaman sales yang menarik</p>

        <form method="POST" action="{{ route('sales-pages.store') }}">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="product_name" required placeholder="Contoh: Kursi Ergonomis Premium"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                    <textarea name="product_description" rows="3" required placeholder="Jelaskan produk Anda secara detail..."
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Audiens</label>
                    <input type="text" name="target_audience" required placeholder="Contoh: Karyawan kantoran, ibu rumah tangga"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" required placeholder="1500000"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unique Selling Points (USP)</label>
                    <textarea name="usp" rows="2" required placeholder="Contoh: Garansi 5 tahun, Free ongkir, 30 day money back"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition"></textarea>
                    <p class="text-gray-400 text-xs mt-1">Pisahkan setiap poin dengan koma</p>
                </div>

                <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 rounded-xl transition mt-4">
                    Generate Sales Page →
                </button>
            </div>
        </form>
    </div>
</div>
@endsection