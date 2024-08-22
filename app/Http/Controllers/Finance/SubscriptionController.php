<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('profile.finance.subscription');
    }
    public function processSubscription(Request $request)
    {
        $plan = $request->input('plan');

        // Mapear o plano escolhido ao ID de preço do Stripe
        $stripePriceId = match ($plan) {
            'basico' => 'price_id_do_plano_basico',
            'premium' => 'price_id_do_plano_premium',
            'empresarial' => 'price_id_do_plano_empresarial',
            default => throw new \Exception('Plano inválido'),
        };

        // Redirecionar para a página de checkout da Stripe
        return $request->user()->checkout([$stripePriceId => 1], [
            'success_url' => route('checkout-success'),
            'cancel_url' => route('checkout-cancel'),
        ]);
    }
}
