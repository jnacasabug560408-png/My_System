@extends('layouts.app')
@section('title', 'Forgot Password')
@section('page-title', 'Reset Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Reset Password</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Enter your email address to receive a password reset link.</p>

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-envelope"></i> Send Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <p><a href="{{ route('login') }}">Back to login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection