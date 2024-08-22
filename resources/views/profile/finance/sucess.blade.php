@extends('layouts.base')

@section('title', 'Pagamento Concluído')

@section('content')
<div class="container mt-4">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Sucesso!</h4>
        <p>O pagamento foi concluído com sucesso. Seu plano de assinatura foi ativado.</p>
        <hr>
        <a href="{{ route('profile.finance.subscription') }}" class="btn btn-primary">Voltar para a página de assinaturas</a>
    </div>
</div>
@endsection
