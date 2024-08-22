@extends('layouts.base')

@section('title', 'Produtos e Pontos')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" crossorigin="anonymous" />

<div class="container mt-4">
    <div class="row justify-content-between">
        @include('layouts.components.user')
        <div class="col-md-9">
            <div class="container mt-4">
                <h1 class="text-center mb-4">
                    <i class="bi bi-box-seam"></i> Produtos e Pontos
                </h1>
                <h2 class="mt-5 mb-4">Todos os Produtos</h2>

                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('profile.products.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> Criar Novo Produto
                    </a>
                </div>

                @if($products->isEmpty())
                    <div class="alert alert-warning text-center">
                        Não há produtos cadastrados. Cadastre um ponto e insira o produto, ou edite.
                    </div>
                @else
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body position-relative">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid position-absolute top-0 end-0 m-3" style="max-width: 100px;">
                                        @endif
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">
                                            <strong>Preço:</strong> R$ {{ number_format($product->price, 2, ',', '.') }}<br>
                                            <strong>Quantidade:</strong> {{ $product->quantity }}<br>
                                            <strong>Descrição:</strong> {{ $product->description }}<br>
                                            <strong>Ponto:</strong> {{ $product->point->name ?? 'Nenhum ponto associado' }}<br>
                                            @if($product->point)
                                                <strong>Endereço do Ponto:</strong> {{ $product->point->endereco->logradouro }}, {{ $product->point->endereco->numero }}, {{ $product->point->endereco->bairro }}<br>
                                            @endif
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('profile.products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <form action="{{ route('profile.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Você tem certeza que deseja excluir este produto?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }} <!-- Paginação -->
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/manager/popgen.js') }}"></script>
<script src="{{ asset('js/maps/prevent.js') }}"></script>
@endsection
