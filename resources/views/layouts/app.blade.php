<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/morph.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stack('styles')
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SV | Homepage') }}</title>
</head>
<body class="bg-white">
<header class="container">
    <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Supporter<span class="text-primary">Votes</span>.com
                <small class="small font-weight-normal" style="font-size: 13px;">BETA</small></a>
            <ul class="navbar-nav ms-auto flex-row">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item me-2">
                            <a class="btn btn-info" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if(auth()->user()->role === 'creator')
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('balance') }}">{{ __('Balance') }}</a>
                        </li>
                    @endif
                    @if(auth()->user()->role !== 'admin')
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('profile') }}">{{ __('Profile') }}</a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="nav-link" href="#">{{ __('Admin') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>
@yield('content')
<footer class="bg-light p-4">
    <div class="text-center">Copyright © 2023 www.supportervotes.com. All rights reserved.</div>
</footer>
@if(isset($stars))
    <div class="modal fade" id="premium-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <form action="#" id="premium-vote-form">
                        <div class="alert alert-danger d-none"></div>
                        <input type="hidden" id="pvf-id" name="id">
                        <input type="hidden" id="pvf-poll-id" name="poll_id">
                        <input type="hidden" id="pvf-type" name="type">
                        <input type="hidden" id="pvf-stars" name="stars">
                        <p>You're using <span class="stars-count">0</span> stars <i class="fa fa-star text-warning"></i>
                            in this vote.</p>
                        <div class="form-group mb-3">
                            <label class="small mb-1">Comment (Optional)</label>
                            <textarea name="description" id="vote-comment" class="form-control"></textarea>
                        </div>
                        <div>
                            <button data-bs-dismiss="modal" type="button" class="btn btn-outline-primary px-4">Cancel
                            </button>
                            <button type="submit" class="btn btn-primary px-4 mx-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@if(!isset($jquery_added))
    <script src="{{ asset('js/jquery.min.js') }}"></script>
