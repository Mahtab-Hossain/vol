@extends('layouts.app')
@section('title', 'How It Works')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-4">How It Works</h1>
        <p class="lead text-muted">Making volunteering simple and rewarding</p>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div id="steps" class="d-flex gap-3 flex-wrap justify-content-center">
                @php
                    $volSteps = [
                        ['icon'=>'person-plus','title'=>'Sign Up','text'=>'Create your profile. Add skills later in your profile.'],
                        ['icon'=>'search','title'=>'Find','text'=>'Search opportunities that match your skills.'],
                        ['icon'=>'check2-circle','title'=>'Complete','text'=>'Join and complete tasks.'],
                        ['icon'=>'award','title'=>'Earn','text'=>'Get badges, points and certificates.'],
                    ];
                @endphp
                @foreach($volSteps as $i => $s)
                    <div class="step-card text-center p-4 rounded shadow-sm" data-index="{{ $i }}" style="width:220px; cursor:pointer; transition: transform .2s;">
                        <div class="display-4 text-primary mb-2"><i class="bi bi-{{ $s['icon'] }}"></i></div>
                        <h6 class="fw-bold">{{ $s['title'] }}</h6>
                        <p class="small text-muted">{{ $s['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="detail" class="text-center mb-5">
        <h3 id="detailTitle">Sign Up</h3>
        <p id="detailText" class="text-muted">Create your profile. Add your skills to improve matching.</p>
    </div>

    <!-- CTA -->
    <div class="text-center mt-5">
        <p class="lead">Ready to get started?</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Sign Up as Volunteer</a>
        <a href="{{ route('register') }}?role=organization" class="btn btn-success btn-lg">Register Organization</a>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.step-card');
    const title = document.getElementById('detailTitle');
    const text = document.getElementById('detailText');

    cards.forEach(card => {
        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-6px) scale(1.02)');
        card.addEventListener('mouseleave', () => card.style.transform = '');
        card.addEventListener('click', () => {
            const idx = parseInt(card.dataset.index, 10);
            // Use the content from the card to populate detail area
            title.innerText = card.querySelector('h6').innerText;
            text.innerText = card.querySelector('p').innerText;
            // highlight selected
            cards.forEach(c => c.classList.remove('border', 'border-2', 'border-primary'));
            card.classList.add('border', 'border-2', 'border-primary');
            // smooth scroll detail into view
            card.scrollIntoView({ behavior: 'smooth', inline: 'center' });
        });
    });

    // initial highlight
    if (cards[0]) cards[0].click();
});
</script>
@endsection

<style>
.step-card:hover { box-shadow: 0 12px 30px rgba(11,61,145,0.08); }
#detail { transition: all .25s ease; }
</style>
@endsection
