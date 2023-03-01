@extends('layouts.app')
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 p-5">
                    <h1 class="fw-bolder mb-3">Balance: {{ auth()->user()->c_payments()->where('payment_status','settled')->sum('amount') ?? 0 }} USD</h1>
                    @include('layouts._alert')
                    <div class="d-flex justify-content-between">
                        <h2 class="mb-0 h4 fw-bold">Received Payments</h2>
                        <div class="text-end">
                            <form action="@if($payments->where('payment_status', 'settled')->count() > 0) {{ route('withdraw') }} @else {{ '#' }} @endif" method="POST">
                                @csrf
                                <button @if($payments->where('payment_status', 'settled')->count() < 1) disabled @endif class="btn btn-sm btn-primary">Withdraw</button>
                            </form>
                            @if(auth()->user()->c_payments()->where('payment_status','requested')->sum('amount') > 0)
                                <p class="mb-0 text-muted small">Requested Withdrawal Amount: {{ auth()->user()->c_payments()->where('payment_status','requested')->sum('amount') }} USD</p>
                            @endif
                        </div>

                    </div>
                    <hr>
                    <table class="table table-borderless table-striped table-hover">
                        <thead>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Time</th>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->user->name }}</td>
                                <td>{{ $payment->amount.' '.$payment->currency }}</td>
                                <td><span class="badge bg-success">{{ $payment->payment_status }}</span></td>
                                <td>{{ $payment->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
