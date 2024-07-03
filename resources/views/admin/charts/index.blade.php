@extends('adminlte::page')

@section('title', 'Charts')

@section('content_header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
@stop

@section('content')
    <div class="container-fluid parent">
        <div class="row d-flex">

            <div class="col-md-6 flex-grow-1" id="product-chart-wrapper">
                @include('admin.charts.productchart')
            </div>


            <div class="col-md-6 flex-grow-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Price Chart</h3>
                        {{-- <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <select class="form-control float-right" id="price-chart-filter">
                                    <option value="all">All Time</option>
                                    <option value="last7">Last 7 Days</option>
                                    <option value="last7weeks">Last 7 Weeks</option>
                                    <option value="12months">Last 12 Months</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="bg-white rounded shadow chart-container" id="price-chart-container">
                            {!! $priceChart->container() !!}
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12 flex-grow-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Chart</h3>
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

    <script>
        // document.getElementById('product-chart-filter').addEventListener('change', function() {
        //     this.form.submit();

        // });

        document.getElementById('product-chart-filter').addEventListener('change', function(e) {
            alert('hello');
            var filter = this.value;
            var url = "{{ route('admin.charts.index') }}" + "?is_ajax=1&filter=" + filter;

            fetch(url)
                .then(response =>
                    console.log(response)
                )
                .then(data => {

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@stop
