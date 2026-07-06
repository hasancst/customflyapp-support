<?php

namespace App\Modul\Pengguna\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function indeks()
    {
        $pengguna = User::latest()->get();
        return view('pengguna::indeks', compact('pengguna'));
    }

    public function tambah()
    {
        return view('pengguna::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pengguna,email',
            'kata_sandi' => 'required|min:6',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
        ]);

        return redirect('/admin/pengguna')->with('berhasil', 'Pengguna baru berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $user = User::findOrFail($id);
        return view('pengguna::ubah', compact('user'));
    }

    public function perbarui(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pengguna,email,' . $id,
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        if ($request->filled('kata_sandi')) {
            $request->validate(['kata_sandi' => 'min:6']);
            $data['kata_sandi'] = Hash::make($request->kata_sandi);
        }

        $user->update($data);

        return redirect('/admin/pengguna')->with('berhasil', 'Data pengguna berhasil diperbarui.');
    }

    public function hapus($id)
    {
        if (auth()->id() == $id) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun sendiri.']);
        }

        User::destroy($id);
        return back()->with('berhasil', 'Pengguna berhasil dihapus.');
    }
}
