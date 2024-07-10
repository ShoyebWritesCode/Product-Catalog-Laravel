@extends('adminlte::page')

@section('title', 'Payment History')

@section('content_header')
    <h1>Refund Requests</h1>
@stop

@section('content')
    <hr class="mb-4">
    @if (session('success'))
        <div class="alert alert-success mb-4" role="alert" id="successAlert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refundorders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td class="d-flex align-items-center">
                                        <a href="{{ route('admin.refund.accept', $order->id) }}"
                                            class="btn btn-sm btn-success mr-2">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                        <a href="{{ route('admin.refund.reject', $order->id) }}"
                                            class="btn btn-sm btn-danger mr-2">
                                            <i class="fas fa-minus-circle"></i>
                                        </a>
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
