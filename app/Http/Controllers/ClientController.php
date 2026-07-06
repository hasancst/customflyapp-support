<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by app
        if ($request->filled('app')) {
            $query->where('app', $request->app);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('shop_id', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.client.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'country' => 'nullable|string|max:2',
            'shop_id' => 'nullable|string|max:255',
            'app' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        Client::create($request->all());

        return redirect('/admin/client')->with('berhasil', 'Client berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.client.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'country' => 'nullable|string|max:2',
            'shop_id' => 'nullable|string|max:255',
            'app' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $client->update($request->all());

        return redirect('/admin/client')->with('berhasil', 'Client berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect('/admin/client')->with('berhasil', 'Client berhasil dihapus.');
    }

    /**
     * POST /admin/client/{id}/extend-trial
     * Extend masa trial client. Sync ke custom.local.
     */
    public function extendTrial(Request $request, $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $client = Client::findOrFail($id);
        $days   = (int) $request->days;

        // Hitung trial_ends_at baru
        $base = ($client->trial_ends_at && $client->trial_ends_at->isFuture())
            ? $client->trial_ends_at
            : now();

        $newTrialEndsAt = $base->copy()->addDays($days);

        // Simpan nilai lama untuk rollback jika sync gagal
        $oldTrialEndsAt = $client->trial_ends_at;

        // Update DB lokal dulu
        // CATATAN: trial_reminder_sent_at tidak direset sengaja — agar email reminder
        // tidak dikirim ulang ke merchant yang baru di-extend tapi masih dalam window H-3
        $client->update([
            'trial_used'    => true,
            'trial_ends_at' => $newTrialEndsAt,
        ]);

        // Sync ke custom.local
        $shop   = $client->shop_domain ?? $client->shop_id;
        $synced = $shop ? $this->syncExtendToCustomLocal($shop, $newTrialEndsAt) : true;

        if (!$synced) {
            // Rollback lokal kalau sync gagal
            $client->update(['trial_ends_at' => $oldTrialEndsAt]);
            return redirect('/admin/client')
                ->with('gagal', 'Gagal sync extend trial ke app. Silakan coba lagi.');
        }

        return redirect('/admin/client')
            ->with('berhasil', "Trial client {$client->name} diperpanjang {$days} hari hingga " . $newTrialEndsAt->format('d M Y') . '.');
    }

    /**
     * Call custom.local extend-trial endpoint
     */
    private function syncExtendToCustomLocal(string $shop, \Carbon\Carbon $trialEndsAt): bool
    {
        try {
            $secret    = config('services.shopify_bridge.secret');
            $timestamp = (string) time();
            $token     = hash_hmac('sha256', $shop . ':' . $timestamp, $secret);
            $appUrl    = config('services.customfly.app_url', env('CUSTOMFLY_APP_URL', 'https://custom.local'));

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'X-Bridge-Shop'      => $shop,
                'X-Bridge-Timestamp' => $timestamp,
                'X-Bridge-Token'     => $token,
            ])->post("{$appUrl}/api/billing/extend-trial", [
                'trialEndsAt' => $trialEndsAt->toIso8601String(),
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('[ExtendTrial] Sync to custom.local failed: ' . $e->getMessage());
            return false;
        }
    }
}
