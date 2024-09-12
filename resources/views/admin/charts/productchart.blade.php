<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Chart</h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <select class="form-control float-right" id="product-chart-filter">
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Time</option>
                    <option value="last7" {{ request('filter') == 'last7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="last7weeks" {{ request('filter') == 'last7weeks' ? 'selected' : '' }}>Last 7 Weeks
                    </option>
                    <option value="12months" {{ request('filter') == '12months' ? 'selected' : '' }}>Last 12 Months
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="p-6 bg-white rounded shadow" id="chart"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var chartOptions = {
            chart: {
                type: 'pie'
            },
            series: @json($quantities),
            labels: @json($labels)
        };

        var chart = new ApexCharts(document.querySelector("#chart"), chartOptions);
        chart.render();

        $('#product-chart-filter').change(function(e) {
            e.preventDefault();
            var filter = $(this).val();
            $.ajax({
                url: "{{ url('/admin/charts') }}",
                method: 'GET',
                data: {
                    filter: filter,

                },
                success: function(response) {
                    var newOptions = {
                        series: response.quantities,
                        labels: response.labels
                    };

                    chart.updateOptions(newOptions);
                }
            });
        });
    });
</script>
