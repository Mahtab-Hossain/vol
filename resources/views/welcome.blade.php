<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Platform - Make a Difference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .hero { padding: 100px 0; color: white; }
        .btn-custom { padding: 12px 30px; font-weight: 600; border-radius: 50px; transition: 0.3s; }
        .btn-primary { background: #4f46e5; border: none; }
        .btn-primary:hover { background: #4338ca; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); }
        .btn-outline-light:hover { background: white; color: #4f46e5; }
        .feature-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: 0.3s; }
        .feature-card:hover { transform: translateY(-10px); }
        .stats { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 15px; padding: 40px; }
        .icon-lg { font-size: 3rem; color: #4f46e5; }
        footer { background: #1a1a2e; color: #aaa; padding: 40px 0; }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero text-center">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Connect. Volunteer. <span class="text-warning">Change Lives.</span></h1>
            <p class="lead mb-5">Join thousands of volunteers and organizations making a real impact.</p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-custom me-3">Start Volunteering</a>
                <a href="{{ route('register') }}?role=organization" class="btn btn-outline-light btn-lg btn-custom">Post Opportunities</a>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-5">
        <div class="container stats text-white text-center">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="display-4 fw-bold">500+</h2>
                    <p>Active Volunteers</p>
                </div>
                <div class="col-md-3">
                    <h2 class="display-4 fw-bold">120+</h2>
                    <p>Organizations</p>
                </div>
                <div class="col-md-3">
                    <h2 class="display-4 fw-bold">1,200+</h2>
                    <p>Tasks Completed</p>
                </div>
                <div class="col-md-3">
                    <h2 class="display-4 fw-bold">48</h2>
                    <p>Countries</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Us?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-search-heart icon-lg mb-3"></i>
                        <h5>Find Meaningful Work</h5>
                        <p>Browse verified opportunities that match your skills and passion.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-shield-check icon-lg mb-3"></i>
                        <h5>Trusted & Secure</h5>
                        <p>All organizations are verified. Your data is safe with us.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="bi bi-trophy icon-lg mb-3"></i>
                        <h5>Earn Recognition</h5>
                        <p>Get badges and certificates for your contributions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 text-center text-white">
        <div class="container">
            <h2 class="fw-bold mb-4">Ready to Make a Difference?</h2>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-custom">Join Now - It's Free!</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} Volunteer Platform. Made with <i class="bi bi-heart-fill text-danger"></i> for social good.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>