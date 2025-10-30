@extends('layouts.app')
@section('title', 'Post Opportunity')

@section('content')
<h1>Post New Opportunity</h1>
<form action="{{ route('opportunities.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Post</button>
</form>
@endsection