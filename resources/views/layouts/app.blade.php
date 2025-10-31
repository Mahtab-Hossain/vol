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
        .form-control:focus { box-shadow: 0 6px 18px rgba(11,61,145,0.08); border-color: #0b3d91; }
        .btn-primary { background: #0b3d91; border: none; }
    </style>
    <meta name="description" content="@yield('meta_description', 'VolunteerHub - connect volunteers with organizations for social impact.')">
    <meta name="keywords" content="@yield('meta_keywords', 'volunteer,nonprofit,opportunities,community')">
    <meta property="og:site_name" content="{{ config('app.name', 'Volunteer Platform') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('logo.png') }}">
    <meta name="robots" content="index, follow">
    @yield('meta')
</head>
<body class="bg-light">
    {{-- Replace inline navbar with header partial so logo appears everywhere --}}
    @include('partials.header')

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