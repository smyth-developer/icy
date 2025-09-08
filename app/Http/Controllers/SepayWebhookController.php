<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\TuitionRepositoryInterface;

class SepayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $apiKey = $request->header('Authorization');
        $expected = 'Apikey ' . env('SEPAY_SECRET_KEY');



        if ($apiKey !== $expected) {
            Log::warning('Sepay Webhook - Invalid API Key', ['received' => $apiKey]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $payload = $request->all();

        $content = $payload['content'];
        $transferAmount = $payload['transferAmount'];
        
        app(TuitionRepositoryInterface::class)->updateStatus($content, $transferAmount);

        return response()->json(['status' => 'ok'], 200);
    }
}
