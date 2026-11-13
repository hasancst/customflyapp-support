<?php

namespace App\Inti;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AIClient
{
    /**
     * Generate text/JSON completion using the configured AI provider (gemini or 9router).
     */
    public static function generate(string $prompt, array $options = []): array
    {
        $settings = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
        $provider = $options['provider'] ?? ($settings['ai_provider'] ?? 'gemini');

        if ($provider === '9router') {
            return self::call9Router(
                $prompt,
                $settings['ai_9router_url'] ?? 'http://localhost:20128/v1',
                $settings['ai_9router_key'] ?? '',
                $options['model'] ?? ($settings['ai_9router_model'] ?? ''),
                $options
            );
        }

        return self::callGemini(
            $prompt,
            $settings['ai_gemini_key'] ?? '',
            $options['model'] ?? ($settings['ai_gemini_model'] ?? 'gemini-flash-latest'),
            $options
        );
    }

    /**
     * Test connection for either Gemini or 9router using unsaved form parameters.
     */
    public static function testConnection(array $params): array
    {
        $provider = $params['provider'] ?? 'gemini';

        if ($provider === '9router') {
            $baseUrl = trim($params['base_url'] ?? 'http://localhost:20128/v1');
            $apiKey = trim($params['api_key'] ?? '');
            $model = trim($params['model'] ?? '');

            if (!$baseUrl || !$model) {
                return ['berhasil' => false, 'pesan' => 'Base URL dan Model 9router wajib diisi.'];
            }

            $res = self::call9Router(
                'Test connection. Reply with "OK" only.',
                $baseUrl,
                $apiKey,
                $model,
                ['json' => false, 'timeout' => 60]
            );

            if ($res['berhasil']) {
                return ['berhasil' => true, 'pesan' => 'Koneksi 9router berhasil! Respon: ' . trim($res['text'])];
            }

            return $res;
        }

        $apiKey = trim($params['api_key'] ?? '');
        $model = trim($params['model'] ?? 'gemini-flash-latest');

        if (!$apiKey) {
            return ['berhasil' => false, 'pesan' => 'API Key Gemini wajib diisi.'];
        }

        $res = self::callGemini(
            'Test connection. Reply with "OK" only.',
            $apiKey,
            $model,
            ['json' => false, 'timeout' => 20]
        );

        if ($res['berhasil']) {
            return ['berhasil' => true, 'pesan' => 'Koneksi Gemini berhasil! ' . trim($res['text'])];
        }

        return $res;
    }

    /**
     * Fetch available models from a 9router OpenAI-compatible /v1/models endpoint.
     */
    public static function fetch9RouterModels(string $baseUrl, ?string $apiKey = null): array
    {
        $baseUrl = rtrim(trim($baseUrl), '/');
        if (!$baseUrl) {
            return ['berhasil' => false, 'pesan' => 'Base URL 9router belum diisi.', 'models' => []];
        }

        try {
            $headers = ['Accept' => 'application/json'];
            if (!empty($apiKey)) {
                $headers['Authorization'] = 'Bearer ' . trim($apiKey);
            }

            $response = Http::timeout(15)->withHeaders($headers)->get("{$baseUrl}/models");

            if ($response->successful()) {
                $data = $response->json('data') ?? [];
                $models = collect($data)
                    ->pluck('id')
                    ->filter()
                    ->values()
                    ->all();

                return [
                    'berhasil' => true,
                    'pesan' => count($models) > 0 ? 'Berhasil memuat ' . count($models) . ' model dari 9router.' : 'Tidak ada model ditemukan di 9router.',
                    'models' => $models,
                ];
            }

            $err = $response->json('error.message') ?? ('HTTP ' . $response->status());
            return ['berhasil' => false, 'pesan' => 'Gagal mengambil model: ' . $err, 'models' => []];
        } catch (\Exception $e) {
            return ['berhasil' => false, 'pesan' => 'Gagal terhubung ke 9router: ' . $e->getMessage(), 'models' => []];
        }
    }

