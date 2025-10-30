@extends('layouts.app')
@section('title', 'Opportunities')

@section('content')
<h1>Volunteer Opportunities</h1>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(Auth::user()->role === 'organization')
    <a href="{{ route('opportunities.create') }}" class="btn btn-success mb-3">Post Opportunity</a>
@endif

<div class="row">
    @forelse($opportunities as $opp)
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $opp->title }}</h5>
                    <p>{{ $opp->description }}</p>
                    <small>By: {{ $opp->organization->name }}</small><br>
                    @if($opp->volunteer_id)
                        <strong>Claimed by: {{ $opp->volunteer->name }}</strong>
                        @if($opp->completed) <span class="badge bg-success">Completed</span> @endif
                    @else
                        @if(Auth::user()->role === 'volunteer')
                            <form action="{{ route('opportunities.claim', $opp->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-primary">Claim</button>
                            </form>
                        @endif
                    @endif

                    @if($opp->volunteer_id == Auth::id() && !$opp->completed)
                        <form action="{{ route('opportunities.complete', $opp->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-info">Mark Complete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
    <div class="text-center py-5">
        <i class="bi bi-emoji-frown display-1 text-muted"></i>
        <p class="lead">No opportunities yet. Be the first to post!</p>
        @if(Auth::user()->role === 'organization')
            <a href="{{ route('opportunities.create') }}" class="btn btn-success">Post Now</a>
        @endif
    </div>

    @endforelse
</div>
@endsection