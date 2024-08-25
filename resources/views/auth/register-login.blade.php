@extends('layouts.base')

@section('title', 'Entrar/Cadastrar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth/auth-form.css') }}">

<div>
    <div class="forms-container">
        <div class="signin-signup">
            <form action="{{ route('login') }}" method="POST" class="sign-in-form">
                @csrf
                <h2 class="title">Entrar</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                    @error('email')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <label for="password">Senha</label>
                    @error('password')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <input type="submit" name="signin_submit" value="Entrar" class="btn solid"/>
                <p class="social-text">Ou entre com as redes sociais</p>
                <div class="social-media">
                    <a href="{{ route('auth.google') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                        </svg>
                    </a>
                    <a href="{{ route('auth.facebook') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>
                    </a>
                </div>
            </form>

            <form action="{{ route('register') }}" method="POST" class="sign-up-form">
                @csrf
                <h2 class="title">Cadastrar</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ old('name') }}" required>
                    <label for="name">Nome</label>
                    @error('name')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                    @error('email')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Senha" required>
                    <label for="password">Senha</label>
                    @error('password')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Senha" required>
                    <label for="password_confirmation">Senha</label>
                </div>
                <input type="submit" name="submit" class="btn" value="Cadastrar"/>
                <p class="social-text">Ou cadastre-se com as redes sociais</p>
                <div class="social-media">
                    <a href="{{ route('auth.google') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                        </svg>
                    </a>
                    <a href="{{ route('auth.facebook') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>É novo aqui?</h3>
                <p>Crie uma conta para ter acesso a todos os recursos do nosso site!</p>
                <button class="btn transparent" id="sign-up-btn">Cadastre-se</button>
            </div>
        </div>
        <div class="panel right-panel">
            <div class="content" id="content-down">
                <h3>Já é um de nós?</h3>
                <p>Faça login para acessar sua conta!</p>
                <button class="btn transparent" id="sign-in-btn">Entrar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/auth/auth-form.js') }}"></script>
@endsection
