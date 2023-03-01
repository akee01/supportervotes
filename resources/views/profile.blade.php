@extends('layouts.app')
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    @include('layouts._alert')
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="{{ route('profile',$user->id) }}"
                           class="bg-secondary border-1 shadow profile-pic rounded-circle text-center"
                           style="width: 60px;height: 60px;">@foreach(explode(' ',$user->name) as $name){{ $name[0] }}@endforeach</a>
                        <div class="ms-3">
                            <a href="{{ route('profile',$user->id) }}"
                               class="d-block fw-bold mb-0 lh-1">{{ $user->name }}</a>
                            <span class="text-muted small">{{ ucfirst($user->role) }}</span>
                            @if($user->role == 'supporter')
{{--                                <p class="small mb-0">139 Premium Votes</p>--}}
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="small text-muted mt-3">{!! preg_replace("/(https?:\/\/\S+)/i", "<a target='_blank' href=\"$1\">$1</a>", $user->detail); !!}</p>
                        @if($user->id == auth()->id())
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                            @if(auth()->check() && auth()->user()->role == 'creator')
                                <h4 class="text-center my-4">Sum of all
                                    Donations: {{ round($user->balance,2) }} USD</h4>
                            @endif
                        @elseif($user->role == 'creator')
                            @if(auth()->check() && auth()->user()->role == 'supporter')
                                <p class="text-center">You own: <span id="user-stars">{{ $stars ?? 0 }}</span> <i
                                        class="fa text-warning fa-star"></i></p>
                            @endif
                            @auth
                                <a href="#support-modal" data-bs-toggle="modal" class="btn btn-primary"><i class="fas fa-star me-1"></i> Support</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-star me-1"></i> Support</a>
                            @endauth
                        @endif
                    </div>

                    <div class="header d-flex justify-content-between my-4 align-items-center">
                        <h2 class="h4 mb-0">
                            @if(request()->route()->getName() == 'polls.archived')
                                Archived Polls
                            @else
                                {{ explode(' ',$user->name)[0] }}'s Profile
                            @endif
                        </h2>
                        @if($user->role == 'creator' && $user->id == auth()->id())
                            <div>
                                <a class="btn btn-outline-primary me-2" href="{{ route('polls.archived') }}">Polls Archive</a>
                                <a class="btn btn-primary" href="{{ route('polls.create') }}">Add New Poll</a>
                            </div>
                        @endif
                    </div>

                    @if($user->role == 'supporter')
                        <h6>Your votes:</h6>
                    @endif

                    @foreach($polls as $poll)
                        @if($user->id === $poll->user->id)
                            @include('layouts._poll',['poll' => $poll])
                        @else
                            @include('layouts._poll',['poll' => $poll,'show_profile' => true])
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
@if(auth()->check() && auth()->user()->role == 'supporter' && $user->role == 'creator')
    @push('scripts')
        <div class="modal fade" id="support-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4>Support {{ $user->name }}</h4>
                        <p>1 USD = {{ $user->star_rate ?? 10 }} Premium Votes <i class="text-warning fas fa-star"></i>
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
                            <input type="hidden" name="creator_id" value="{{ $user->id }}">
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
            let star_value = {{ $user->star_rate ?? 10 }}
            $('#amount').on('change', e => {
                $('#stars-text').text(`You will get ${e.target.value * star_value} stars.`)
            })
        </script>
    @endpush
@endif
