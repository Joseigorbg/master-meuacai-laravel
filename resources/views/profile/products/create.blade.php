@extends('layouts.base')

@section('title', 'Cadastrar Produto')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" crossorigin="anonymous" />

<div class="container mt-4">
    <div class="row justify-content-between">
        @include('layouts.components.user')
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1><i class="bi bi-plus-circle"></i> Cadastrar Produto</h1>
            </div>

            <form action="{{ route('profile.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="products-wrapper">
                    <div class="product-form mb-4 p-3 border rounded shadow-sm">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-basket"></i> Nome do Produto:
                            </label>
                            <input type="text" id="name" name="products[0][name]" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">
                                <i class="bi bi-currency-dollar"></i> Preço:
                            </label>
                            <input type="number" step="0.01" id="price" name="products[0][price]" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">
                                <i class="bi bi-123"></i> Quantidade:
                            </label>
                            <input type="number" id="quantity" name="products[0][quantity]" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="bi bi-textarea-t"></i> Descrição:
                            </label>
                            <textarea id="description" name="products[0][description]" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="point_id" class="form-label">
                                <i class="bi bi-geo-alt"></i> Ponto:
                            </label>
                            <select id="point_id" name="products[0][ponto_id_fk]" class="form-control" required>
                                <option value="" disabled selected>Selecione um ponto</option>
                                @foreach($points as $point)
                                    <option value="{{ $point->id }}">{{ $point->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                <i class="bi bi-image"></i> Imagem do Produto:
                            </label>
                            <input type="file" id="image" name="products[0][image]" class="form-control" accept="image/*">
                        </div>
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mb-3" id="add-product-btn">
                    <i class="bi bi-plus-circle"></i> Adicionar Outro Produto
                </button>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-check-circle"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/manager/format.js') }}"></script>
@endsection
