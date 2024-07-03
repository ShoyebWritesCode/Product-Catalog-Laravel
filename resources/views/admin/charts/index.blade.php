@extends('adminlte::page')

@section('title', 'Chart Sample')

@section('content_header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@stop

@section('content')
    <div class="container-fluid parent">
        <div class="row d-flex">
            <div class="col-md-6 flex-grow-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product Chart</h3>
                    </div>
                    <div class="card-body">
                        <div class="p-6 bg-white rounded shadow">
                            {!! $productchart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 flex-grow-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Price Chart</h3>
                    </div>
                    <div class="card-body">
                        <div class=" bg-white rounded shadow chart-container">

                            {!! $priceChart->container() !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 flex-grow-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Price Chart</h3>
                    </div>
                    <div class="card-body">
                        <div class="p-6 bg-white rounded shadow">
                            {!! $salesChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')
    <style>
        body {
            transform: scale(0.75);
            transform-origin: top left;
            width: 133.333%;
            height: calc(133.333%);
        }
    </style>
@stop

@section('js')
    <script src="{{ $productchart->cdn() }}"></script>
    <script src="{{ $priceChart->cdn() }}"></script>
    <script src="{{ $salesChart->cdn() }}"></script>

    {{ $productchart->script() }}
    {{ $priceChart->script() }}
    {{ $salesChart->script() }}
@stop
