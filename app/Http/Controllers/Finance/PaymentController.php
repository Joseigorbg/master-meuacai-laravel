<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $plan = $request->input('plan');

        // Redireciona para o checkout baseado no plano selecionado
        if (in_array($plan, ['basico', 'premium', 'empresarial'])) {
            return redirect()->route('checkout', ['plan' => $plan]);
        }

        return redirect()->route('profile.finance.subscription')
            ->with('error', 'Plano inválido selecionado.');
    }

    public function success()
    {
        return view('profile.finance.success');
    }

    public function cancel()
    {
        return view('profile.finance.cancel');
    }
}
