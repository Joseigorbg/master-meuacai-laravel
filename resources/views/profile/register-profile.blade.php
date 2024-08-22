@extends('layouts.base')

@section('title', 'Profile')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <div class="row justify-content-between">
        @include('layouts.components.points')
        <div class="col-md-9">
            <h1><i class="bi bi-geo-alt-fill"></i> Criar Ponto</h1>
            <form id="itemForm" method="POST" action="{{ route('points.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Campos para a tabela points -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="bi bi-geo"></i> Nome do ponto:
                    </label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="tel_contato" class="form-label">
                        <i class="bi bi-telephone"></i> Telefone de Contato:
                    </label>
                    <input type="text" id="tel_contato" name="tel_contato" class="form-control" value="+55" maxlength="19" required>
                </div>
                <div class="mb-3 d-none">
                    <label for="latitude" class="form-label">
                        <i class="bi bi-compass"></i> Latitude:
                    </label>
                    <input type="text" id="latitude" name="latitude" class="form-control" required readonly>
                </div>
                <div class="mb-3 d-none">
                    <label for="longitude" class="form-label">
                        <i class="bi bi-compass"></i> Longitude:
                    </label>
                    <input type="text" id="longitude" name="longitude" class="form-control" required readonly>
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                </div>
                
                <!-- Campos para a tabela enderecos -->
                <div class="mb-3">
                    <label for="cep" class="form-label">
                        <i class="bi bi-geo"></i> CEP: (sem pontuação)
                    </label>
                    <input type="text" id="cep" name="cep" class="form-control" maxlength="9" required>
                </div>
                <div class="mb-3">
                    <label for="logradouro" class="form-label">
                        <i class="bi bi-house-door"></i> Logradouro:
                    </label>
                    <input type="text" id="logradouro" name="logradouro" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="numero" class="form-label">
                        <i class="bi bi-building"></i> Número:
                    </label>
                    <input type="text" id="numero" name="numero" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="complemento" class="form-label">
                        <i class="bi bi-info-circle"></i> Complemento:
                    </label>
                    <input type="text" id="complemento" name="complemento" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="bairro" class="form-label">
                        <i class="bi bi-map"></i> Bairro:
                    </label>
                    <input type="text" id="bairro" name="bairro" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cidade" class="form-label">
                        <i class="bi bi-map"></i> Cidade:
                    </label>
                    <input type="text" id="cidade" name="cidade" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">
                        <i class="bi bi-flag"></i> Estado:
                    </label>
                    <input type="text" id="estado" name="estado" class="form-control" maxlength="2" required>
                </div>
                <div class="mb-3">
                    <label for="pais" class="form-label">
                        <i class="bi bi-globe"></i> País:
                    </label>
                    <input type="text" id="pais" name="pais" class="form-control" value="Brasil" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle"></i> Cadastrar
                    </button>
                    <button type="button" id="locateButton" class="btn btn-secondary mt-3">
                        <i class="bi bi-geo-alt"></i> Estou aqui
                    </button>
                </div>
            </form>
            <div class="alert alert-info mt-2">
                <i class="bi bi-info-circle"></i> É possível mover o marcador no mapa para ajustar a localização. As coordenadas serão atualizadas automaticamente.
            </div>
            <div id="map" style="height: 300px; margin-top: 20px;"></div>

            <div class="alert alert-info mt-2">
                <i class="bi bi-info-circle"></i> Ao informar os dados solicitados, eu concordo com a coleta, o tratamento e com o armazenamento dos mesmos, para os fins a que se dispõem a plataforma de acordo com a Política de Privacidade e com os Termos de Uso e cumprimento à Lei n° LEI N° 13.709, DE 14 DE AGOSTO DE 2018.
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/maps/map.js') }}"></script>
<script src="{{ asset('js/maps/pointlist.js') }}"></script>
<script src="{{ asset('js/maps/prevent.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.js"></script>
@endsection
