<div class="card shadow-sm">
    <div class="card-body text-center">
        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover">
        <h5 class="mb-0">{{ $user->name }}</h5>
        <small class="text-muted d-block mb-3">{{ ucfirst($user->role) }}</small>

        <div class="d-grid gap-2 mb-3">
            @if($user->role === 'organization')
                <a href="{{ route('opportunities.create') }}" class="btn btn-primary">Post Opportunity</a>
            @else
                <a href="{{ route('opportunities.index') }}" class="btn btn-primary">Find Opportunities</a>
            @endif
            <a href="{{ route('profile') }}" class="btn btn-outline-secondary">Refresh Profile</a>
        </div>

        <hr>

        <div class="text-start">
            <p class="mb-1"><strong>Points</strong></p>
            <h3 class="text-success">{{ $user->points ?? 0 }}</h3>
            <p class="mb-1"><strong>Tasks</strong></p>
            <h3 class="text-primary">{{ $user->tasks_completed ?? 0 }}</h3>
        </div>
    </div>
</div>

{{-- Avatar upload & skills (both can update avatar; volunteers get skills manager) --}}
<div class="card mt-3 shadow-sm">
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf @method('PUT')
            <div class="mb-3 text-center">
                <label class="d-block mb-2">Profile Photo</label>
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" class="rounded-circle mb-2" style="width:90px;height:90px;object-fit:cover">
                <input type="file" name="avatar" class="form-control mt-2" accept="image/*">
            </div>
            <button type="submit" class="btn btn-outline-primary w-100">Save Avatar</button>
        </form>

        {{-- Show badges --}}
        @php
            $badges = $user->badges ?? [];
        @endphp
        @if(!empty($badges))
            <h6>Badges</h6>
            @foreach($badges as $badge)
                <span class="badge bg-warning text-dark me-1 mb-1">{{ $badge }}</span>
            @endforeach
            <hr>
        @endif

        {{-- Skills manager only for volunteers --}}
        @if($user->role === 'volunteer')
            @include('profile.partials.skills', ['user' => $user])
        @else
            {{-- For organizations show short bio and gallery if present --}}
            @if(!empty($user->bio))
                <h6 class="mt-3">About</h6>
                <p class="small text-muted">{{ $user->bio }}</p>
            @endif
        @endif
    </div>
</div>
