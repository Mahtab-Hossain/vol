<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Volunteer Platform')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* small theme polish */
        body { background: #f7f9fb; }
        .navbar-brand { font-weight:700; letter-spacing: .2px; }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Volunteer Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('opportunities.index') }}">Opportunities</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">My Profile</a></li>
                    @endauth
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                        <span class="navbar-text me-3 text-white">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- Global Toast Notifications -->
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div id="globalToast" class="toast align-items-center text-bg-light border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="globalToastBody">
                    <!-- message populated by JS -->
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Show server-side flash as toast
        (function() {
            const toastEl = document.getElementById('globalToast');
            const toastBody = document.getElementById('globalToastBody');
            const bsToast = new bootstrap.Toast(toastEl);

            @if(session('success'))
                toastBody.innerText = @json(session('success'));
                toastEl.classList.remove('text-bg-light');
                toastEl.classList.add('text-bg-success');
                bsToast.show();
            @elseif(session('error'))
                toastBody.innerText = @json(session('error'));
                toastEl.classList.remove('text-bg-light');
                toastEl.classList.add('text-bg-danger');
                bsToast.show();
            @elseif(session('info'))
                toastBody.innerText = @json(session('info'));
                toastEl.classList.remove('text-bg-light');
                toastEl.classList.add('text-bg-primary');
                bsToast.show();
            @endif

            // Show validation errors briefly
            @if($errors->any())
                toastBody.innerText = "Please review the form — there are errors.";
                toastEl.classList.remove('text-bg-light');
                toastEl.classList.add('text-bg-danger');
                bsToast.show();
            @endif
        })();
    </script>
</body>
</html>