<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Chart</h3>
        <div class="card-tools">
            <form id="filter-form" action="{{ route('admin.charts.index') }}" method="GET">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <select class="form-control float-right" id="product-chart-filter" name="filter"
                        onchange="this.form.submit()">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Time</option>
                        <option value="last7" {{ request('filter') == 'last7' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="last7weeks" {{ request('filter') == 'last7weeks' ? 'selected' : '' }}>Last 7
                            Weeks</option>
                        <option value="12months" {{ request('filter') == '12months' ? 'selected' : '' }}>Last 12 Months
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="p-6 bg-white rounded shadow" id="product-chart-container">
            {!! $productchart->container() !!}
        </div>
    </div>
</div>

<script>
    // document.getElementById('product-chart-filter').addEventListener('change', function() {
    //     this.form.submit();

    // });

    document.getElementById('product-chart-filter').addEventListener('change', function(e) {
        e.preventDefault();
        var filter = this.value;
        var url = "{{ route('admin.charts.index') }}" + "?filter=" + filter;

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
