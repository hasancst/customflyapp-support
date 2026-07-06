<?php

namespace App\Modul\Video\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\Video\Model\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function indeks()
    {
        $video = Video::latest()->get();
        return view('video::indeks', compact('video'));
    }

    public function tambah()
    {
        return view('video::tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'url' => 'required|url',
        ]);

        $keterangan = $request->keterangan;
        
        // Auto-fill keterangan from Youtube (DISABLED - Use Client Side Fetch)
        // if (empty($keterangan) && preg_match('/(youtube\.com|youtu\.be)/', $request->url)) {
        //     $keterangan = $this->getYoutubeInfo($request->url) ?? 'Video dari Youtube';
        // }

        try {
            if ($request->has('unggulan')) {
                Video::where('unggulan', true)->update(['unggulan' => false]);
            }

            Video::create([
                'judul' => $request->judul,
                'slug' => str()->slug($request->judul),
                'url' => $request->url,
                'keterangan' => $keterangan,
                'aktif' => true,
                'unggulan' => $request->has('unggulan')
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Video Save Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['url' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }

        return redirect('/admin/video')->with('berhasil', 'Video berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        $video = Video::findOrFail($id);
        return view('video::ubah', compact('video'));
    }

    public function perbarui(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        
        $request->validate([
            'judul' => 'required',
            'url' => 'required|url',
        ]);

        $keterangan = $request->keterangan;

        // Auto-fill keterangan from Youtube (DISABLED - Use Client Side Fetch)
        // if (empty($keterangan) && preg_match('/(youtube\.com|youtu\.be)/', $request->url)) {
        //     $keterangan = $this->getYoutubeInfo($request->url) ?? 'Video dari Youtube';
        // }

        if ($request->has('unggulan')) {
            Video::where('id', '!=', $id)->where('unggulan', true)->update(['unggulan' => false]);
        }

        $video->update([
            'judul' => $request->judul,
            'slug' => str()->slug($request->judul),
            'url' => $request->url,
            'keterangan' => $keterangan,
            'aktif' => $request->has('aktif'),
            'unggulan' => $request->has('unggulan')
        ]);

        return redirect('/admin/video')->with('berhasil', 'Video berhasil diperbarui.');
    }

    public function fetchInfo(Request $request)
    {
        $url = $request->url;
        if (empty($url)) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        // Ensure URL has protocol
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            $info = $this->getYoutubeInfo($url);
            if ($info) {
                return response()->json($info);
            }
        }

        return response()->json(['error' => 'Gagal mengambil data video. Pastikan video publik.'], 404);
    }

    private function getYoutubeInfo($url)
    {
        try {
            $oembedUrl = 'https://www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $oembedUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                return json_decode($response, true);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Fetch Video Info Error: ' . $e->getMessage());
            return null;
        }
        return null;
    }

    public function hapus($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect('/admin/video')->with('berhasil', 'Video berhasil dihapus.');
    }
}
