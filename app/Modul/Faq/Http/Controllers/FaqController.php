<?php

namespace App\Modul\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modul\Faq\Model\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function indeks()
    {
        $faq = Faq::orderBy('urutan')->get();
        return view('faq::indeks', compact('faq'));
    }

    public function tambah()
    {
        return view('faq::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        Faq::create([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            'urutan' => $request->urutan ?? 0,
            'aktif' => true,
        ]);

        return redirect('/admin/faq')->with('berhasil', 'FAQ berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $item = Faq::findOrFail($id);
        return view('faq::ubah', compact('item'));
    }

    public function perbarui(Request $request, $id)
    {
        $item = Faq::findOrFail($id);
        
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $item->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect('/admin/faq')->with('berhasil', 'FAQ berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $item = Faq::findOrFail($id);
        $item->delete();
        return redirect('/admin/faq')->with('berhasil', 'FAQ berhasil dihapus.');
    }
}
