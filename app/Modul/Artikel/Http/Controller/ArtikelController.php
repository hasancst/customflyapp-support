<?php

namespace App\Modul\Artikel\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Artikel\Model\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function indeks()
    {
        $artikel = Artikel::with('penulis')->latest()->get();
        return view('artikel::indeks', compact('artikel'));
    }

    public function tambah()
    {
        return view('artikel::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        Artikel::create([
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'isi' => $request->isi,
            'status' => 'terbit',
            'penulis_id' => auth()->id() ?? 1,
        ]);

        return redirect('/admin/artikel')->with('berhasil', 'Artikel berhasil disimpan.');
    }

    public function edit(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($request->get('panel')) {
            return view('artikel::edit_panel', compact('artikel'));
        }
        return view('artikel::edit', compact('artikel'));
    }

    public function perbarui(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->update([
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'isi' => $request->isi,
        ]);

        if ($request->ajax() || $request->get('panel')) {
            return response()->json(['berhasil' => true, 'pesan' => 'Artikel berhasil diperbarui.']);
        }

        return redirect('/admin/artikel')->with('berhasil', 'Artikel berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        return redirect('/admin/artikel')->with('berhasil', 'Artikel berhasil dihapus.');
    }

    public function aiBantu(Request $request)
    {
        $request->validate([
            'perintah' => 'required|string',
            'judul' => 'nullable|string',
            'isi' => 'nullable|string',
        ]);

        $settings = \DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        $apiKey = $settings['ai_gemini_key'] ?? null;
        $model = $settings['ai_gemini_model'] ?? 'gemini-flash-latest';

        if (!$apiKey) {
            return response()->json(['berhasil' => false, 'pesan' => 'API Key Gemini belum diatur di Pengaturan.']);
        }

        $perintah = $request->perintah;
        $judul = $request->judul ?: '';
        $isi = strip_tags($request->isi ?: '');

        $prompt = "Kamu adalah AI Assistant Content Strategist & SEO Expert untuk Artikel.
Instruksi: $perintah.

DATA INPUT:
- Judul: $judul
- Konten: $isi
" . ($judul ? "" : "(Jika judul kosong, buatkan judul artikel yang menarik)") . "

TUGAS:
1. Analisis data input.
2. Lakukan instruksi di atas dengan tepat untuk mengoptimasi artikel.
3. Pastikan konten ramah SEO.

OUTPUT YANG DIHARAPKAN (FORMAT JSON):
{
  \"judul\": \"Judul artikel\",
  \"isi\": \"Konten lengkap dalam format HTML (gunakan tag <p>, <h3>, <strong>, <ul>, <ol>, <li> etc)\",
  \"alasan\": \"Singkat: apa yang telah ditingkatkan oleh AI?\"
}

PENTING: Hanya kembalikan JSON saja.";

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_NONE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_NONE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_NONE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_NONE',
                    ],
                ]
            ]);

            if ($response->failed()) {
                $error = $response->json()['error']['message'] ?? 'Connection error';
                return response()->json(['berhasil' => false, 'pesan' => 'Gagal dari Gemini: ' . $error . ' (HTTP ' . $response->status() . ')']);
            }

            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                return response()->json(['berhasil' => false, 'pesan' => 'Gemini tidak memberikan respon yang valid.']);
            }

            $text = trim($text);
            if (preg_match('/^```json\s+(.*?)\s+```$/s', $text, $matches)) {
                $text = $matches[1];
            } elseif (preg_match('/^```\s+(.*?)\s+```$/s', $text, $matches)) {
                $text = $matches[1];
            }
            
            if (!str_starts_with($text, '{')) {
                $start = strpos($text, '{');
                $end = strrpos($text, '}');
                if ($start !== false && $end !== false) {
                    $text = substr($text, $start, $end - $start + 1);
                }
            }

            $aiData = json_decode($text, true);
            if (!$aiData) {
                return response()->json([
                    'berhasil' => false, 
                    'pesan' => 'Gagal memproses format JSON dari AI. Silakan coba lagi.',
                    'debug_raw' => substr($text, 0, 100)
                ]);
            }

            return response()->json([
                'berhasil' => true,
                'data' => $aiData
            ]);

        } catch (\Exception $e) {
            return response()->json(['berhasil' => false, 'pesan' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
