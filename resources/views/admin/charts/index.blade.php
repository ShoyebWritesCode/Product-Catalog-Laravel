@extends('adminlte::page')

@section('title', 'Charts')

@section('content_header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@stop

@section('content')
    <div class="container-fluid parent">
        <div class="row d-flex">

            <div class="col-md-6 flex-grow-1" id="product-chart-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product Chart</h3>
                        <div class="card-tools">
                            <form id="filter-form" action="{{ route('admin.charts.index') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <select class="form-control float-right" id="product-chart-filter" name="filter"
                                        onchange="this.form.submit()">
                                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Time
                                        </option>
                                        <option value="last7" {{ request('filter') == 'last7' ? 'selected' : '' }}>Last 7
                                            Days</option>
                                        <option value="last7weeks"
                                            {{ request('filter') == 'last7weeks' ? 'selected' : '' }}>Last 7
                                            Weeks</option>
                                        <option value="12months" {{ request('filter') == '12months' ? 'selected' : '' }}>
                                            Last 12 Months
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="p-6 bg-white rounded shadow" id="chart">
                            {{-- {!! $productchart->container() !!} --}}
                        </div>
                    </div>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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

        // document.getElementById('product-chart-filter').addEventListener('change', function(e) {
        //     alert('hello');
        //     var filter = this.value;
        //     var url = "{{ route('admin.charts.index') }}" + "?is_ajax=1&filter=" + filter;

        //     fetch(url)
        //         .then(response =>
        //             console.log(response)
        //         )
        //         .then(data => {

        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // });

        var options = {
            chart: {
                type: 'pie'
            },
            series: @json($quantities),
            labels: @json($labels)
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@stop
