@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Product Dashboard</h1>
@stop

@section('content')


    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
            <p></p>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                Add Product
            </a>
        </div>
        <hr class="mb-4">
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert" id="successAlert">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Featured</th>
                        <th>New</th>
                        <th>Price</th>
                        <th>Inventory</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->featured)
                                    <i class="fas fa-check text-success fa-lg"></i>
                                @else
                                    <i class="fas fa-times text-danger fa-lg"></i>
                                @endif
                            </td>
                            <td>
                                @if ($product->new)
                                    <i class="fas fa-check text-success fa-lg"></i>
                                @else
                                    <i class="fas fa-times text-danger fa-lg"></i>
                                @endif
                            </td>

                            <td>{{ $product->price }}</td>
                            <td>
                                <a href="#" class="">
                                    {{ $product->totalQuantity() }}
                                </a>
                            </td>

                            <td class="d-flex align-items-center">

                                <a href="#" class="btn btn-sm btn-success mr-2" data-toggle="modal"
                                    data-target="#inventoryModal{{ $product->id }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <div class="modal fade" id="inventoryModal{{ $product->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="inventoryModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="inventoryModalLabel{{ $product->id }}">Add
                                                    Inventory for Product #{{ $product->id }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="#" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="quantity">Quantity</label>
                                                        <input type="number" class="form-control" id="quantity"
                                                            name="quantity" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Add to Inventory</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <a href="{{ route('admin.product.edit', $product->id) }}"
                                    class="btn btn-sm btn-warning mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.product.delete', $product->id) }}" method="POST"
                                    class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openModal(btn) {
            var target = $(btn).data('target');
            $(target).modal('show');
        }
        $(document).ready(function() {
            $('#successAlert').fadeOut(2000);
        });
    </script>
@stop
