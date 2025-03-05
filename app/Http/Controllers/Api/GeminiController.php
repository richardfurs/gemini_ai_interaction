<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GeminiController extends Controller
{
    public function askGemini(Request $request): JsonResponse
    {
        $ip = $request->ip();
        $apiKey = env('GEMINI_API_KEY');
        $query = $request->input('query');

        $validator = Validator::make($request->all(), [
            'query' => 'required',
        ]);

        if ($validator->fails()) {
            Log::error('Gemini AI: query input required');

            return response()->json(['error' => ['message' => 'Question need to be filled']]);
        }

        $executed = RateLimiter::attempt(
            'ip: ' . $ip,
            $perMinute = 20,
            function () use ($apiKey, $query) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        'parts' => [
                            'text' => $query
                        ]
                    ]
                ]);

                return json_decode($response->body(), true);
            },
        );

        if (!$executed) {
            Log::error('Gemini AI: Too many requests per minute, max attempts 20');

            return response()->json(['error' => ['message' => 'Too many attempts per minute, max attempts 20']]);
        }

        if (isset($executed['error'])) {
            Log::error("Gemini AI: {$executed['error']['message']}");

            return response()->json($executed);
        }

        $answer = str_replace('*', '', $executed['candidates'][0]['content']['parts'][0]['text']);

        return response()->json(['answer' => $answer]);
    }
}
