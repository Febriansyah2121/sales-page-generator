<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesPage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class SalesPageController extends Controller
{
    public function index()
    {
        $pages = SalesPage::where('user_id', Auth::id())->latest()->get();
        return view('sales-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('sales-pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'target_audience' => 'required|string',
            'price' => 'required|numeric',
            'usp' => 'required|string',
        ]);

        // Panggil AI API
        $generatedContent = $this->generateSalesPage($request);

        SalesPage::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'target_audience' => $request->target_audience,
            'price' => $request->price,
            'usp' => $request->usp,
            'generated_content' => json_encode($generatedContent),
        ]);

        return redirect()->route('sales-pages.index')->with('success', 'Sales page berhasil dibuat!');
    }

    public function show($id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $content = json_decode($page->generated_content, true);
        return view('sales-pages.show', compact('page', 'content'));
    }

    public function destroy($id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $page->delete();
        return redirect()->route('sales-pages.index')->with('success', 'Sales page dihapus!');
    }

    private function generateSalesPage($request)
    {
        $apiKey = env('GEMINI_API_KEY');
        $prompt = "Buatkan sales page untuk produk berikut:

Nama Produk: {$request->product_name}
Deskripsi: {$request->product_description}
Target Audiens: {$request->target_audience}
Harga: Rp " . number_format($request->price, 0, ',', '.') . "
Unique Selling Points: {$request->usp}

Hasilkan dalam format JSON berikut:
{
    \"headline\": \"judul utama yang menarik\",
    \"subheadline\": \"subjudul pendukung\",
    \"description\": \"paragraf deskripsi produk\",
    \"benefits\": [\"benefit 1\", \"benefit 2\", \"benefit 3\"],
    \"price_display\": \"tampilan harga dengan diskon jika perlu\",
    \"cta\": \"tombol ajakan bertindak\"
}

Gunakan bahasa Indonesia yang persuasif dan profesional.";

        $response = Http::withHeaders([
    'Content-Type' => 'application/json',
])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        $result = $response->json();
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
        
        // Bersihkan JSON dari markdown
        $text = preg_replace('/```json\n?|\n?```/', '', $text);
        
        return json_decode($text, true);
    }
}