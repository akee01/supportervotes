@extends('layouts.app')
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 p-5">
                    @include('layouts._alert')
                    <div class="d-flex justify-content-between">
                        <h2 class="mb-0 h4 fw-bold">Withdrawal Requests</h2>
                    </div>
                    <hr>
                    @forelse($creators_awaiting_approval as $creator)
                        <div class="card card-body shadow">
                            <h5 class="d-flex justify-content-between align-items-center">Creator: {{ $creator->creator->name }}
                                <form action="{{ route('withdrawal.approve',$creator->creator->id) }}" method="POST">
                                    @csrf
                                    <button class=" btn btn-primary">Mark as done</button>
                                </form>
                            </h5>
                            <hr class="my-1">
                            <table class="table table-borderless table-striped table-hover">
                                <thead>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Time</th>
                                </thead>
                                <tbody>
                                @foreach($creator->creator->c_payments()->where('payment_status','requested')->latest()->get() as $payment)
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
                    @empty
                        <div>No pending withdrawals found!</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
