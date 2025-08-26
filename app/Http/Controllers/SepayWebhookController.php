<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SepayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Sepay Webhook:', $payload);

        return response()->json(['status' => 'ok'], 200);
    }
}
