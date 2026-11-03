<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GriphubClient
{
    /**
     * Kirim percakapan ke endpoint chat completions Griphub Router.
     *
     * @param  array<int, array{role: string, content: string}>  $messages
     */
    public function chat(array $messages, ?string $model = null, float $temperature = 0.6): string
    {
        $apiKey = (string) config('services.griphub.api_key');
        $baseUrl = rtrim((string) config('services.griphub.base_url'), '/');

        if ($apiKey === '') {
            throw new RuntimeException('GRIPHUB_API_KEY belum dikonfigurasi.');
        }

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->timeout(90)
                ->post($baseUrl.'/chat/completions', [
                    'model' => $model ?? config('services.griphub.model'),
                    'messages' => $messages,
                    'temperature' => $temperature,
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('Tidak dapat menghubungi layanan AI. Coba lagi sebentar.', 0, $exception);
        }

        if ($response->failed()) {
            throw new RuntimeException('Layanan AI menolak permintaan (HTTP '.$response->status().').');
        }

        $content = trim((string) $response->json('choices.0.message.content'));

        if ($content === '') {
            throw new RuntimeException('Layanan AI tidak mengembalikan jawaban.');
        }

        return $content;
    }
}