@endif
@if(in_array(request()->route()->getName(),['vote','profile','polls.single']) && (isset($polls) || isset($poll)))
    <script>
        $('.copy-to-clipboard').click((e) => {
            let text = $(e.target).is('li') ? $(e.target).closest('li').find('input').val() : $(e.target).find('input').val()
            let TempText = document.createElement("input");
            TempText.value = text;
            document.body.appendChild(TempText);
            TempText.select();

            document.execCommand("copy");
            document.body.removeChild(TempText);
        })
        let user_stars = {{ $stars ?? 0 }};
        $('input[type=radio][name^="role-"]').on('change', e => {
            @guest()
                window.location.href = "{{ route('login') }}";
            @else
            if (e.target.value == 'premium') {
                if (user_stars < 1) {
                    $(e.target).closest('.single-poll').find('.alert-stars').text('You need to support creator in order to make a premium vote.').removeClass('d-none');
                }
                $(e.target).closest('.single-poll').find('.premium-options').removeClass('d-none')
            } else {
                $(e.target).closest('.single-poll').find('.premium-options').addClass('d-none')
                if(!$(e.target).closest('.single-poll').find('.alert-stars').hasClass('d-none')){
                    $(e.target).closest('.single-poll').find('.alert-stars').addClass('d-none')
                }
            }
            @endif
        })
        @if(isset($stars))
        $('input[type=radio][name^="stars-value-"]').on('change', e => {
            let stars = user_stars * (e.target.value / 100)
            $(e.target).parent().find('.stars-inp').val(stars.toFixed(0));
        })
        @endif
    </script>
    <script>
        $(document).on('submit', '#premium-vote-form', e => {
            e.preventDefault()
            @guest()
                window.location.href = "{{ route('login') }}";
            @else
            let option_id = $('#pvf-id').val()
            let type = $('#pvf-type').val()
            let stars = $('#pvf-stars').val()
            let poll_id = $('#pvf-poll-id').val()
            let comment = $('#vote-comment').val()
            $.ajax({
                url: "{{ route('vote') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    poll_option_id: option_id,
                    type,
                    stars,
                    description: comment
                },
                success: r => {
                    resp = JSON.parse(r)
                    if (resp.success) {
                        let votes = []
                        let total = 0;
                        let poll_id = resp.votes[0].poll_id
                        $(`#poll-${poll_id}`).find(`input[type=radio][name=role-${poll_id}]`).attr('disabled', 'disabled')
                        $(`#poll-${poll_id}`).find(`.premium-options`).remove()
                        $(`#poll-${poll_id} li[data-id=${option_id}]`).addClass('my-option')
                        resp.votes.map(vote => {
                            let id = vote.id, count = vote.votes
                            total += +count
                            votes.push({
                                id,
                                count
                            });
                            votes.sort((a, b) => a.count > b.count ? -1 : 1)
                        })
                        $(`ul[data-poll-id="${poll_id}"]`).closest('.card-body').find('.vote-count').text(total.toFixed(0));
                        for (let i in votes) {
                            let perc = (votes[i].count / total) * 100
                            if (i == 0) {
                                $(`ul[data-poll-id="${poll_id}"] li[data-id="${votes[i].id}"]`).removeClass('text-center vote-open').css('background', `linear-gradient(to right, #2e86a6 ${perc}%, #ffffff ${perc}%)`).append(`<span class="float-end">${perc.toFixed(0)}%</span>`)
                            } else {
                                $(`ul[data-poll-id="${poll_id}"] li[data-id="${votes[i].id}"]`).removeClass('text-center vote-open').css('background', `linear-gradient(to right, #88c1d7 ${perc}%, #ffffff ${perc}%)`).append(`<span class="float-end">${perc.toFixed(0)}%</span>`)
                            }
                        }
                        user_stars -= stars
                        $('#user-stars').text(user_stars)
                        $('.stars-inp').each((k, v) => $(v).val((user_stars * (25 / 100)).toFixed(0)))
                        $(`#poll-res-${poll_id}`).removeClass('d-none').find('.spent-count').text(stars)
                        $('#premium-modal').modal('hide');
                    } else {
                        $(e.target).find('.alert').text(resp.message).removeClass('d-none')
                        setTimeout(() => {
                            $(e.target).find('.alert').addClass('d-none')
                        }, 1500)
                    }
                }
            })
            @endif
        })
        $(document).on('click', '.user-vote li.vote-open', e => {
            e.preventDefault()
            @guest()
                window.location.href = "{{ route('login') }}";
            @else
            let option_id = $(e.target).data('id')
            let poll_id = $(e.target).closest(`ul[data-poll-id]`).data('poll-id')
            let type = $(`#poll-${poll_id}`).find(`input[type=radio][name=role-${poll_id}]:checked`).val()
            let stars = null
            if (type === 'premium') {
                let stars = $(`#poll-${poll_id}`).find('.stars-inp').val()
                $('#premium-modal .stars-count').text(stars)
                $('#premium-modal').modal('show');
                $('#pvf-id').val(option_id)
                $('#pvf-type').val(type)
                $('#pvf-stars').val(stars)
                $('#pvf-poll-id').val(poll_id)
                return;
            }
            $.ajax({
                url: "{{ route('vote') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    poll_option_id: option_id
                },
                success: r => {
                    resp = JSON.parse(r)
                    if (resp.success) {
                        let votes = []
                        let total = 0;
                        let poll_id = resp.votes[0].poll_id
                        $(`#poll-${poll_id}`).find(`input[type=radio][name=role-${poll_id}]`).attr('disabled', 'disabled')
                        $(`#poll-${poll_id}`).find(`.premium-options`).remove()
                        $(`#poll-${poll_id} li[data-id=${option_id}]`).addClass('my-option')
                        resp.votes.map(vote => {
                            let id = vote.id, count = vote.votes
                            total += +count
                            votes.push({
                                id,
                                count
                            });
                            votes.sort((a, b) => a.count > b.count ? -1 : 1)
                        })
                        $(`ul[data-poll-id="${poll_id}"]`).closest('.card-body').find('.vote-count').text(total.toFixed(0));
                        for (let i in votes) {
                            let perc = (votes[i].count / total) * 100
                            if (i == 0) {
                                $(`ul[data-poll-id="${poll_id}"] li[data-id="${votes[i].id}"]`).removeClass('text-center vote-open').css('background', `linear-gradient(to right, #2e86a6 ${perc}%, #ffffff ${perc}%)`).append(`<span class="float-end">${perc.toFixed(0)}%</span>`)
                            } else {
                                $(`ul[data-poll-id="${poll_id}"] li[data-id="${votes[i].id}"]`).removeClass('text-center vote-open').css('background', `linear-gradient(to right, #88c1d7 ${perc}%, #ffffff ${perc}%)`).append(`<span class="float-end">${perc.toFixed(0)}%</span>`)
                            }
                        }
                    } else {
                        $(e.target).closest('.card-body').find('.alert').text(resp.message).removeClass('d-none')
                        setTimeout(() => {
                            $(e.target).closest('.card-body').find('.alert').addClass('d-none')
                        }, 2000)
                    }
                }
            })
            @endif
        })
    </script>
@endif
@stack('scripts')
</body>
</html>
