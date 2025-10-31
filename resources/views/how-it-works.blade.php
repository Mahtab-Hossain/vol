@extends('layouts.app')
@section('title', 'How It Works')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-4">How It Works</h1>
        <p class="lead text-muted">Making volunteering simple and rewarding</p>
    </div>

    <!-- For Volunteers -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <h3 class="mb-4">For Volunteers</h3>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h5>1. Sign Up</h5>
                            <p class="text-muted small">Create your volunteer profile and add your skills</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="bi bi-search"></i>
                            </div>
                            <h5>2. Find Opportunities</h5>
                            <p class="text-muted small">Browse and claim volunteer opportunities that match your interests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <h5>3. Complete Tasks</h5>
                            <p class="text-muted small">Make a difference by completing volunteer work</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="bi bi-award"></i>
                            </div>
                            <h5>4. Earn & Grow</h5>
                            <p class="text-muted small">Earn certificates, badges, and recognition for your impact</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- For Organizations -->
    <div class="row">
        <div class="col-lg-12">
            <h3 class="mb-4">For Organizations</h3>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-success mb-3">
                                <i class="bi bi-building"></i>
                            </div>
                            <h5>1. Register</h5>
                            <p class="text-muted small">Create your organization profile and get verified</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-success mb-3">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <h5>2. Post Opportunities</h5>
                            <p class="text-muted small">Create volunteer opportunities and describe needed skills</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-success mb-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <h5>3. Connect</h5>
                            <p class="text-muted small">Connect with skilled volunteers who match your needs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-success mb-3">
                                <i class="bi bi-star"></i>
                            </div>
                            <h5>4. Recognize</h5>
                            <p class="text-muted small">Award certificates and provide feedback to volunteers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="text-center mt-5">
        <p class="lead">Ready to get started?</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Sign Up as Volunteer</a>
        <a href="{{ route('register') }}?role=organization" class="btn btn-success btn-lg">Register Organization</a>
    </div>
</div>
@endsection
