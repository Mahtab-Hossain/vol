@extends('layouts.app')
@section('title', 'Leave Testimonial')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4>Thank You! Leave a Testimonial</h4>
                    <small>Help {{ $opp->organization->name }} get better.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('opportunities.testimonial', $opp->id) }}" method="POST" onsubmit="return confirmSubmit()">
                        @csrf
                        <div class="mb-3">
                            <label>Rating (1-5 Stars)</label>
                            <select name="rating" class="form-select" required>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Comment (Optional)</label>
                            <textarea name="comment" class="form-control" rows="4" maxlength="500"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Submit & Return</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmSubmit() {
        return confirm('Submit testimonial? You can edit later if needed.');
    }
</script>
@endsection