<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg,#0b3d91, rgba(11,61,145,0.85));">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            @if(file_exists(public_path('logo.png')))
                <img src="{{ asset('logo.png') }}" alt="VolunteerHub" style="height:36px; margin-right:10px;">
            @else
                <span style="font-weight:700;color:#fff;">Volunteer<span class="text-warning">Hub</span></span>
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('how-it-works') }}">How it Works</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('leaderboard') }}">Leaderboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('opportunities.index') }}">Opportunities</a></li>

                @guest
                    <li class="nav-item ms-3"><a class="btn btn-outline-light btn-sm" href="{{ route('register') }}">Sign Up</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-light btn-sm" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item ms-2">
                        <a href="{{ route('login.google') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-google me-1"></i>Sign in with Google
                        </a>
                    </li>
                @endguest

                @auth
                    {{-- PROFILE BUTTON: avatar + (name on md+) --}}
                    <li class="nav-item me-2">
                        <a href="{{ route('profile') }}" class="btn btn-light btn-sm d-flex align-items-center">
                            @php
                                $avatarSrc = Auth::user()->avatar 
                                    ? (strpos(Auth::user()->avatar, 'http') === 0 ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar))
                                    : asset('default-avatar.png');
                            @endphp
                            <img src="{{ $avatarSrc }}" alt="Profile" class="rounded-circle me-2" style="width:28px;height:28px;object-fit:cover">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                    </li>

                    {{-- LOGOUT --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
