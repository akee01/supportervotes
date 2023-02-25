@extends('layouts.app')
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="listing-header p-4">
                        <form action="{{ route('profile.update') }}" method="POST" class="d-inline my-3">
                            @csrf
                            @method('PUT')
                            <h2 class="h3 mb-3 fw-bold">Profile</h2>
                            @include('layouts._alert')
                            <div class="form-group mb-4">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            </div>
                            <div class="form-group mb-4">
                                <label>Name</label>
                                <input type="text" class="form-control inp-name" name="name" value="{{ auth()->user()->name }}"
                                       data-limit="64" required>
                                <span class="word-count small text-muted text-end d-block" data-input="inp-name"
                                      data-limit="64"></span>
                                @error('name')
                                <span class="small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @if(auth()->user()->role == 'creator')
                            <div class="form-group mb-4">
                                <label>Stars per USD($)</label>
                                <input type="number" step="any" class="form-control inp-name" name="star_rate" value="{{ auth()->user()->star_rate }}" required>
                                @error('star_rate')
                                <span class="small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif
                            <div class="form-group mb-4">
                                <label>Details</label>
                                <textarea rows="5" name="detail" class="form-control inp-details" data-limit="2000"
                                          required>{{ auth()->user()->detail }}</textarea>
                                <span class="word-count small text-muted text-end d-block" data-input="inp-details"
                                      data-limit="2000"></span>
                                @error('detail')
                                <span class="small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group text-end">
                                <button class="btn btn-primary">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function handleWordCount(e = undefined) {
            if (e !== undefined) {
                if (e.target.value.length > $(e.target).data('limit')) {
                    e.target.value = e.target.value.substr(0, $(e.target).data('limit'));
                }
            }
            $('.word-count').each((k, v) => {
                limit = $(v).data('limit');
                elem = $(`.${$(v).data('input')}`).val().length;
                $(v).text(`${elem} of ${limit} characters.`);
            })
        }

        $('.inp-name,.inp-details').on('input', handleWordCount);
        handleWordCount();
    </script>
@endpush
