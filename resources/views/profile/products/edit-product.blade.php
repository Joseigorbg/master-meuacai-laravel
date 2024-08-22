@extends('layouts.base')

@section('title', 'Editar Produto')

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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1><i class="bi bi-pencil-square"></i> Editar Produto</h1>
            </div>

            <form action="{{ route('profile.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="product-form mb-4 p-3 border rounded shadow-sm">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-basket"></i> Nome do Produto:
                        </label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">
                            <i class="bi bi-currency-dollar"></i> Preço:
                        </label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">
                            <i class="bi bi-123"></i> Quantidade:
                        </label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="bi bi-textarea-t"></i> Descrição:
                        </label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="point_id" class="form-label">
                            <i class="bi bi-geo-alt"></i> Ponto:
                        </label>
                        <select id="point_id" name="point_id" class="form-control" required>
                            <option value="" disabled>Selecione um ponto</option>
                            @foreach($points as $point)
                                <option value="{{ $point->id }}" {{ $point->id == old('point_id', $product->point_id) ? 'selected' : '' }}>
                                    {{ $point->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">
                            <i class="bi bi-image"></i> Imagem do Produto:
                        </label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Imagem do Produto" class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-check-circle"></i> Atualizar
                    </button>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('profile.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-3">
                            <i class="bi bi-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/manager/popgen.js') }}"></script>
<script src="{{ asset('js/maps/prevent.js') }}"></script>
@endsection
