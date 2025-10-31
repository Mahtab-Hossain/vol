@extends('layouts.app')
@section('title', 'Opportunities')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Volunteer Opportunities</h1>
        <p class="text-muted small mb-0">Find meaningful ways to give back — filter by skills, location and time.</p>
    </div>
    @if(Auth::user()->role === 'organization')
        <a href="{{ route('opportunities.create') }}" class="btn btn-success">Post Opportunity</a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    @forelse($opportunities as $opp)
        @php
            $claimed = (bool)$opp->volunteer_id;
            $byMe = $opp->volunteer_id == Auth::id();
        @endphp

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm opportunity-card">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $opp->title }}</h5>
                        @if($opp->completed)
                            <span class="badge bg-success">Completed</span>
                        @elseif($claimed)
                            <span class="badge bg-warning text-dark">Claimed</span>
                        @else
                            <span class="badge bg-secondary">Open</span>
                        @endif
                    </div>

                    <p class="card-text text-muted small mb-3">{{ Str::limit($opp->description, 140) }}</p>

                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="small text-muted">
                                @if($opp->organization)
                                    <strong>{{ $opp->organization->name }}</strong>
                                @else
                                    <strong>Organization</strong>
                                @endif
                            </div>
                            <div class="text-end small text-muted">
                                @if($opp->points)
                                    <span class="me-2"><i class="bi bi-award-fill text-warning"></i> {{ $opp->points }}</span>
                                @endif
                                <span class="text-muted">{{ $opp->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if(!$claimed && Auth::user()->role === 'volunteer')
                                <form action="{{ route('opportunities.claim', $opp->id) }}" method="POST" class="d-inline-flex w-100">
                                    @csrf
                                    <button class="btn btn-primary w-100 btn-sm">Claim</button>
                                </form>
                            @elseif($byMe && !$opp->completed)
                                <form action="{{ route('opportunities.complete', $opp->id) }}" method="POST" class="d-inline-flex w-100">
                                    @csrf
                                    <button class="btn btn-outline-info w-100 btn-sm">Mark Complete</button>
                                </form>
                            @else
                                <a href="#" class="btn btn-outline-secondary w-100 btn-sm disabled">Details</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-emoji-frown display-2 text-muted"></i>
            <h4 class="mt-3">No opportunities yet.</h4>
            <p class="text-muted">Be the first to post or check back later.</p>
            @if(Auth::user()->role === 'organization')
                <a href="{{ route('opportunities.create') }}" class="btn btn-success">Post Now</a>
            @endif
        </div>
    @endforelse
</div>

{{-- pagination --}}
<div class="d-flex justify-content-center mt-4">
		{!! $opportunities->onEachSide(1)->links('pagination::bootstrap-5') !!}
	</div>

@section('styles')
<style>
.opportunity-card { transition: transform .18s ease, box-shadow .18s ease; }
.opportunity-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(11,61,145,0.06); }

/* Ensure pagination is centered and not overlapping (fix stray arrows) */
.pagination { display: flex; justify-content: center; gap: .25rem; margin: 0; padding: 0; }
.page-item .page-link { border-radius: .45rem; padding: .375rem .6rem; }
.page-item.disabled .page-link, .page-item.active .page-link { pointer-events: auto; } /* ensure proper behavior */
/* Prevent any fixed/sticky pagination accidental positioning */
nav[aria-label] .pagination { position: static; }
</style>
@endsection

@endsection