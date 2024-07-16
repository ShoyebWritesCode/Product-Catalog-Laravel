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
                            <hr>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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

                                <div class="mb-4">
                                    <h3>Inventory</h3>
                                    <label for="product_id" class="form-label">Product ID:</label>
                                    <input type="text" name="product_id" id="product_id" class="form-control"
                                        value="{{ old('product_id', $product->id) }}" readonly>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="size" class="form-label">Size:</label>
                                    <select name="size" id="size" class="form-control">
                                        <option value="">Select Size</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->name }}">
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('size')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="color" class="form-label">Color:</label>
                                    <select name="color" id="color" class="form-control">
                                        <option value="">Select Color</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->name }}">
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4" id="quantity-container" style="display: none;">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control"
                                        value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeSelect = document.getElementById('size');
            const colorSelect = document.getElementById('color');
            const quantityContainer = document.getElementById('quantity-container');

            function checkSelections() {
                if (sizeSelect.value && colorSelect.value) {
                    quantityContainer.style.display = 'block';
                } else {
                    quantityContainer.style.display = 'none';
                }
            }

            sizeSelect.addEventListener('change', checkSelections);
            colorSelect.addEventListener('change', checkSelections);
        });
    </script>
@stop
