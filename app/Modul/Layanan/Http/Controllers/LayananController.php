<?php

namespace App\Modul\Layanan\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Layanan\Model\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public static function defaultSuites(): array
    {
        return [
            [
                'eyebrow' => '01. CUSTOMFLY • LIVE 2D VISUAL CUSTOMIZER',
                'color' => '#f77062',
                'btn_bg' => 'linear-gradient(135deg, #f77062 0%, #fe5196 100%)',
                'btn_shadow' => '0 10px 28px rgba(247, 112, 98, 0.35)',
                'title' => 'Interactive Visual Customization & Real-Time Preview',
                'desc' => 'Allow customers to personalize products with live drag-and-drop text, custom fonts, monograms, clipart, colorways, and photo uploads with instant real-time multi-angle mockup previews.',
                'chips' => [
                    'Live Multi-View Switcher (Front, Back, Side)',
                    'Advanced Curved Text, Monograms & Custom Fonts',
                    'Instant Colorway Switching & Dynamic Swatch Matrix',
                    'Interactive Live Multi-View Mockup Synchronization',
                ],
                'cta' => 'Explore Customfly App',
                'url' => '/blog/customfly-review-the-ultimate-interactive-product-personalizer-for-shopify-stores',
                'image' => asset('theme/imakecustom/img/suite/customfly-canvas.png'),
                'reversed' => false,
            ],
            [
                'eyebrow' => '02. UPLOADFLY • HIGH-RES UPLOADS & PRINT-READY AUTOMATION',
                'color' => '#a855f7',
                'btn_bg' => 'linear-gradient(135deg, #a855f7 0%, #6366f1 100%)',
                'btn_shadow' => '0 10px 28px rgba(168, 85, 247, 0.35)',
                'title' => 'Seamless Multi-Format Artwork Uploads & 300+ DPI Export',
                'desc' => 'Give your customers the freedom to upload artwork in any format. Automatically generate vector SVGs and 300+ DPI print files scaled to manufacturer print areas, syncing directly with Print-on-Demand (POD) suppliers.',
                'chips' => [
                    'Supports PNG, JPG, PDF, SVG, AI, PSD, EPS & More',
                    'Automated 300+ DPI Output with Vector Bleed & Cut Lines',
                    'In-Browser Drag, Drop, Crop, Resize, Rotate & Enhance',
                    'Automated Sync with POD Suppliers & Print Workshops',
                ],
                'cta' => 'Explore Uploadfly App',
                'url' => '/blog/uploadfly-the-best-shopify-file-uploader-app-for-custom-products-conditional-logic-dynamic-pricing',
                'image' => asset('theme/imakecustom/img/suite/uploadfly-dashboard.png'),
                'reversed' => true,
            ],
            [
                'eyebrow' => '03. OPTIONFLY • UNLIMITED OPTIONS & CONDITIONAL LOGIC',
                'color' => '#38bdf8',
                'btn_bg' => 'linear-gradient(135deg, #00a0f0 0%, #2563eb 100%)',
                'btn_shadow' => '0 10px 28px rgba(0, 160, 240, 0.35)',
                'title' => 'Custom Product Options with Smart Conditional Logic',
                'desc' => "Break free from Shopify's 1000+ variant limit. Build rich custom option sets with image and color swatches, dynamic conditional display rules, and automated real-time add-on price calculations.",
                'chips' => [
                    'Unlimited Custom Options Beyond Shopify 1000+ Variants',
                    'Smart Conditional Display Logic & Field Dependencies',
                    'Rich Visual Swatches (Color, Image, Pattern, Texture)',
                    'Live Add-On Pricing & Automated Cart Subtotal Sync',
                ],
                'cta' => 'Explore Optionfly App',
                'url' => 'https://demo.imakecustom.com/pages/optionfly',
                'image' => asset('theme/imakecustom/img/suite/optionfly-editor.png'),
                'reversed' => false,
            ],
        ];
    }

    public function indeks()
    {
        $layanans = Layanan::orderBy('urutan')->get();
        $pengaturan = DB::table('pengaturan')
            ->whereIn('kunci', ['suite_eyebrow', 'suite_title', 'suite_items_json'])
            ->pluck('nilai', 'kunci')
            ->toArray();

        $suiteEyebrow = $pengaturan['suite_eyebrow'] ?? 'COMPLETE 3-SUITE PLATFORM';
        $suiteTitle = $pengaturan['suite_title'] ?? 'Customfly • Uploadfly • Optionfly — Complete Personalization Suite';
        $decodedSuites = !empty($pengaturan['suite_items_json']) ? json_decode($pengaturan['suite_items_json'], true) : null;
        $suites = (is_array($decodedSuites) && count($decodedSuites) > 0) ? $decodedSuites : self::defaultSuites();

        return view('layanan::indeks', compact('layanans', 'suiteEyebrow', 'suiteTitle', 'suites'));
    }

    public function simpanSuite(Request $request)
    {
        $request->validate([
            'suite_eyebrow' => 'required|string|max:255',
            'suite_title' => 'required|string|max:255',
            'suites' => 'required|array|min:1',
        ]);

        $defaults = self::defaultSuites();
        $result = [];

        foreach ($request->input('suites') as $idx => $item) {
            $fallback = $defaults[$idx] ?? $defaults[0];
            $image = $item['existing_image'] ?? $fallback['image'];

            if ($request->hasFile("suite_image_{$idx}")) {
                $file = $request->file("suite_image_{$idx}");
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    return back()->withErrors(["suite_image_{$idx}" => 'Gambar harus berupa jpg, png, gif, atau webp.']);
                }
                $path = $file->store('suite', 'public');
                $image = '/storage/' . $path;
            }

            $chips = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $item['chips'] ?? ''))));

            $result[] = [
                'eyebrow' => trim($item['eyebrow'] ?? $fallback['eyebrow']),
                'color' => trim($item['color'] ?? $fallback['color']),
                'btn_bg' => $fallback['btn_bg'],
                'btn_shadow' => $fallback['btn_shadow'],
                'title' => trim($item['title'] ?? $fallback['title']),
                'desc' => trim($item['desc'] ?? $fallback['desc']),
                'chips' => $chips ?: $fallback['chips'],
                'cta' => trim($item['cta'] ?? $fallback['cta']),
                'url' => trim($item['url'] ?? $fallback['url']),
                'image' => $image,
                'reversed' => !empty($item['reversed']),
            ];
        }

        $rows = [
            'suite_eyebrow' => $request->input('suite_eyebrow'),
            'suite_title' => $request->input('suite_title'),
            'suite_items_json' => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ];

        foreach ($rows as $kunci => $nilai) {
            DB::table('pengaturan')->updateOrInsert(
                ['kunci' => $kunci],
                ['nilai' => $nilai, 'updated_at' => now()]
            );
        }

        return redirect('/admin/layanan')->with('berhasil', 'Pengaturan Complete 3-Suite Platform berhasil disimpan.');
    }

    public function tambah()
    {
        return view('layanan::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        Layanan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'ikon' => $request->ikon,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect('/admin/layanan')->with('berhasil', 'Layanan berhasil ditambahkan');
    }

    public function ubah($id)
    {
        $item = Layanan::findOrFail($id);
        return view('layanan::ubah', compact('item'));
    }

    public function perbarui(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $item = Layanan::findOrFail($id);
        $item->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'ikon' => $request->ikon,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect('/admin/layanan')->with('berhasil', 'Layanan berhasil diperbarui');
    }

    public function hapus($id)
    {
        $item = Layanan::findOrFail($id);
        $item->delete();
        return redirect('/admin/layanan')->with('berhasil', 'Layanan berhasil dihapus');
    }
}
