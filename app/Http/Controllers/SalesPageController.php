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
    private function generateSalesPage(Request $request)
    {
        $apiKey = env('GEMINI_API_KEY');
        
        $prompt = "Buatkan sales page yang panjang, detail, dan meyakinkan untuk produk berikut. Hasilkan dalam format JSON valid tanpa teks lain di luar JSON. Gunakan struktur ini:
{
    \"headline\": \"judul utama yang menarik dan powerful (minimal 10 kata)\",
    \"subheadline\": \"subjudul yang mendukung headline (minimal 8 kata)\",
    \"description\": \"deskripsi produk yang panjang, minimal 4 kalimat, menjelaskan manfaat dan keunggulan produk secara detail\",
    \"benefits\": [\"benefit 1 yang detail (minimal 10 kata)\", \"benefit 2 yang detail (minimal 10 kata)\", \"benefit 3 yang detail (minimal 10 kata)\", \"benefit 4 yang detail (minimal 10 kata)\"],
    \"price_display\": \"Rp xxx.xxx dengan embel-embel menarik seperti 'Diskon 20%' atau 'Harga spesial'\",
    \"cta\": \"Call to action yang menggugah, minimal 6 kata\"
}

Data produk:
Nama Produk: {$request->product_name}
Deskripsi: {$request->product_description}
Target Audiens: {$request->target_audience}
Harga: Rp {$request->price}
USP: {$request->usp}

Hasilkan sales page yang panjang, detail, dan meyakinkan untuk mendorong pembelian. Manfaat minimal 4 poin dengan deskripsi yang detail.";

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
            
            // Log untuk debugging
            Log::info('Gemini Response:', $result);
            
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
            $text = preg_replace('/```json\n?|\n?```/', '', $text);
            $text = trim($text);
            $decoded = json_decode($text, true);
            
            if (!is_array($decoded) || empty($decoded) || !isset($decoded['headline'])) {
                return $this->fallbackContent($request);
            }
            
            return $decoded;
            
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            return $this->fallbackContent($request);
        }
    }
    
    // Fallback jika API gagal (dibuat lebih panjang dan menarik seperti versi awal)
    private function fallbackContent(Request $request)
    {
        $benefits = array_map('trim', explode(',', $request->usp));
        
        // Jika benefits kurang dari 4, tambahkan default
        $defaultBenefits = [
            "Kualitas produk terjamin dan sudah teruji",
            "Harga terbaik di pasaran dengan kualitas premium",
            "Garansi resmi dan layanan purna jual terpercaya",
            "Pengiriman cepat dan aman ke seluruh Indonesia"
        ];
        
        while (count($benefits) < 4) {
            $benefits[] = $defaultBenefits[count($benefits)];
        }
        
        // Perkaya setiap benefit agar lebih panjang dan detail
        $detailedBenefits = [];
        foreach ($benefits as $index => $benefit) {
            $detailedBenefits[] = $benefit . " – " . [
                "Dapatkan produk berkualitas dengan standar tertinggi yang sudah melalui proses seleksi ketat.",
                "Nikmati harga spesial yang tidak akan Anda temukan di tempat lain untuk produk sekelas ini.",
                "Tenang dengan garansi resmi dan dukungan customer service yang siap membantu 24/7.",
                "Proses pengiriman cepat, aman, dan gratis untuk area tertentu."
            ][$index % 4];
        }
        
        // Buat deskripsi yang panjang (4-5 kalimat)
        $longDescription = $request->product_description . " ";
        $longDescription .= "Produk ini dirancang khusus untuk {$request->target_audience} yang menginginkan solusi terbaik dan berkualitas. ";
        $longDescription .= "Dengan material premium dan teknologi terkini, {$request->product_name} siap memberikan pengalaman terbaik bagi Anda. ";
        $longDescription .= "Tidak hanya itu, produk ini juga dilengkapi dengan berbagai fitur unggulan yang akan memudahkan aktivitas sehari-hari Anda. ";
        $longDescription .= "Jangan lewatkan kesempatan untuk memiliki {$request->product_name} dengan harga spesial. ";
        $longDescription .= "Kualitas terbaik, harga terjangkau, kepuasan Anda adalah prioritas kami!";
        
        // Buat headline yang lebih panjang dan menarik
        $headline = "✨ " . $request->product_name . " – Solusi Terbaik untuk " . $request->target_audience . "! ✨";
        
        // Buat subheadline yang mendukung
        $subheadline = "Temukan produk berkualitas dengan harga terbaik hanya di sini. " .
                        "Nikmati berbagai keunggulan yang tidak akan Anda temukan di tempat lain. " .
                        "Kepuasan Anda adalah prioritas utama kami!";
        
        // Buat price display yang menarik
        $priceDisplay = "Rp " . number_format($request->price, 0, ',', '.');
        if ($request->price >= 100000) {
            $priceDisplay = "Harga Spesial: " . $priceDisplay . " (Diskon 10% untuk pembelian pertama!)";
        } else {
            $priceDisplay = "💰 " . $priceDisplay . " – Murah dan Berkualitas! 💰";
        }
        
        // Buat CTA yang lebih menarik
        $ctaOptions = [
            "🎯 Beli Sekarang dan Dapatkan Diskon Spesial + Gratis Ongkir! 🎯",
            "🔥 Ambillah Produk Ini Sekarang Juga Sebelum Kehabisan! 🔥",
            "⭐ Jangan Lewatkan Kesempatan Emas Ini – Order Sekarang! ⭐",
            "🚀 Order Sekarang, Stok Terbatas – Garansi Uang Kembali! 🚀",
            "💎 Dapatkan Penawaran Terbaik Hari Ini – Klik Sekarang! 💎"
        ];
        $cta = $ctaOptions[array_rand($ctaOptions)];
        
        return [
            'headline' => $headline,
            'subheadline' => $subheadline,
            'description' => $longDescription,
            'benefits' => $detailedBenefits,
            'price_display' => $priceDisplay,
            'cta' => $cta
        ];
    }
}