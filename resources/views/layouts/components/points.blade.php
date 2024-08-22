<div class="col-md-3">
    <h1>Perfil</h1>
    <div class="profile-image-container mb-3 text-center text-md-start">
        @php
            $user = Auth::user();
            $profilePicture = $user && $user->profile_picture ? 
                              (str_starts_with($user->profile_picture, 'http') ? $user->profile_picture : asset('storage/' . $user->profile_picture)) : 
                              asset('img/profile.png');
        @endphp   
        <img src="{{ $profilePicture }}" alt="Profile Picture" class="profile-image img-thumbnail">
    </div>
    <h2>{{ Auth::user()->name }}</h2>
    <p>{{ Auth::user()->email }}</p>
    <div class="btn-group-vertical w-100">
        <a href="{{ route('auth.profile') }}" class="btn my-2 custom-button">
            <i class="bi bi-geo-alt"></i> Cadastrar Pontos
        </a>
        <a href="{{ route('profile.manager.profile') }}" class="btn my-2 custom-button">
            <i class="bi bi-pencil"></i> Editar Perfil
        </a>
        <a href="{{ route('profile.manager.point') }}" class="btn my-2 custom-button">
            <i class="bi bi-gear"></i> Gerenciar Pontos
        </a>
        <a href="{{ route('profile.manager.products') }}" class="btn my-2 custom-button">
            <i class="bi bi-gear"></i> Gerenciar Produtos
        </a>
        <a href="{{ route('profile.finance.subscription') }}" class="btn my-2 custom-button">
            <i class="bi bi-credit-card"></i> Assinatura
        </a>
        <a href="{{ route('auth.logout') }}" class="btn my-2 custom-button">
            <i class="bi bi-box-arrow-right"></i> Sair
        </a>
    </div>
    <!-- Exibir os 3 pontos cadastrados -->
    <div id="points-list" class="mt-4">
        @foreach($points->take(3) as $point)
        <div class="card point-item mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $point->name }}</h5>
                <p class="card-text">
                    <strong>Telefone:</strong> {{ $point->tel_contato }}<br>
                    <strong>Endereço:</strong> {{ $point->endereco->logradouro }}, {{ $point->endereco->numero }}<br>
                    <strong>Cidade:</strong> {{ $point->endereco->cidade }} - {{ $point->endereco->estado }}<br>
                </p>
                <a href="{{ route('points.edit', $point->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
