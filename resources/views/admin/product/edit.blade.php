@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product</h1>
    <a href="{{ route('admin.products') }}" class="btn btn-danger">Back</a>
@stop

@section('content')
    <div class="py-12">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <h3>Product Details</h3>
                            <hr>
                            <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="product_id" class="form-label">Product ID:</label>
                                    <input type="text" name="product_id" id="product_id" class="form-control"
                                        value="{{ old('product_id', $product->id) }}" readonly>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $product->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="form-label">Description:</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        value="{{ old('description', $product->description) }}">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="price" class="form-label">Price:</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                        value="{{ old('price', $product->price) }}">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <h3 style="cursor: pointer;" id="toggleInventory">Inventory Details</h3>
                                <hr>

                                <div id="inventoryDetails" style="display: none;">
                                    <hr>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th style="width: 120px;">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sizes as $size)
                                                @foreach ($colors as $color)
                                                    @php
                                                        $inventory = $inventories
                                                            ->where('size_id', $size->id)
                                                            ->where('color_id', $color->id)
                                                            ->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $size->name }}</td>
                                                        <td>{{ $color->name }}</td>
                                                        <td style="width: 120px;">
                                                            <input type="number"
                                                                name="inventories[{{ $size->id }}_{{ $color->id }}][quantity]"
                                                                class="form-control"
                                                                value="{{ old('inventories.' . $size->id . '_' . $color->id . '.quantity', $inventory ? $inventory->quantity : 0) }}">
                                                            <input type="hidden"
                                                                name="inventories[{{ $size->id }}_{{ $color->id }}][size_id]"
                                                                value="{{ $size->id }}">
                                                            <input type="hidden"
                                                                name="inventories[{{ $size->id }}_{{ $color->id }}][color_id]"
                                                                value="{{ $color->id }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button type="submit" class="btn btn-danger">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggleInventory').click(function() {
                $('#inventoryDetails').toggle();
            });
        });
    </script>
@stop
