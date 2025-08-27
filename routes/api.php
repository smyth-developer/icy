<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SepayWebhookController;

Route::post('/webhook/sepay', [SepayWebhookController::class, 'handle'])->name('webhook.sepay');