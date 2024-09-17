@extends('adminlte::page')

@section('title', 'Order Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-2xl font-bold mb-2">Order Details</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @if ($order)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Order #{{ $order->id }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td class="text-center">

                                                <img src="{{ asset('storage/images/' . $item->product->images->first()->path) }}"
                                                    alt="{{ $item->product_name }}" class="img-thumbnail"
                                                    style="width: 75px; height: 75px;">
                                            </td>
                                            <td class="text-center">{{ $item->product_name }}</td>
                                            <td class="text-center text-red-600">{{ $item->product_price }} BDT</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <span class="text-lg font-bold">Total: {{ $order->total }} BDT</span>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Address Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-lg font-bold">City: {{ $order->city }}</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-lg font-bold">Address: {{ $order->address }}</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-lg font-bold">Phone No.: {{ $order->phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end align-items-right">
                        <form id="updateForm_{{ $order->id }}" class="update-form" data-order-id="{{ $order->id }}"
                            method="POST" action="{{ route('admin.pendingorders.update', $order->id) }}"
                            style="display: inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success update-btn">
                                Update Status
                            </button>
                        </form>
                        {{-- <button id="update-status-button" class="btn btn-success" data-id="{{ $order->id }}">Update Status</button> --}}
                    </div>
                @else
                    <p class="text-center text-gray-600">You have no open orders.</p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')

@stop
