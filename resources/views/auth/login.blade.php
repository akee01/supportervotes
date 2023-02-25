@extends('layouts.app')
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="listing-header p-4">
                        @include('layouts._alert')
                        <form action="{{ route('login') }}" method="POST" class="d-inline my-3 needs-validation" id="login-form">
                            @csrf

                            <h2 class="h3 mb-3 fw-bold">Login to your account.</h2>
                            <div class="form-group mb-4">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')
                                <span class="small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <div>
                                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $('#login-form').validate();
    </script>
@endpush
