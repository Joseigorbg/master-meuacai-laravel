@extends('layouts.base')

@section('title', 'Plano de Assinatura')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">

<div class="container mt-4">
    <div class="row justify-content-between">
        @include('layouts.components.user')

        <div class="col-md-9">
            <h1>
                <i class="bi bi-card-list"></i> Planos de Assinatura
            </h1>

            <!-- Cartão para o Plano Básico -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-star"></i> Plano Básico - R$ 49,90/mês
                    </h5>
                    <p class="card-text">
                        <i class="bi bi-check-circle"></i> Acesso a recursos básicos.
                    </p>
                    <a href="{{ route('checkout-plan', ['plan' => 'basico']) }}" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> Assinar
                    </a>
                </div>
            </div>

            <!-- Cartão para o Plano Premium -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-star-fill"></i> Plano Premium - R$ 99,90/mês
                    </h5>
                    <p class="card-text">
                        <i class="bi bi-check-circle"></i> Acesso a recursos avançados e suporte prioritário.
                    </p>
                    <a href="{{ route('checkout-plan', ['plan' => 'premium']) }}" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> Assinar
                    </a>
                </div>
            </div>

            <!-- Cartão para o Plano Empresarial -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-briefcase-fill"></i> Plano Empresarial - R$ 149,90/mês
                    </h5>
                    <p class="card-text">
                        <i class="bi bi-check-circle"></i> Acesso a todos os recursos e suporte dedicado.
                    </p>
                    <a href="{{ route('checkout-plan', ['plan' => 'empresarial']) }}" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> Assinar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

@endsection
