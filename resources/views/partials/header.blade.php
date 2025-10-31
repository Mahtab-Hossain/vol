<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg,#0b3d91, rgba(11,61,145,0.85));">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Volunteer<span class="text-warning">Hub</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('how-it-works') }}">How it Works</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('leaderboard') }}">Leaderboard</a></li>
                @guest
                    <li class="nav-item ms-3"><a class="btn btn-outline-light btn-sm" href="{{ route('register') }}">Sign Up</a></li>
                    <li class="nav-item ms-2">
                        <a href="{{ route('login.google') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-google me-1"></i>Sign in with Google
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item ms-3">
                        <a href="{{ route('profile') }}" class="btn btn-light btn-sm">My Profile</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
