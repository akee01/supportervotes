@extends('layouts.app')
@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 p-5 text-center">
                    <h1 class="h2 fw-bold">Welcome to Supporter<span class="text-primary">Votes</span>.com</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At commodi delectus itaque libero
                        mollitia
                        natus omnis quae quidem sapiente velit! A aut beatae ea id laudantium nihil repudiandae sint,
                        suscipit.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, consequuntur eaque
                        error
                        eum ex exercitationem illum incidunt, ipsa ipsam magnam minima molestias nihil nobis porro
                        provident
                        quia repudiandae soluta ullam.</p>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="listing-header p-4">
                        <form action="{{ route('home') }}" method="GET" class="d-inline my-3 text-center">
                            <h2 class="h4 mb-3 fw-bold">Creators and their most recent polls</h2>
                            <div class="form-group d-flex align-items-center">
                                <input type="text" placeholder="Search for Creators and Polls" class="form-control" name="q" required value="{{ request()->q ?? '' }}">
                                <button class="btn btn-primary ms-2">Search</button>
                                @if(request()->q)
                                    <a href="{{ route('home') }}" class="ms-2 btn btn-danger">Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 listing-container">
                    @foreach($polls as $poll)
                    <div class="listing mb-4">
                        <div class="card card-body p-4 bg-light border-0">
                            <div class="d-flex align-items-center text-decoration-none">
                                <a href="{{ route('profile', $poll->user->id) }}" class="bg-secondary border-1 shadow profile-pic rounded-circle text-center" style="width: 50px;height: 50px;">@foreach(explode(' ',$poll->user->name) as $name){{ $name[0] }}@endforeach</a>
                                <div class="ms-2">
                                    <a href="{{ route('profile', $poll->user->id) }}" class="d-block fw-bold mb-0 lh-1">{{ $poll->user->name }}</a>
                                    <span class="text-muted small">{{ $poll->user->polls->count() }} {{ \Illuminate\Support\Str::plural('poll',$poll->user->polls->count()) }}</span>
                                </div>
                            </div>
                            <h3 class="my-3 h5 text-primary">{{ $poll->question }}</h3>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <p class="text-muted small">{{ $poll->options->count() }} {{ \Illuminate\Support\Str::plural('option',$poll->options->count()) }} to choose from</p>
                                    @if($poll->closing_at > now())
                                        @php
                                            $obj = \Carbon\Carbon::parse($poll->closing_at);
                                            $diff = $obj->diff(\Carbon\Carbon::now());
                                        @endphp
                                        <div class="text-muted small"><b>Poll ending in: </b>{{ $diff->d.'d '.$diff->h.'h '.$diff->i.'m ' }}</div>
                                    @elseif(!is_null($poll->closing_at))
                                        <div class="text-muted small"><b>Poll ended</div>
                                    @endif
                                </div>
                                <a href="{{ route('polls.single',$poll->id) }}" class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-3">
                        {!! $polls->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
