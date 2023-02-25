@extends('layouts.app')
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="{{ route('profile', $poll->user->id) }}" class="bg-secondary border-1 shadow profile-pic rounded-circle text-center"
                             style="width: 60px;height: 60px;">@foreach(explode(' ',$poll->user->name) as $name){{ $name[0] }}@endforeach</a>
                        <div class="ms-3">
                            <a href="{{ route('profile',$poll->user->id) }}" class="d-block fw-bold mb-0 lh-1">{{ $poll->user->name }}</a>
                            <span class="text-muted small">{{ ucfirst($poll->user->role) }}</span>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <p class="small text-muted mt-3">{!! preg_replace("/(https?:\/\/\S+)/i", "<a target='_blank' href=\"$1\">$1</a>", $poll->user->detail); !!}</p>
                        @if(auth()->check() && auth()->user()->role == 'supporter')
                            <p class="text-center">You own: <span id="user-stars">{{ $stars ?? 0 }}</span> <i
                                    class="fa text-warning fa-star"></i></p>
                        @endif
                        @auth
                            <a href="#support-modal" data-bs-toggle="modal" class="btn btn-primary"><i class="fas fa-star me-1"></i> Support</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-star me-1"></i> Support</a>
                        @endauth
                    </div>
                    @include('layouts._poll',['poll' => $poll])
                </div>
            </div>
        </div>
    </section>
@endsection

@if(auth()->check() && auth()->user()->role == 'supporter' && $poll->user->role == 'creator')
    @push('scripts')
        <div class="modal fade" id="support-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4>Support {{ $poll->user->name }}</h4>
                        <p>1 USD = {{ $poll->user->star_rate ?? 10 }} Premium Votes <i class="text-warning fas fa-star"></i>
                        </p>
                        <form action="{{ route('pay') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Amount (USD)</label>
                                <select name="amount" id="amount" required class="form-select w-50">
                                    <option value="">Select</option>
                                    <option value="2">$2</option>
                                    <option value="5">$5</option>
                                    <option value="10">$10</option>
                                    <option value="50">$50</option>
                                    <option value="100">$100</option>
                                </select>
                            </div>
                            <p id="stars-text"></p>
                            <input type="hidden" name="creator_id" value="{{ $poll->user->id }}">
                            <div>
                                <button class="btn btn-primary px-4">Pay</button>
                                <button class="btn btn-outline-primary ms-2 px-4">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let star_value = {{ $poll->user->star_rate ?? 10 }}
            $('#amount').on('change', e => {
                $('#stars-text').text(`You will get ${e.target.value * star_value} stars.`)
            })
        </script>
    @endpush
@endif
