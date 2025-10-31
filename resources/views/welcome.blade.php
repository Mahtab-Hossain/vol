<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Platform - Make a Difference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* 60/30/10 rule: primary = royal blue (60%), secondary = royal red (30%), accent = gold (10%) */
        :root{
            --primary: #0b3d91;   /* royal blue - main surfaces (60%) */
            --secondary: #b22234; /* royal red - accents/buttons (30%) */
            --accent: #ffd166;    /* gold - micro accents (10%) */
            --muted: #6b7280;
            --card-bg: #ffffff;
        }

        body { font-family: 'Poppins', sans-serif; background: linear-gradient(180deg, var(--primary) 0%, #eaf1ff 100%); color:#0f1724; }
        .navbar-brand { font-weight:700; letter-spacing:0.2px; color: white; }
        .hero { padding: 80px 0; }
        .hero-card { background: #ffffff; border-radius:18px; padding:40px; box-shadow: 0 10px 30px rgba(11,61,145,0.06); color: #0f1724; }
        .btn-custom { padding: 12px 26px; font-weight: 600; border-radius: 999px; transition: 0.25s; }
        .btn-primary { background: var(--secondary); border: none; color: white; } /* primary CTA is royal red */
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(178,34,52,0.12); }
        .btn-outline-secondary { border-color: rgba(255,255,255,0.85); color: white; background: transparent; }
        .search-input { background: rgba(255,255,255,0.95); border-radius: 12px; box-shadow: 0 6px 18px rgba(15,23,42,0.06); }
        .feature-card { background: var(--card-bg); border-radius: 12px; padding: 24px; box-shadow: 0 8px 26px rgba(15,23,42,0.06); transition: transform .25s; }
        .feature-card:hover { transform: translateY(-6px); }
        .icon-lg { font-size: 2.1rem; color: var(--secondary); }
        .leaderboard { background: linear-gradient(180deg, #ffffff, #fbfdff); border-radius: 14px; padding: 20px; box-shadow: 0 10px 30px rgba(15,23,42,0.05); }
        .lb-item { display:flex; align-items:center; gap:12px; padding:12px; border-radius:10px; transition:background .15s; }
        .lb-item:hover { background: rgba(11,61,145,0.03); }
        .avatar { width:48px; height:48px; border-radius:50%; object-fit:cover; border:2px solid #fff; box-shadow: 0 6px 18px rgba(15,23,42,0.06); }
        footer { background: var(--primary); color: #f1f5f9; padding: 36px 0; }
        .muted { color: var(--muted); }
        @media (max-width: 768px) { .hero { padding:40px 0; } .hero-img { display:none; } }
    </style>
    @section('meta')
        <meta name="description" content="VolunteerHub — connect with causes, find opportunities and earn recognition.">
        <meta name="keywords" content="volunteer, opportunities, nonprofit, community, skills">
        <meta property="og:title" content="VolunteerHub — Make a Difference">
        <meta property="og:description" content="Join volunteers and organizations making a real impact.">
        <meta property="og:image" content="{{ asset('logo.png') }}">
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection
</head>
<body>

    {{-- use header partial for consistent nav --}}
    @include('partials.header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center hero-card">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold mb-3">Connect with causes, build skills, and change lives.</h1>
                    <p class="lead subtitle mb-4">Join a community of volunteers and organizations focused on making measurable social impact. Find flexible opportunities that fit your skills and schedule.</p>

                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-custom">Start Volunteering</a>
                        <a href="{{ route('register') }}?role=organization" class="btn btn-outline-primary btn-lg btn-custom">Post Opportunities</a>
                    </div>

                    <!-- quick search -->
                    <div class="mt-4">
                        <form class="row g-2 align-items-center" role="search">
                            <div class="col-sm-7">
                                <input class="form-control search-input" type="search" placeholder="Search opportunities, skills or locations" aria-label="Search">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-select search-input">
                                    <option value="">All categories</option>
                                    <option>Education</option>
                                    <option>Healthcare</option>
                                    <option>Environment</option>
                                </select>
                            </div>
                            <div class="col-sm-2 d-grid">
                                <button class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4 muted small">
                        <i class="bi bi-check2-circle text-success"></i> Verified organizations • <i class="bi bi-clock-history"></i> Flexible time • <i class="bi bi-award"></i> Certificates
                    </div>
                </div>

                <div class="col-md-6 text-end hero-img">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid rounded-3 shadow" style="max-height:220px; object-fit:contain;">
                    @else
                        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=800&auto=format&fit=crop&crop=faces" alt="volunteer illustration" class="img-fluid rounded-3 shadow" style="max-height:360px; object-fit:cover;">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Stats + Leaderboard row -->
    <section class="py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="feature-card text-center">
                                <h3 class="fw-bold mb-1">500+</h3>
                                <p class="muted small mb-0">Active Volunteers</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center">
                                <h3 class="fw-bold mb-1">120+</h3>
                                <p class="muted small mb-0">Organizations</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center">
                                <h3 class="fw-bold mb-1">1,200+</h3>
                                <p class="muted small mb-0">Tasks Completed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Why Choose Us -->
                    <div id="features" class="mt-4">
                        <h4 class="fw-bold mb-3">Why volunteers love VolunteerHub</h4>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="feature-card text-center">
                                    <i class="bi bi-search-heart icon-lg mb-3"></i>
                                    <h6 class="mb-1">Find Meaningful Work</h6>
                                    <p class="small muted mb-0">Opportunities tailored to your skills.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card text-center">
                                    <i class="bi bi-shield-check icon-lg mb-3"></i>
                                    <h6 class="mb-1">Trusted & Secure</h6>
                                    <p class="small muted mb-0">Organization verification and privacy-first approach.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card text-center">
                                    <i class="bi bi-trophy icon-lg mb-3"></i>
                                    <h6 class="mb-1">Recognition & Badges</h6>
                                    <p class="small muted mb-0">Earn badges for milestones and contributions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard -->
                <div class="col-lg-4">
                    <div id="leaderboard" class="leaderboard">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-bold">Top Volunteers</h5>
                            <a href="{{ route('leaderboard') }}" class="small">View All</a>
                        </div>

                        <div class="list-group">
                            @if(isset($leaderboard) && $leaderboard->count())
                                @foreach($leaderboard->take(3) as $index => $vol)
                                    @php
                                        $avatarPath = $vol->avatar 
                                            ? (strpos($vol->avatar, 'http') === 0 ? $vol->avatar : asset('storage/' . $vol->avatar))
                                            : "https://ui-avatars.com/api/?name=" . urlencode($vol->name) . "&background=0b3d91&color=fff";
                                    @endphp
                                    <div class="lb-item list-group-item border-0">
                                        <div class="me-2 position-relative">
                                            <img src="{{ $avatarPath }}" class="avatar" alt="{{ $vol->name }}">
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                                #{{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $vol->name }}</div>
                                                    <div class="small muted">{{ Str::limit($vol->bio ?? ($vol->role ?? 'Volunteer'), 28) }}</div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="fw-bold">{{ $vol->points ?? 0 }}</div>
                                                    <div class="small" style="color: var(--accent)">
                                                        <i class="bi bi-award-fill"></i> {{ $vol->tasks_completed ?? 0 }} tasks
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4 muted">
                                    <i class="bi bi-people display-4"></i>
                                    <p class="mb-0">Top volunteers coming soon — join to be featured!</p>
                                </div>
                            @endif

                            <div class="text-center mt-3">
                                <a href="{{ route('leaderboard') }}" class="btn btn-outline-primary btn-sm w-100">View Full Leaderboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 text-center">
        <div class="container">
            <h2 class="fw-bold mb-3">Ready to Make a Difference?</h2>
            <p class="muted mb-4">Sign up and explore opportunities near you. Get recognized for every hour you give.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-custom">Join Now - It's Free!</a>
        </div>
    </section>

    {{-- use footer partial --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>