@extends('adminlte::page')

@section('title', 'Chart Sample')

@section('content_header')
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
@stop

@section('content')
  <div class="container-fluid">
    <div class="row d-flex">  <div class="col-md-6 flex-grow-1">  <div class="card">
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
      <div class="col-md-6 flex-grow-1">  <div class="card">
          <div class="card-header">
            <h3 class="card-title">Price Chart</h3>
          </div>
          <div class="card-body">
            <div class="p-6 bg-white rounded shadow">
              {!! $priceChart->container() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop


@section('css')
    {{-- Add custom CSS styles here --}}
@stop

@section('js')
    <script src="{{ $productchart->cdn() }}"></script>
    <script src="{{ $priceChart->cdn() }}"></script>

    {{ $productchart->script() }}
    {{ $priceChart->script() }}
@stop


