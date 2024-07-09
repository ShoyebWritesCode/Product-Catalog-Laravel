@extends('adminlte::page')

@section('title', 'Payment History')

@section('content_header')
    <h1>Payment History</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Transaction ID</th>
                                <th>Amount Total</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Receipt URL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentHistories as $paymentHistory)
                                <tr>
                                    <td>{{ $paymentHistory->order_id }}</td>
                                    <td>{{ $paymentHistory->transaction_id }}</td>
                                    <td>{{ $paymentHistory->amount_total }}</td>
                                    <td>{{ $paymentHistory->payment_method }}</td>
                                    <td>{{ $paymentHistory->payment_status }}</td>
                                    <td><a href="{{ $paymentHistory->receipt_url }}" target="_blank">View Receipt</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
