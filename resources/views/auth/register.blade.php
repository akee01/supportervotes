@extends('layouts.app')

@section('content')

    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="listing-header p-4">
                        <form action="{{ route('register') }}" method="POST" class="d-inline my-3 needs-validation" id="reg-form">
                            @csrf
                            <h2 class="h3 mb-3 fw-bold">Register an account.</h2>
                            <div class="form-group mb-3">
                                <label>Select one</label><br>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input mb-0" type="radio" value="creator" name="role" id="role1" checked>
                                        <label class="form-check-label mb-0 fw-normal" for="role1">I am Content Creator</label>
                                    </div>
                                    <div class="form-check ms-3">
                                        <input class="form-check-input mb-0" type="radio" value="supporter" name="role" id="role2">
                                        <label class="form-check-label mb-0 fw-normal" for="role2">I want to follow and vote</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                <span class="small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required id="password">
                                <div class="small text-danger d-none password-alert">Password must be at least 8 characters long and contains letters and numbers.</div>
                                @error('password')
                                <span class="small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label>Repeat Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required id="password_confirmation">
                                <div class="small text-danger d-none confirm-password-alert">Password confirmation failed.</div>
                            </div>
                            <div class="form-group text-end">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary" id="register-btn">Register</button>
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
        $('#reg-form').validate({
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
