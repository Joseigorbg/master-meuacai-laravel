@extends('layouts.base')

@section('title', 'Pagamento Cancelado')

@section('content')
<div class="container mt-4">
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Pagamento Cancelado</h4>
        <p>O pagamento foi cancelado. Sua assinatura não foi ativada.</p>
        <hr>
        <a href="{{ route('profile.finance.subscription') }}" class="btn btn-primary">Voltar para a página de assinaturas</a>
    </div>
</div>
@endsection
