@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('sales-pages.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">🚀 Buat Sales Page Baru</h1>
            <p class="text-gray-500 text-sm mt-1">Isi data produk, AI akan membuatkan sales page profesional</p>
        </div>

        <form method="POST" action="{{ route('sales-pages.store') }}" id="generate-form">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="product_name" required placeholder="Contoh: Kursi Ergonomis Premium"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="product_description" rows="4" required placeholder="Jelaskan produk Anda secara detail..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Audiens <span class="text-red-500">*</span></label>
                    <input type="text" name="target_audience" required placeholder="Contoh: Karyawan kantoran, ibu rumah tangga"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" required placeholder="1500000"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unique Selling Points (USP) <span class="text-red-500">*</span></label>
                    <textarea name="usp" rows="2" required placeholder="Contoh: Garansi 5 tahun, Free ongkir, 30 day money back"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Pisahkan setiap poin dengan koma</p>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 rounded-xl transition shadow-md hover:shadow-lg">
                    ✨ Generate Sales Page
                </button>
            </div>
        </form>
    </div>
</div>
@endsection