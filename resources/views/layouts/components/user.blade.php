<div class="col-md-3 col-12 profile-container">
    <h1 class="text-center text-md-start">Perfil</h1>
    <div class="profile-image-container mb-3 text-center text-md-start">
        @php
            $user = Auth::user();
            $profilePicture = $user && $user->profile_picture ? 
                              (str_starts_with($user->profile_picture, 'http') ? $user->profile_picture : asset('storage/' . $user->profile_picture)) : 
                              asset('img/profile.png');
        @endphp   
        <img src="{{ $profilePicture }}" alt="Profile Picture" class="profile-image img-thumbnail">
    </div>
    
    <h2 class="text-center text-md-start">{{ Auth::user()->name }}</h2>
    <p class="text-center text-md-start">{{ Auth::user()->email }}</p>
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

</div>
