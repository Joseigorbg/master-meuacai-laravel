<nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand logo" href="{{ route('home') }}">
            <img src="{{ asset('img/LogoSite.png') }}" alt="Logo" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">
                @php
                    $analytics = \App\Models\Analytics::first();
                @endphp
                <li class="nav-item">
                    <span class="nav-link">Acessos no site: {{ $analytics->accesses ?? 0 }}</span>
                </li>
                <li class="nav-item profile-item">
                    @php
                        $user = Auth::user();
                        $profilePicture = $user && $user->profile_picture ? 
                                          (str_starts_with($user->profile_picture, 'http') ? $user->profile_picture : asset('storage/' . $user->profile_picture)) : 
                                          asset('img/profile.png');
                    @endphp   
                    <img src="{{ $profilePicture }}" alt="Profile Picture" class="profile-picture navbar-profile-picture">
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.register-login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.profile') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>