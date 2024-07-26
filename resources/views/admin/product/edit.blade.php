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
                            @if (session('success'))
                                <div class="alert alert-success mb-4 duration-300" role="alert" id="successAlert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <h3 class="bg-gray rounded p-2">Product Details</h3>
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
                                <!-- Featured Checkbox -->
                                <div class="mb-4 form-check">
                                    <input type="checkbox" name="featured" id="featured" class="form-check-input"
                                        value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                    <label for="featured" class="form-check-label">Featured</label>
                                </div>

                                <!-- New Checkbox -->
                                <div class="mb-4 form-check">
                                    <input type="checkbox" name="new" id="new" class="form-check-input"
                                        value="1" {{ old('new', $product->new) ? 'checked' : '' }}>
                                    <label for="new" class="form-check-label">New</label>
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

                                <!-- Images Display -->
                                <h3>Images</h3>
                                <hr>
                                <div class="row">
                                    @foreach ($product->images as $image)
                                        <div class="col-md-1 mb-3 d-flex justify-content-center">
                                            <div class="image-container">
                                                <img src="{{ asset('storage/images/' . $image->path) }}"
                                                    class="img-fluid w-48 h-48" alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                                <div class="mb-4 px-2">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Add More
                                        Images:</label>
                                    <div id="imageInputs">
                                        <input type="file" name="images[]" id="images"
                                            class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                                            accept="image/*" multiple>
                                    </div>
                                </div>


                                <h3 style="cursor: pointer;" id="toggleInventory"
                                    class="flex items-center justify-between bg-gray rounded p-2 cursor-pointer w-1/4">
                                    <span>Inventory Details</span>
                                    <i class="fas fa-chevron-down"></i>
                                </h3>

                                <hr>

                                <div id="inventoryDetails" style="display: none;">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="py-2">Size</th>
                                                <th class="py-2">Color</th>
                                                <th class="py-2" style="width: 120px;">Quantity</th>

                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-transparent">
                                            @foreach ($sizes as $size)
                                                @foreach ($colors as $color)
                                                    @php
                                                        $inventory = $inventories
                                                            ->where('size_id', $size->id)
                                                            ->where('color_id', $color->id)
                                                            ->first();
                                                    @endphp
                                                    <tr class="@if ($loop->index % 2 == 0) bg-red-500 @endif">
                                                        <td class="py-1">{{ $size->name }}</td>
                                                        <td class="py-1">{{ $color->name }}</td>
                                                        <td class="py-1" style="width: 120px; ">
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
            $('#successAlert').fadeOut(2000);
        });

        document.getElementById('addMore').addEventListener('click', function() {
            var div = document.createElement('div');
            div.innerHTML =
                '<input type="file" name="images[]" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">';
            document.getElementById('imageInputs').appendChild(div);
        });
        // $(document).ready(function() {

        // });
    </script>
@stop
