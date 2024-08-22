@extends('layouts.base')

@section('title', 'Editar Perfil')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container mt-4">
    <div class="row justify-content-between">
        <!-- Container do perfil do usuário -->
        @include('layouts.components.user')
        <!-- Container de edição de pontos -->
        <div class="col-md-9">
            <div class="container mt-4">
                <h1>
                    <i class="bi bi-person-circle"></i> Editar Perfil
                </h1>
                <form method="POST" action="{{ route('profile.manager.update-profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i> Nome:
                        </label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email:
                        </label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Nova Senha:
                        </label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i> Confirme a Nova Senha:
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">
                            <i class="fas fa-image"></i> Foto de Perfil:
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Atualizar Perfil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
