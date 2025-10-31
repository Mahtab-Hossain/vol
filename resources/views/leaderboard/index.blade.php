@extends('layouts.app')
@section('title', 'Leaderboard')

@section('content')
<div class="container">
    <div class="row">
        <!-- Volunteers Leaderboard -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top Volunteers</h5>
                    <span class="badge bg-light text-primary">{{ $volunteers->total() }} total</span>
                </div>
                <div class="card-body">
                    @forelse($volunteers as $index => $vol)
                        <div class="d-flex align-items-center mb-3 p-2 rounded {{ $index < 3 ? 'bg-light' : '' }}">
                            <div class="position-relative me-3">
                                <img src="{{ $vol->avatar ? asset('storage/' . $vol->avatar) : asset('default-avatar.png') }}" 
                                     class="rounded-circle" style="width:50px;height:50px;object-fit:cover">
                                @if($index < 3)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                        #{{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $vol->name }}</h6>
                                <small class="text-muted">{{ $vol->tasks_completed }} tasks completed</small>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-0 text-primary">{{ $vol->points }}</h5>
                                <small class="text-muted">points</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">No volunteers yet.</p>
                    @endforelse

                    {{ $volunteers->links() }}
                </div>
            </div>
        </div>

        <!-- Organizations Leaderboard -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top Organizations</h5>
                    <span class="badge bg-light text-success">{{ $organizations->total() }} total</span>
                </div>
                <div class="card-body">
                    @forelse($organizations as $index => $org)
                        <div class="d-flex align-items-center mb-3 p-2 rounded {{ $index < 3 ? 'bg-light' : '' }}">
                            <div class="position-relative me-3">
                                <img src="{{ $org->avatar ? asset('storage/' . $org->avatar) : asset('default-avatar.png') }}" 
                                     class="rounded-circle" style="width:50px;height:50px;object-fit:cover">
                                @if($index < 3)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                        #{{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">
                                    {{ $org->name }}
                                    @if($org->verified)
                                        <i class="bi bi-patch-check-fill text-primary" title="Verified Organization"></i>
                                    @endif
                                </h6>
                                <small class="text-muted">{{ $org->opportunities_count }} opportunities posted</small>
                            </div>
                            <div>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">No organizations yet.</p>
                    @endforelse

                    {{ $organizations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
