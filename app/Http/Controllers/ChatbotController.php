<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FinancialAssistantContext;
use App\Services\GriphubClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ChatbotController extends Controller
{
    private const MAX_HISTORY_MESSAGES = 12;

    public function __construct(
        private GriphubClient $client,
        private FinancialAssistantContext $context,
    ) {}

    /**
     * Terima pertanyaan pengguna dan balas dengan asisten keuangan AI.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'history' => ['nullable', 'array', 'max:12'],
            'history.*.role' => ['required', 'in:user,assistant'],
            'history.*.content' => ['required', 'string', 'max:4000'],
        ]);

        $user = $request->user();

        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt($user)],
        ];

        $history = array_slice($validated['history'] ?? [], -self::MAX_HISTORY_MESSAGES);

        foreach ($history as $entry) {
            $messages[] = ['role' => $entry['role'], 'content' => $entry['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $validated['message']];

        try {
            $reply = $this->client->chat($messages);
        } catch (RuntimeException $exception) {
            Log::warning('Chatbot AI gagal merespons.', ['error' => $exception->getMessage()]);

            return response()->json([
                'message' => 'Maaf, asisten sedang tidak bisa dihubungi. Coba lagi sebentar ya.',
            ], 503);
        }

        return response()->json(['message' => $reply]);
    }

    /**
     * Prompt sistem yang membentuk persona asisten keuangan aplikasi CATATUANG.
     */
    private function systemPrompt(User $user): string
    {
        $context = $this->context->toPrompt($user);
        $name = $user->name ?? 'Pengguna';

        $rules = <<<'PROMPT'
        Kamu adalah "Cata", asisten keuangan cerdas di aplikasi CATATUANG.

        Tugasmu:
        - Membantu pengguna memahami dan mengoperasikan aplikasi (Dashboard, Transaksi, Kategori, Laporan, Ekspor CSV, Profil).
        - Menjawab kebingungan pengguna dengan langkah-langkah yang ringkas dan jelas.
        - Memberi saran keuangan personal berdasarkan data ringkasan pengguna di bawah.

        Gaya menjawab:
        - Bahasa Indonesia santai tetapi profesional, hangat, dan menyemangati.
        - Ringkas. Gunakan poin-poin bila menjelaskan langkah.
        - Format nominal uang sebagai "Rp1.234.567".
        - Jangan pernah mengarang data yang tidak ada pada ringkasan di bawah.
        - Jika informasi tidak tersedia, katakan dengan jujur dan tawarkan cara mencarinya di aplikasi.
        - Jangan menampilkan atau membahas API key, token, atau detail teknis internal.
        PROMPT;

        return $rules."\n\nNama pengguna: {$name}\n\nData keuangan pengguna (real-time):\n{$context}";
    }
}
