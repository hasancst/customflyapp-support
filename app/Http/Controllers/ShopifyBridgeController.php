<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ShopifyBridgeController extends Controller
{
    /**
     * POST /api/shopify/auth
     * Terima data customer dari Shopify App, buat/update client, return chat widget key.
     */
    public function auth(Request $request)
    {
        $request->validate([
            'shop'        => 'required|string',
            'email'       => 'required|email',
            'customer_id' => 'nullable|string',
            'first_name'  => 'nullable|string',
            'last_name'   => 'nullable|string',
        ]);

        $client = Client::updateOrCreate(
            ['email' => $request->email],
            [
                'name'        => trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? '')) ?: $request->email,
                'shop_id'     => $request->shop,
                'shop_domain' => $request->shop,
                'customer_id' => $request->customer_id,
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'app'         => 'customfly',
                'status'      => 'active',
            ]
        );

        // Ambil widget key yang aktif (widget pertama)
        $widgetKey = null;
        $widgetClass = null;
        // Try to find the ChatWidget model
        $possibleClasses = [
            \App\Modul\Chat\Model\ChatWidget::class,
            \App\Models\ChatWidget::class,
        ];
        foreach ($possibleClasses as $class) {
            if (class_exists($class)) {
                $widgetClass = $class;
                break;
            }
        }
        if ($widgetClass) {
            $widget = $widgetClass::where('aktif', true)->first();
            $widgetKey = $widget?->public_key;
        }

        return response()->json([
            'client_id'     => $client->id,
            'widget_key'    => $widgetKey,
            'visitor_name'  => $client->name,
            'visitor_email' => $client->email,
        ]);
    }

    /**
     * POST /api/shopify/sync-trial
     * Terima data trial + plan dari custom.local setelah merchant subscribe paid plan.
     */
    public function syncTrial(Request $request)
    {
        $request->validate([
            'shop'             => 'required|string',
            'plan'             => 'nullable|string',
            'trial_used'       => 'required|boolean',
            'trial_started_at' => 'nullable|string',
            'trial_ends_at'    => 'nullable|string',
        ]);

        $client = Client::where('shop_domain', $request->shop)
            ->orWhere('shop_id', $request->shop)
            ->first();

        if (!$client) {
            \Log::warning('[SyncTrial] Client not found for shop: ' . $request->shop);
            return response()->json(['ok' => true, 'note' => 'client not found']);
        }

        $updateData = [
            'trial_used'       => $request->trial_used,
            'trial_started_at' => $request->trial_started_at
                ? \Carbon\Carbon::parse($request->trial_started_at)
                : null,
            'trial_ends_at'    => $request->trial_ends_at
                ? \Carbon\Carbon::parse($request->trial_ends_at)
                : null,
        ];

        // Update plan jika dikirim
        if ($request->has('plan')) {
            $updateData['plan'] = $request->plan;
        }

        $client->update($updateData);

        return response()->json(['ok' => true]);
    }
}
