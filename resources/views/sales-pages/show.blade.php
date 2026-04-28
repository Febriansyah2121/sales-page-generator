@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('sales-pages.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        ← Kembali
    </a>
    <button onclick="exportToHTML()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transition duration-200 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        Export HTML
    </button>
</div>

    <div id="sales-page-content" class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8">
            @if(isset($content['headline']))
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ $content['headline'] }}
                </h1>
            @endif

            @if(isset($content['subheadline']))
                <p class="text-gray-500 text-base md:text-lg mb-6">
                    {{ $content['subheadline'] }}
                </p>
            @endif

            @if(isset($content['description']))
                <div class="border-t border-gray-100 pt-6 mb-6">
                    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-3">Deskripsi</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $content['description'] }}</p>
                </div>
            @endif

            @if(isset($content['benefits']) && is_array($content['benefits']))
                <div class="border-t border-gray-100 pt-6 mb-6">
                    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-4">Manfaat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($content['benefits'] as $benefit)
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700 text-sm">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="border-t border-gray-100 pt-6 mb-6">
                <div class="bg-gray-50 rounded-lg p-5 text-center">
                    <span class="text-sm text-gray-500 uppercase tracking-wide">Harga</span>
                    @if(isset($content['price_display']))
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $content['price_display'] }}</p>
                    @else
                        <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($page->price, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>

            @if(isset($content['cta']))
                <div class="border-t border-gray-100 pt-6 text-center">
                    <button class="bg-gray-900 hover:bg-gray-800 text-white font-medium px-8 py-3 rounded-lg transition">
                        {{ $content['cta'] }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function exportToHTML() {
    const content = document.getElementById('sales-page-content').innerHTML;
    const fullHTML = `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Page - {{ $page->product_name }}</title>
    <script src="https://cdn.tailwindcss.com"><\/script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; padding: 2rem; }
        @media (max-width: 640px) { body { padding: 1rem; } }
    </style>
</head>
<body>
    <div class="max-w-4xl mx-auto">
        ${content}
    </div>
</body>
</html>`;
    const blob = new Blob([fullHTML], {type: 'text/html'});
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.download = 'sales-page-' + Date.now() + '.html';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    alert('File HTML berhasil di download!');
}
</script>
@endsection