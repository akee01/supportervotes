@extends('layouts.app')

@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="listing-header p-4">
                        <form method="POST" action="{{ route('password.update') }}" class="d-inline my-3 needs-validation" id="reset-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <h2 class="h3 mb-3 fw-bold">{{ __('Reset Password') }}</h2>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-group mb-4">
                                <label for="email">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <div class="form-group text-end">
                                    <button type="submit" class="btn btn-primary" id="register-btn">{{ __('Reset Password') }}</button>
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
        $('#reset-form').validate({
            rules: {
                password: {
                    required: true,
                    pwcheck: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                password: {
                    pwcheck: "Password must be at least 8 characters long and contains letters and numbers."
                },
                password_confirmation: {
                    equalTo: "Both passwords must match."
                }
            }
        });

        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*\d)(?=.*[a-zA-Z]).{8,20}$/.test(value)
        });
    </script>
@endpush
