<?php

namespace App\Modul\Tiket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Model\TiketKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiketKategoriController extends Controller
{
    public function index()
    {
        // Ambil hanya root categories (tanpa parent), load children secara rekursif
        $roots = TiketKategori::with(['children' => function ($q) {
                $q->orderBy('urutan')->orderBy('nama');
            }])
            ->whereNull('parent_id')
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        // Flatten: root → children (tampil hierarkis di view)
        $categories = collect();
        foreach ($roots as $root) {
            $categories->push($root);
            foreach ($root->children as $child) {
                $categories->push($child);
            }
        }

        return view('tiket::admin.category_index', compact('categories'));
    }

    /**
     * Generate slug unik, exclude ID tertentu saat update
     */
    private function generateUniqueSlug(string $nama, ?int $excludeId = null): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $counter = 2;

        while (true) {
            $query = TiketKategori::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:tiket_categories,id',
        ]);

        // Jika user isi slug manual, pakai itu (pastikan unik), jika tidak generate otomatis dari nama
        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug(Str::slug($request->slug))
            : $this->generateUniqueSlug($request->nama);

        TiketKategori::create([
            'nama'      => $request->nama,
            'slug'      => $slug,
            'parent_id' => $request->parent_id ?: null,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->has('aktif') ? true : false,
        ]);

        return back()->with('berhasil', 'Kategori tiket berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $cat = TiketKategori::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:tiket_categories,id',
        ]);

        // Prevent category from being its own parent
        if ($request->parent_id == $id) {
            return back()->with('error', 'Kategori tidak dapat menjadi induk dari dirinya sendiri.');
        }

        // Prevent circular reference
        if ($request->parent_id) {
            $checkParent = TiketKategori::find($request->parent_id);
            while ($checkParent) {
                if ($checkParent->parent_id == $id) {
                    return back()->with('error', 'Tidak dapat membuat circular reference.');
                }
                $checkParent = $checkParent->parent;
            }
        }

        // Slug: pakai input manual jika diisi, jika tidak generate dari nama
        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug(Str::slug($request->slug), $id)
            : $this->generateUniqueSlug($request->nama, $id);

        $cat->update([
            'nama'      => $request->nama,
            'slug'      => $slug,
            'parent_id' => $request->parent_id ?: null,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->has('aktif') ? true : false,
        ]);

        return back()->with('berhasil', 'Kategori tiket berhasil diperbarui.');
    }

    public function delete($id)
    {
        TiketKategori::findOrFail($id)->delete();
        return back()->with('berhasil', 'Kategori tiket berhasil dihapus.');
    }
}
