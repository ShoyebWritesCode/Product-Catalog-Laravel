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
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id) }}"
                                    class="btn btn-sm btn-warning mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.product.delete', $product->id) }}" method="POST"
                                    class="inline">
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
        $(document).ready(function() {
            $('#successAlert').fadeOut(2000);
        });
    </script>
@stop
