<div class="card card-body p-4 bg-light border-0 mb-3 single-poll" id="poll-{{ $poll->id }}">
    @php
        $u_option = null;
        $voted = auth()->check() ? ($poll?->votes()?->where(['user_id' => auth()->id()])->count() > 0 || (auth()->id() == $poll->user_id || auth()->user()->role != 'supporter')) : false;
        if ($voted){
            $u_option = $poll->votes()->where('user_id', auth()->id())->first();
        }
        $total = 0;
        $votes = [];
        $max_votes = 0;
        $color = '#88c1d7';
        $perc = 0;
        foreach ($poll->options as $option) {
            $total += $option->votes;
            $votes[$option->id] = $option->votes;
            if ($max_votes < $option->votes){
                $max_votes = $option->votes;
            }
        }
    @endphp
    <div class="mb-3 text-primary">
        <div class="dropdown float-end">
            <button type="button" class="btn btn-primary btn-sm social-dd dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-share-nodes"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a target="_blank" class="dropdown-item" href="https://www.facebook.com/sharer.php?u={{ route('polls.single',$poll->id) }}"><i class="fa-brands me-1 fa-facebook"></i> Facebook</a></li>
                <li><a target="_blank" class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ route('polls.single',$poll->id) }}"><i class="fa-brands me-1 fa-twitter"></i> Twitter</a></li>
                <li><a target="_blank" class="dropdown-item" href="https://www.linkedin.com/shareArticle?url={{ route('polls.single', $poll->id) }}"><i class="fa-brands me-1 fa-linkedin"></i> Linkedin</a></li>
                <li><a class="cursor-pointer copy-to-clipboard dropdown-item"><input type="hidden" value="{{ route('polls.single', $poll->id) }}"><i class="fa-solid me-1 fa-clipboard"></i> <span class="text">Copy</span></a></li>
            </ul>
        </div>
        @if(isset($show_profile) && $show_profile)
        <div class="d-flex align-items-center text-decoration-none mb-2">
            <a href="{{ route('profile', $poll->user->id) }}" class="bg-secondary border-1 shadow profile-pic rounded-circle text-center" style="width: 50px;height: 50px;">@foreach(explode(' ',$poll->user->name) as $name){{ $name[0] }}@endforeach</a>
            <div class="ms-2">
                <a href="{{ route('profile', $poll->user->id) }}" class="d-block fw-bold mb-0 lh-1">{{ $poll->user->name }}</a>
                <span class="text-muted small">{{ $poll->user->polls->count() }} polls created</span>
            </div>
        </div>
        @endif
        <span class="h5">{{ $poll->question }}</span>
    </div>
    <div class="alert alert-danger d-none"></div>
    <div class="form-group mb-3">
        <div class="d-flex justify-content-end">
            <div class="form-check">
                <input class="form-check-input mb-0" type="radio" name="role-{{ $poll->id }}" id="role1-{{ $poll->id }}"
                       {{ $voted ? 'disabled' : '' }}
                       {{ ($voted && $u_option?->type == 'standard') ? 'checked' : '' }} {{ !$voted ? 'checked' : '' }} value="standard">
                <label class="form-check-label mb-0 fw-normal" for="role1-{{ $poll->id }}">Standard voting</label>
            </div>
            <div class="form-check ms-3">
                <input class="form-check-input mb-0" type="radio" name="role-{{ $poll->id }}" id="role2-{{ $poll->id }}"
                       {{ $voted ? 'disabled' : '' }}
                       {{ ($voted && $u_option?->type == 'premium') ? 'checked' : '' }} value="premium">
                <label class="form-check-label mb-0 fw-normal" for="role2-{{ $poll->id }}">Premium voting</label>
            </div>
        </div>
        @if($voted && $u_option?->type == 'premium')
            <div class="text-end mb-2">Premium Votes used: {{ $u_option?->stars }} <i class="fa fa-star text-warning"></i></div>
        @else
            <div id="poll-res-{{ $poll->id }}" class="d-none text-end mb-2">Premium Votes used: <span class="spent-count"></span></div>
        @endif
        <div class="text-danger alert-stars small text-end d-none"></div>
    </div>
    @if(!$voted)
        <div class="mb-3 premium-options d-none">
            <div class="text-end">
                Select
                <input id="option-25-{{ $poll->id }}" type="radio" class="btn-check" name="stars-value-{{ $poll->id }}"
                       value="25" checked>
                <label for="option-25-{{ $poll->id }}" class="btn btn-sm btn-outline-primary">25%</label>
                <input id="option-50-{{ $poll->id }}" type="radio" class="btn-check" name="stars-value-{{ $poll->id }}"
                       value="50">
                <label for="option-50-{{ $poll->id }}" class="btn btn-sm btn-outline-primary">50%</label>
                <input id="option-75-{{ $poll->id }}" type="radio" class="btn-check" name="stars-value-{{ $poll->id }}"
                       value="75">
                <label for="option-75-{{ $poll->id }}" class="btn btn-sm btn-outline-primary">75%</label>
                <input id="option-100-{{ $poll->id }}" type="radio" class="btn-check" name="stars-value-{{ $poll->id }}"
                       value="100">
                <label for="option-100-{{ $poll->id }}" class="btn btn-sm btn-outline-primary">100%</label>
                <br>
                <input type="text" class="form-control d-inline form-control-sm h-auto stars-inp" name="stars"
                       style="width: 50px;" @isset($stars) value="{{ round((25/100)*($stars ?? 0)) }}" @endisset>
                <i class="fa fa-star text-warning"></i>
            </div>
        </div>
    @endif
    <ul data-poll-id="{{ $poll->id }}"
        class="answers @if($voted) voted @else user-vote @endif list-group mb-3">
        @foreach($poll->options as $key => $option)
            @if($total > 0)
                @php
                    $perc = round(($votes[$option->id]/$total)*100);
                    if($option->votes == $max_votes){
                        $color = '#2e86a6';
                    }else{
                        $color = '#88c1d7';
                    }
                @endphp
            @endif
            <li @if($voted) style="background: linear-gradient(to right, {{ $color }} {{ $perc }}%, #ffffff {{ $perc }}%)"
                @else data-id="{{ $option->id }}"
                @endif class="@if($voted && isset($option) && $u_option?->poll_option_id == $option->id) my-option @endif @if(!$voted) vote-open @endif list-group-item mb-2 rounded @if(!$voted) text-center @endif">{{ $option->option }}
                @if($voted)<span class="float-end">{{ $perc }}%</span>@endif
            </li>
        @endforeach
    </ul>
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
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
        <p class="mb-0 small"><span
                class="vote-count">{{ $total }}</span> {{ \Illuminate\Support\Str::plural('Vote',$total) }}
        </p>
    </div>

    @if($poll->votes()->where('type','premium')->count() && request()->route()->getName() !== 'polls.single')
        @php
            $top_vote = $poll->votes()->where('type','premium')->orderBy('stars','desc')->first();
        @endphp
        <div class="d-flex justify-content-between align-items-end">
            <div>
                Top premium Voter: {{ $top_vote->user->name }} ({{ $top_vote->stars }} <i
                    class="fa fa-star text-warning"></i>)<br>
                <span class="text-muted">{{ $top_vote->description }}</span>
            </div>
            <a href="{{ route('polls.single',$poll->id) }}" class="btn btn-primary">Details</a>
        </div>
    @endif

    @if(auth()->check() && auth()->user()->role == 'supporter' && $voted && request()->route()->getName() === 'polls.single')
        @php
            $votes_with_comment = $poll->votes()->whereNotNull('description')->orderBy('created_at','desc')->get();
        @endphp
        <h6 class="mb-1 fw-bold">Comments</h6>
        @foreach($votes_with_comment as $v_comment)
            <div>
                <small class="text-muted float-end">{{ $v_comment->created_at }}</small>
                {{ $v_comment->user->name }} ({{ $v_comment->stars }} <i
                    class="fa fa-star text-warning"></i>)<br>
                <span class="text-muted">{{ $v_comment->description }}</span>
            </div>
        @endforeach
        @if($votes_with_comment->count() === 0)
            <p class="mb-0 text-muted">No comments</p>
        @endempty
    @endif
</div>
@if(auth()->check() && auth()->id() == $poll->user_id)
    <div class="d-flex justify-content-end mb-5">
        <form action="{{ route('polls.delete', $poll->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the poll?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger me-2">Delete Poll</button>
        </form>
        <a href="{{ route('polls.edit',$poll->id) }}" class="btn btn-warning me-2">Edit</a>
        @if(request()->route()->getName() !== 'polls.archived')
            <form action="{{ route('polls.finalize', $poll->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive the poll?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary">Finalize Poll</button>
            </form>
        @else
            <form action="{{ route('polls.finalize', $poll->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive the poll?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary">Unarchive</button>
            </form>
        @endif
    </div>
@endif
