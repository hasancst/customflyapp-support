<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyShopifyHmac
{
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->header('X-Bridge-Token');
        $shop  = $request->header('X-Bridge-Shop');
        $ts    = $request->header('X-Bridge-Timestamp');

        if (!$token || !$shop || !$ts) {
            return response()->json(['error' => 'Missing bridge headers'], 401);
        }

        // Tolak token lebih dari 5 menit
        if (abs(time() - (int) $ts) > 300) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        $secret   = config('services.shopify_bridge.secret');
        $expected = hash_hmac('sha256', $shop . ':' . $ts, $secret);

        if (!hash_equals($expected, $token)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
