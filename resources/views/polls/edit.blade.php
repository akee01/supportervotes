@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush
@section('content')
<section class="main-section align-items-start">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="listing-header p-4">
                    @include('layouts._alert')
                    <form action="{{ route('polls.update', $poll->id) }}" method="POST" class="d-inline my-3" id="poll-form">
                        @csrf
                        @method('PUT')
                        <h2 class="h3 mb-3 fw-bold">Update poll</h2>
                        <div class="form-group mb-4">
                            <label>Question</label>
                            <input type="text" class="form-control" value="{{ $poll->question }}" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label>Poll closing date</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" name="date" class="form-control" value="{{ \Carbon\Carbon::parse($poll->closing_at)->format('Y-m-d') }}">
                                </div>
                                <div class="col-6">
                                    <input type="time" name="time" class="form-control" value="{{ \Carbon\Carbon::parse($poll->closing_at)->format('H:i') }}">
                                </div>
                            </div>
                        </div>
                        <div id="alert" class="alert alert-danger d-none">You cannot add more than 10 options</div>
                        <div class="form-group mb-4 option-elements">
                            <label class="d-flex justify-content-between"><span>Options <small>(Max 10 options.)</small></span>
                                <button type="button" class="btn btn-sm btn-primary add-option">Add Option</button>
                            </label>
                            @foreach($poll->options as $key => $option)
                            <div class="d-flex option-elem mb-3 align-items-start">

                                <span class="counter h4 py-2 pe-2">{{ $key+1 }}.</span>
                                <div class="w-100"><input type="text" class="form-control option" name="option[{{ $key+1 }}]" value="{{ $option->option }}" readonly required></div>
                                @if($option->votes > 0)<input type="hidden" name="finalised[]" value="{{ $option->id }}">@endif
                                <button @if($option->votes > 0) disabled @endif type="button" class="btn btn-danger ms-2 remove-option"><i class="fa fa-trash"></i></button>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group text-end">
                            <button type="button" data-bs-target="#cancel-modal" data-bs-toggle="modal"
                                    class="btn btn-outline-primary me-2">Cancel
                            </button>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">
                <p>Proceed with cancelling this poll? All changes will be lost!</p>
                <div>
                    <button data-bs-dismiss="modal" class="btn btn-outline-primary px-4">No</button>
                    <a href="{{ route('profile') }}" class="btn btn-primary px-4 mx-2">Yes</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $('#poll-form').validate();
    $(".option").each(function () {
        $(this).rules("add", {
            required: true
        });
    });
</script>
<script>
    $option_html = '<div class="d-flex align-items-start option-elem mb-3"><span class="counter h4 py-2 pe-2">`` num ``.</span><div class="w-100"><input type="text" class="form-control option" `` name `` required></div> <button type="button" class="btn btn-danger ms-2 remove-option"><i class="fa fa-trash"></i></button> </div>';
    $(document).on('click', '.add-option', e => {
        if ($('.option-elements .option-elem').length > 9) {
            $('#alert').removeClass('d-none');
            setTimeout(() => {
                $('#alert').addClass('d-none');
            }, 3500);
            return;
        }
        $('.option-elements').append($option_html.replace('`` num ``', $('.option-elements .option-elem').length + 1).replace('`` name ``', `name=option[${$('.option-elements .option-elem').length + 1}]`));
        // $('.option-elements').append($('.option-elem:first').clone().find('input').attr('name', `option[${$('.option-elements .option-elem').length + 1}]`).val('').parent().find('.counter').text(($('.option-elements .option-elem').length + 1) + '.').parent());
        console.log($(`[name="option[${$('.option-elements .option-elem').length}]"]`).length);
        $(document).find(`[name='option[${$('.option-elements .option-elem').length}]']`).each(function () {
            $(this).rules("add", {
                required: true
            });
        });
    })

    $(document).on('click', '.remove-option', e => {
        if ($('.option-elements .option-elem').length > 1) {
            $(e.target).closest('.option-elem').remove();
        }
        $('.counter').each((k, v) => {
            $(v).text((k+1)+'.');
        })
    })
</script>
@endpush
