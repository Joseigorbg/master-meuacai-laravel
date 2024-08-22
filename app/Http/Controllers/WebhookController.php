<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Lógica para processar o webhook
        return response()->json(['status' => 'success']);
    }
}

