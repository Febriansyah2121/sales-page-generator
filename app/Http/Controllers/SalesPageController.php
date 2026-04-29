<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SalesPageController extends Controller
{
    // Menampilkan history
    public function index()
    {
        $pages = SalesPage::where('user_id', Auth::id())->latest()->get();
        return view('sales-pages.index', compact('pages'));
    }

    // Menampilkan form create
    public function create()
    {
        return view('sales-pages.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'target_audience' => 'required|string',
            'price' => 'required|numeric',
            'usp' => 'required|string',
        ]);

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

    // Menampilkan detail
    public function show($id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $content = json_decode($page->generated_content, true);
        return view('sales-pages.show', compact('page', 'content'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        return view('sales-pages.edit', compact('page'));
    }

    // Update data & generate ulang dengan AI
    public function update(Request $request, $id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'target_audience' => 'required|string',
            'price' => 'required|numeric',
            'usp' => 'required|string',
        ]);
        
        $generatedContent = $this->generateSalesPage($request);
        
        $page->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'target_audience' => $request->target_audience,
            'price' => $request->price,
            'usp' => $request->usp,
            'generated_content' => json_encode($generatedContent),
        ]);
        
        return redirect()->route('sales-pages.show', $page->id)->with('success', 'Sales page berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $page->delete();
        return redirect()->route('sales-pages.index')->with('success', 'Sales page dihapus!');
    }

    // Panggil AI API
    private function generateSalesPage($request)
    {
        $apiKey = env('GEMINI_API_KEY');
        
        $prompt = "Buatkan sales page untuk produk berikut dalam format JSON. Gunakan struktur ini:
{
    \"headline\": \"judul utama\",
    \"subheadline\": \"subjudul\",
    \"description\": \"deskripsi produk minimal 3 kalimat\",
    \"benefits\": [\"benefit 1\", \"benefit 2\", \"benefit 3\", \"benefit 4\"],
    \"price_display\": \"Rp xxx.xxx\",
    \"cta\": \"Beli Sekarang\"
}

Data produk:
Nama: {$request->product_name}
Deskripsi: {$request->product_description}
Target: {$request->target_audience}
Harga: Rp {$request->price}
USP: {$request->usp}

Hanya JSON, tanpa teks lain.";

        try {
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
            $text = preg_replace('/```json\n?|\n?```/', '', $text);
            $decoded = json_decode($text, true);
            
            if (!is_array($decoded) || empty($decoded)) {
                return $this->fallbackContent($request);
            }
            
            return $decoded;
            
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            return $this->fallbackContent($request);
        }
    }
    
    // Fallback jika API gagal
    private function fallbackContent($request)
    {
        $benefits = array_map('trim', explode(',', $request->usp));
        
        return [
            'headline' => $request->product_name . ' – Solusi Terbaik',
            'subheadline' => 'Temukan produk berkualitas di sini',
            'description' => $request->product_description,
            'benefits' => $benefits,
            'price_display' => 'Rp ' . number_format($request->price, 0, ',', '.'),
            'cta' => 'Beli Sekarang'
        ];
    }
}