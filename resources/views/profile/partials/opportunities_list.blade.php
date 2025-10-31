<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>
            @if($user->role === 'organization') Your Posted Opportunities @else Your Tasks @endif
        </strong>
        <small class="text-muted">{{ $opportunities->count() }} items</small>
    </div>
    <div class="card-body">
        @forelse($opportunities as $opp)
            <div class="mb-3 pb-2 border-bottom">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">{{ $opp->title }}</h6>
                        <p class="small text-muted mb-1">{{ \Illuminate\Support\Str::limit($opp->description, 140) }}</p>
                        <div class="small text-muted">
                            @if($user->role === 'organization')
                                Claim: {{ $opp->volunteer?->name ?? '—' }}
                            @else
                                Org: {{ $opp->organization->name ?? '—' }}
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        @if($opp->completed)
                            <span class="badge bg-success mb-2">Completed</span><br>
                        @endif

                        @if($user->role === 'organization' && $opp->completed && $opp->volunteer_id)
                            <form action="{{ route('certification.approve', $opp->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-success">Approve Cert</button>
                            </form>
                        @endif
                    </div>
                </div>

                @if($user->role === 'volunteer' && $opp->completed)
                    <div class="mt-2">
                        @if($opp->testimonial)
                            <small class="text-muted">You submitted a testimonial.</small>
                        @else
                            <a href="{{ route('opportunities.testimonial.form', $opp->id) }}" class="btn btn-sm btn-light">Leave Feedback</a>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p class="text-center text-muted py-4">No items yet.</p>
        @endforelse
    </div>
</div>

{{-- Certificates (Volunteer) --}}
@if($user->role === 'volunteer' && !empty($certifications) && $certifications->isNotEmpty())
    <div class="card shadow-sm mt-3">
        <div class="card-header"><strong>Your Certificates</strong></div>
        <div class="card-body">
            @foreach($certifications as $cert)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="fw-semibold">{{ $cert->title }}</div>
                        <div class="small text-muted">From {{ $cert->organization->name ?? '—' }} — {{ $cert->opportunity->title ?? '—' }}</div>
                    </div>
                    <div>
                        @if($cert->pdf_path)
                            <a href="{{ route('certificates.download', $cert->id) }}" class="btn btn-sm btn-primary">Download PDF</a>
                        @else
                            <span class="badge bg-secondary">Processing</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- Testimonials (Organization) --}}
@if($user->role === 'organization' && isset($testimonials))
    <div class="card shadow-sm mt-3">
        <div class="card-header"><strong>Testimonials — Avg {{ number_format($averageRating,1) }}/5</strong></div>
        <div class="card-body">
            @forelse($testimonials as $t)
                <div class="mb-3 border-bottom pb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $t->volunteer->name }}</strong>
                            <div class="small text-muted">{{ $t->comment }}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">{{ $t->rating }} / 5</div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No testimonials yet.</p>
            @endforelse
        </div>
    </div>
@endif