    /**
     * Parse JSON string returned by an LLM (stripping markdown code fences if present).
     */
    public static function decodeJson(?string $text): ?array
    {
        if (!$text) {
            return null;
        }

        $cleaned = trim($text);
        $cleaned = preg_replace('/^```(?:json)?\s*/i', '', $cleaned);
        $cleaned = preg_replace('/\s*```$/', '', $cleaned);

        $decoded = json_decode(trim($cleaned), true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // Fallback: extract first JSON object block if extra prose surrounded it
        if (preg_match('/\{[\s\S]*\}/', $cleaned, $matches)) {
            $decoded = json_decode($matches[0], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return null;
    }

    private static function extractSseContent(string $body): ?string
    {
        if (!str_contains($body, 'data:')) {
            return null;
        }

        $buffer = '';
        foreach (preg_split("/\r\n|\n|\r/", $body) as $line) {
            $line = trim($line);
            if (!str_starts_with($line, 'data:')) {
                continue;
            }
            $jsonStr = trim(substr($line, 5));
            if ($jsonStr === '' || $jsonStr === '[DONE]') {
                continue;
            }
            $chunk = json_decode($jsonStr, true);
            if (!is_array($chunk)) {
                continue;
            }
            $delta = $chunk['choices'][0]['delta']['content']
                ?? $chunk['choices'][0]['message']['content']
                ?? null;
            if (is_string($delta)) {
                $buffer .= $delta;
            }
        }

        return $buffer !== '' ? $buffer : null;
    }

    private static function call9Router(string $prompt, string $baseUrl, string $apiKey, string $model, array $options = []): array
    {
        $baseUrl = rtrim(trim($baseUrl), '/');
        if (!$baseUrl) {
            return ['berhasil' => false, 'pesan' => 'Endpoint URL 9router belum diatur di Pengaturan.'];
        }
        if (!$model) {
            return ['berhasil' => false, 'pesan' => 'Model 9router belum diatur di Pengaturan.'];
        }

        $headers = ['Content-Type' => 'application/json'];
        if ($apiKey !== '') {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }

        $payload = [
            'model' => $model,
            'stream' => false,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ];

        $wantJson = $options['json'] ?? true;
        if ($wantJson) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        $timeout = $options['timeout'] ?? 90;

        try {
            $response = Http::timeout($timeout)->withHeaders($headers)->post("{$baseUrl}/chat/completions", $payload);

            // Retry without response_format if upstream provider rejects json_object
            if (!$response->successful() && $wantJson && $response->status() === 400) {
                unset($payload['response_format']);
                $response = Http::timeout($timeout)->withHeaders($headers)->post("{$baseUrl}/chat/completions", $payload);
            }

            if ($response->successful()) {
                $text = $response->json('choices.0.message.content');
                if ($text === null) {
                    // Fallback: parse SSE streaming chunks (data: {"choices":[{"delta":{"content":"..."}}]})
                    $text = self::extractSseContent($response->body());
                }
                if ($text !== null && $text !== '') {
                    return ['berhasil' => true, 'text' => $text];
                }
                return ['berhasil' => false, 'pesan' => 'Respon 9router kosong atau tidak valid.'];
            }

            $errorMessage = $response->json('error.message') ?? $response->body() ?: 'Unknown Error';
            return ['berhasil' => false, 'pesan' => 'Gagal (9router): ' . $errorMessage . ' (HTTP ' . $response->status() . ')'];
        } catch (\Exception $e) {
            return ['berhasil' => false, 'pesan' => 'Terjadi kesalahan koneksi 9router: ' . $e->getMessage()];
        }
    }

    private static function callGemini(string $prompt, string $apiKey, string $model, array $options = []): array
    {
        if (!$apiKey) {
            return ['berhasil' => false, 'pesan' => 'API Key Gemini belum diatur di Pengaturan.'];
        }

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
        ];

        if ($options['json'] ?? true) {
            $payload['generationConfig'] = [
                'response_mime_type' => 'application/json',
            ];
            $payload['safetySettings'] = [
                ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_NONE'],
                ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_NONE'],
                ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE'],
                ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE'],
            ];
        }

        $timeout = $options['timeout'] ?? 60;

        try {
            $response = Http::timeout($timeout)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativeLanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", $payload);

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text');
                if ($text !== null) {
                    return ['berhasil' => true, 'text' => $text];
                }
                return ['berhasil' => false, 'pesan' => 'Respon Gemini kosong atau tidak valid.'];
            }

            $errorMessage = $response->json('error.message') ?? 'Unknown Error';
            return ['berhasil' => false, 'pesan' => 'Gagal (Gemini): ' . $errorMessage . ' (HTTP ' . $response->status() . ')'];
        } catch (\Exception $e) {
            return ['berhasil' => false, 'pesan' => 'Terjadi kesalahan koneksi Gemini: ' . $e->getMessage()];
        }
    }
}
