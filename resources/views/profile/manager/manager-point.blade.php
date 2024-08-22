@extends('layouts.base')

@section('title', 'Gerenciamento de Pontos')

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
                    <i class="bi bi-tools"></i> Gerenciamento de Pontos
                </h1>
                <h2 class="mt-5 mb-4">Seus Pontos</h2>
                
                <!-- Botão para criar um novo ponto -->
                <div class="d-flex justify-content-end mt-2 mb-4">
                    <a href="{{ route('auth.profile') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Adicionar Novo Ponto
                    </a>
                </div>

                @if($points->isEmpty())
                    <div class="alert alert-warning text-center">
                        Não há pontos cadastrados. Adicione um novo ponto.
                    </div>
                @else
                    <div class="row">
                    @foreach($points as $point)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">{{ $point->name }}</h5>
                                        @php
                                            $status = $point->complemento->first()->status ?? 0;
                                        @endphp
                                        <span class="badge {{ $status == 1 ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $status == 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </div>
                                    
                                    <p class="mb-1"><strong>Endereço:</strong> {{ $point->endereco->logradouro }}, {{ $point->endereco->numero }} - {{ $point->endereco->bairro }}, {{ $point->endereco->cidade }} - {{ $point->endereco->estado }}</p>
                                    <p class="mb-1"><strong>CEP:</strong> {{ $point->endereco->cep }}</p>
                                    <p class="mb-1"><strong>Telefone:</strong> {{ $point->tel_contato }}</p>                    

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ route('points.edit', $point) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-gear-fill"></i> Editar
                                        </a>
                                        <form action="{{ route('points.destroy', $point) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
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
                        <button id="showMore" class="btn btn-primary mt-2" style="display: none;">Mostrar Mais</button>
                        <button id="showLess" class="btn btn-secondary mt-2" style="display: none;">Mostrar Menos</button>
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
