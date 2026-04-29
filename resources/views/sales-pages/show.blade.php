@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('sales-pages.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1">
            ← Kembali ke Riwayat
        </a>
        <button onclick="exportToHTML()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-5 rounded-xl transition shadow-md flex items-center gap-2">
            📥 Export HTML
        </button>
    </div>

    <div id="sales-page-content" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            @if(isset($content['headline']))
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ $content['headline'] }}
                </h1>
            @endif

            @if(isset($content['subheadline']))
                <p class="text-gray-500 text-base md:text-lg mb-6 italic">
                    {{ $content['subheadline'] }}
                </p>
            @endif

            @if(isset($content['description']))
                <div class="border-t border-gray-100 pt-6 mb-6">
                    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-3">📖 Deskripsi</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $content['description'] }}</p>
                </div>
            @endif

            @if(isset($content['benefits']) && is_array($content['benefits']))
                <div class="border-t border-gray-100 pt-6 mb-6">
                    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-4">✅ Manfaat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($content['benefits'] as $benefit)
                            <div class="flex items-start gap-2">
                                <svg class="check-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span class="text-gray-700 text-sm">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="border-t border-gray-100 pt-6 mb-6">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-5 text-center">
                    <span class="text-sm text-gray-500 uppercase tracking-wide">💰 Harga</span>
                    @if(isset($content['price_display']))
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $content['price_display'] }}</p>
                    @else
                        <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($page->price, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>

            @if(isset($content['cta']))
                <div class="border-t border-gray-100 pt-6 text-center">
                    <button class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold px-8 py-3 rounded-xl transition shadow-md">
                        {{ $content['cta'] }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .check-icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }
</style>

<script>
function exportToHTML() {
    // Ambil konten dan bersihkan class Tailwind yang tidak perlu
    let content = document.getElementById('sales-page-content').innerHTML;
    
    // Ganti class Tailwind dengan style inline atau class custom
    content = content.replace(/class="([^"]*)"/g, function(match, classes) {
        // Simpan class essential, buang yang tidak perlu
        return 'class="' + classes + '"';
    });
    
    const fullHTML = `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Page Export</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9edf2 100%);
            padding: 2rem;
            line-height: 1.5;
        }
        .max-w-4xl {
            max-width: 56rem;
            margin: 0 auto;
        }
        .bg-white {
            background: white;
        }
        .rounded-2xl {
            border-radius: 1rem;
        }
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .border {
            border-width: 1px;
        }
        .border-gray-100 {
            border-color: #f3f4f6;
        }
        .overflow-hidden {
            overflow: hidden;
        }
        .p-6 {
            padding: 1.5rem;
        }
        .md\\\\:p-8 {
            padding: 2rem;
        }
        .text-2xl {
            font-size: 1.5rem;
        }
        .md\\\\:text-3xl {
            font-size: 1.875rem;
        }
        .font-bold {
            font-weight: 700;
        }
        .text-gray-900 {
            color: #111827;
        }
        .mb-3 {
            margin-bottom: 0.75rem;
        }
        .leading-tight {
            line-height: 1.25;
        }
        .text-gray-500 {
            color: #6b7280;
        }
        .text-base {
            font-size: 1rem;
        }
        .md\\\\:text-lg {
            font-size: 1.125rem;
        }
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        .italic {
            font-style: italic;
        }
        .border-t {
            border-top-width: 1px;
        }
        .pt-6 {
            padding-top: 1.5rem;
        }
        .text-sm {
            font-size: 0.875rem;
        }
        .font-semibold {
            font-weight: 600;
        }
        .text-gray-400 {
            color: #9ca3af;
        }
        .uppercase {
            text-transform: uppercase;
        }
        .tracking-wide {
            letter-spacing: 0.025em;
        }
        .mb-3 {
            margin-bottom: 0.75rem;
        }
        .text-gray-700 {
            color: #374151;
        }
        .leading-relaxed {
            line-height: 1.625;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        .grid {
            display: grid;
        }
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        .md\\\\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .gap-3 {
            gap: 0.75rem;
        }
        .flex {
            display: flex;
        }
        .items-start {
            align-items: flex-start;
        }
        .gap-2 {
            gap: 0.5rem;
        }
        .check-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }
        .from-gray-50 {
            --tw-gradient-from: #f9fafb;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-gray-100 {
            --tw-gradient-to: #f3f4f6;
        }
        .rounded-xl {
            border-radius: 0.75rem;
        }
        .p-5 {
            padding: 1.25rem;
        }
        .text-center {
            text-align: center;
        }
        .text-2xl {
            font-size: 1.5rem;
        }
        .mt-1 {
            margin-top: 0.25rem;
        }
        .from-orange-500 {
            --tw-gradient-from: #f97316;
        }
        .to-red-500 {
            --tw-gradient-to: #ef4444;
        }
        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        @media (min-width: 768px) {
            .md\\\\:p-8 {
                padding: 2rem;
            }
            .md\\\\:text-3xl {
                font-size: 1.875rem;
            }
            .md\\\\:text-lg {
                font-size: 1.125rem;
            }
            .md\\\\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            .p-6 {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="max-w-4xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8">
                ${content}
            </div>
        </div>
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
    
    alert('✅ File HTML berhasil di download!');
}
</script>
@endsection