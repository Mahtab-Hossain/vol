@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="text-center py-5">
            <h1 class="display-5">Welcome, {{ Auth::user()->name }}!</h1>
            <p class="lead">You are logged in as a <strong>{{ ucfirst(Auth::user()->role) }}</strong>.</p>
            <hr>
            <a href="{{ route('opportunities.index') }}" class="btn btn-primary btn-lg">
                View Opportunities
            </a>
            <br><br>
            <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                View My Profile
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5>Top 10 Volunteers</h5>
            </div>
            <div class="card-body">
                <ol class="list-unstyled">
                    @foreach($leaderboard as $index => $vol)
                        <li class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $index + 1 }}. {{ $vol->name }}</span>
                            <span class="badge bg-primary">{{ $vol->points }} pts</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection