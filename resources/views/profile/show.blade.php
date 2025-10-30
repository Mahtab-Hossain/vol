@extends('layouts.app')
@section('title', $user->name . "'s Profile")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- Sidebar: Stats & Gallery -->
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="avatar bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width: 100px; height: 100px; font-size: 2.5rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ ucfirst($user->role) }}</p>

                    @if($user->role === 'organization' && $user->verified)
                        <span class="badge bg-success mb-2">Verified Organization</span>
                    @endif

                    @if($user->bio)
                        <p class="small text-muted">{{ $user->bio }}</p>
                    @endif

                    <!-- Stats -->
                    <!-- profile updatecode -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf @method('PUT')
                        <div class="mb-3 text-center">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" 
                                class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            <input type="file" name="avatar" class="form-control mt-2" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label>Skills (comma-separated: coding, teaching, design)</label>
                            <input type="text" name="skills_input" class="form-control" value="{{ implode(', ', json_decode($user->skills)) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                     <!-- profile updatecode -->
                    <div class="row text-center mt-4">
                        <div class="col">
                            <h5 class="fw-bold text-primary">{{ $user->tasks_completed }}</h5>
                            <small>Tasks Posted/Completed</small>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold text-success">{{ $user->points }}</h5>
                            <small>Total Impact Points</small>
                        </div>
                    </div>

                    <!-- Badges -->
                    @if(count(json_decode($user->badges)) > 0)
                        <div class="mt-3">
                            <h6>Badges:</h6>
                            @foreach(json_decode($user->badges) as $badge)
                                <span class="badge bg-warning text-dark me-1">
                                    @if($badge == 'first_task') First Task
                                    @elseif($badge == 'hero') Hero
                                    @elseif($badge == 'legend') Legend
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Gallery for Orgs -->
                    @if($user->role === 'organization' && count(json_decode($user->gallery)) > 0)
                        <div class="mt-4">
                            <h6>Gallery</h6>
                            @foreach(json_decode($user->gallery) as $photo)
                                <img src="{{ $photo }}" class="img-thumbnail me-1" style="width: 80px; height: 80px; object-fit: cover;">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Main Content: Opportunities -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5>
                        @if($user->role === 'organization')
                            Your Posted Opportunities
                        @else
                            Your Completed Tasks
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($opportunities as $opp)
                        <div class="border-bottom pb-3 mb-3">
                            <h6 class="fw-bold">{{ $opp->title }}</h6>
                            <p class="text-muted small">{{ $opp->description }}</p>
                            @if($user->role === 'organization')
                                <small>Claimed by: {{ $opp->volunteer?->name ?? 'Not claimed' }}</small>
                            @else
                                <small>Posted by: {{ $opp->organization->name }}</small>
                            @endif
                            @if($opp->completed)
                                <span class="badge bg-success ms-2">Completed</span>
                            @endif

                            @if($user->role === 'organization' && !$opp->completed && $opp->volunteer_id)
                                <form action="{{ route('certification.approve', $opp->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success">Approve Certificate</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">
                            @if($user->role === 'organization')
                                No opportunities posted yet. <a href="{{ route('opportunities.create') }}">Post one now!</a>
                            @else
                                No tasks completed yet. <a href="{{ route('opportunities.index') }}">Find opportunities</a>
                            @endif
                        </p>
                    @endforelse
                </div>
                <!-- cert -->
                 <div class="card shadow mt-4">
                    <div class="card-header bg-info text-white">
                        <h5>Your Certificates</h5>
                    </div>
                    <div class="card-body">
                        @php $certs = Certification::where('user_id', $user->id)->where('approved', true)->get(); @endphp
                        @forelse($certs as $cert)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>{{ $cert->title }}</h6>
                                <small>From: {{ $cert->organization->name }} for "{{ $cert->opportunity->title }}"</small>
                                <a href="{{ asset($cert->pdf_path) }}" class="btn btn-sm btn-primary mt-2" target="_blank">Download PDF</a>
                            </div>
                        @empty
                            <p class="text-muted">No certificates yet. Complete more tasks!</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- cert end -->
            </div>

            <!-- Testimonials (for Orgs) -->
            @if($user->role === 'organization')
                <div class="card shadow mt-4">
                    <div class="card-header bg-success text-white">
                        <h5>Testimonials</h5>
                    </div>
                    <div class="card-body">
                        @forelse($testimonials as $testimonial)
                            <div class="border-bottom pb-2 mb-2">
                                <p class="text-muted">"<strong>{{ $testimonial->message }}</strong>"</p>
                                <small>— {{ $testimonial->volunteer->name }} ({{ $testimonial->rating }}/5 stars)</small>
                            </div>
                        @empty
                            <p class="text-muted text-center py-4">No testimonials yet. Complete more tasks to get reviews!</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection