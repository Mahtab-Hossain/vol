@extends('layouts.app')
@section('title', $user->name . "'s Profile")

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-lg-4">
            {{-- Sidebar partial: avatar, avatar upload, stats, badges --}}
            @include('profile.partials.sidebar', ['user' => $user])
        </div>

        <div class="col-lg-8">
            {{-- Opportunities / certificates / testimonials partial --}}
            @include('profile.partials.opportunities_list', [
                'user' => $user,
                'opportunities' => $opportunities,
                'certifications' => $certifications ?? collect(),
                'testimonials' => $testimonials ?? collect(),
                'averageRating' => $averageRating ?? 0
            ])
        </div>
    </div>
</div>
@endsection