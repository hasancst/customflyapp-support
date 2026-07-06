<?php

namespace App\Http\Controllers;

use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketLampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TiketUploadController extends Controller
{
    /**
     * POST /api/shopify/tickets/{id}/attachments
     * Upload satu atau lebih file untuk tiket yang sudah ada.
     * Menerima multipart/form-data dengan field files[] (array).
     */
    public function upload(Request $request, int $tiketId)
    {
        $tiket = Tiket::findOrFail($tiketId);

        $request->validate([
            'files'   => 'required|array|min:1|max:5',
            'files.*' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf',
        ]);

        $hasil = [];

        foreach ($request->file('files') as $file) {
            $ext      = $file->getClientOriginalExtension();
            $uuid     = Str::uuid();
            $path     = "tikets/{$tiketId}/{$uuid}.{$ext}";

            // Upload ke S3 Linode — public-read
            Storage::disk('s3')->put($path, file_get_contents($file), 'public');

            $url = rtrim(config('filesystems.disks.s3.url'), '/') . '/' . $path;

            $lampiran = TiketLampiran::create([
                'tiket_id'      => $tiketId,
                'nama_file'     => $file->getClientOriginalName(),
                'path'          => $path,
                'url'           => $url,
                'mime_type'     => $file->getMimeType(),
                'ukuran'        => $file->getSize(),
                'diunggah_oleh' => $request->header('X-Bridge-Shop') ?? 'shopify',
            ]);

            $hasil[] = [
                'id'        => $lampiran->id,
                'nama_file' => $lampiran->nama_file,
                'url'       => $lampiran->url,
                'mime_type' => $lampiran->mime_type,
                'ukuran'    => $lampiran->ukuran,
                'is_image'  => $lampiran->isImage(),
            ];
        }

        return response()->json([
            'berhasil'   => true,
            'lampiran'   => $hasil,
        ], 201);
    }

    /**
     * GET /api/shopify/tickets/{id}/attachments
     * Ambil semua lampiran untuk satu tiket.
     */
    public function index(int $tiketId)
    {
        $tiket    = Tiket::findOrFail($tiketId);
        $lampiran = $tiket->lampiran()
            ->orderBy('created_at')
            ->get()
            ->map(fn($l) => [
                'id'        => $l->id,
                'nama_file' => $l->nama_file,
                'url'       => $l->url,
                'mime_type' => $l->mime_type,
                'ukuran'    => $l->ukuran,
                'is_image'  => $l->isImage(),
            ]);

        return response()->json(['lampiran' => $lampiran]);
    }
}
