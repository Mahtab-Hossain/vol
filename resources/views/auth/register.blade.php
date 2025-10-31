@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Register</h4>
            </div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    <a id="googleRegisterBtn" href="{{ route('login.google') }}" class="btn btn-outline-danger w-100 mb-2">
                        <i class="bi bi-google me-2"></i> Sign up with Google
                    </a>
                    <div class="small text-muted">Or use your email to register</div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select id="roleSelect" name="role" class="form-select" required>
                            <option value="volunteer">Volunteer</option>
                            <option value="organization">Organization</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const googleBtn = document.getElementById('googleRegisterBtn');
    const roleSelect = document.getElementById('roleSelect');

    googleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const role = encodeURIComponent(roleSelect.value || 'volunteer');
        window.location = this.href + '?role=' + role;
    });
});
</script>
@endsection