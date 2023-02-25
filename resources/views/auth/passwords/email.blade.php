@extends('layouts.app')

@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="listing-header p-4">
                        <form method="POST" action="{{ route('password.email') }}" class="d-inline my-3 needs-validation" id="email-form">
                            @csrf
                            <h2 class="h3 mb-3 fw-bold">{{ __('Reset Password') }}</h2>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group mb-4">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}">
                                        {{ __('Login to you account') }}
                                    </a>
                                @endif
                                <div class="form-group text-end">
                                    <button type="submit" class="btn btn-primary" id="register-btn">Send Password Reset Link</button>
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
        $('#email-form').validate();
    </script>
@endpush
