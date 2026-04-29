@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('sales-pages.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
        <h1 class="text-xl font-bold text-gray-900 mb-2">Edit Sales Page</h1>
        <p class="text-gray-500 text-sm mb-6">Ubah data produk, lalu generate ulang dengan AI</p>

        <form method="POST" action="{{ route('sales-pages.update', $page->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $page->product_name) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Audiens</label>
                    <input type="text" name="target_audience" value="{{ old('target_audience', $page->target_audience) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $page->price) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">USP (pisahkan koma)</label>
                    <input type="text" name="usp" value="{{ old('usp', $page->usp) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                <textarea name="product_description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2">{{ old('product_description', $page->product_description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('sales-pages.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update & Generate Ulang</button>
            </div>
        </form>
    </div>
</div>
@endsection