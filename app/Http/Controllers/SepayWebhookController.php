<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SepayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $apiKey = $request->header('Authorization');
        $expected = env('SEPAY_API_KEY');

        if ($apiKey !== $expected) {
            Log::warning('Sepay Webhook - Invalid API Key', ['received' => $apiKey]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $payload = $request->all();

        Log::info('Sepay Webhook:', $payload);

        return response()->json(['status' => 'ok'], 200);
    }
}
