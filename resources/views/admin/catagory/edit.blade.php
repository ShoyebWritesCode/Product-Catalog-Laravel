@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    {{-- <h1>Edit Category</h1> --}}
    <a href="{{ route('admin.categories') }}" class="btn btn-danger ml-2">Back</a>
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
                            <h3 class="bg-gray rounded p-2">Category Details</h3>
                            <hr>
                            <form action="{{ route('admin.category.update', $category->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="product_id" class="form-label">Category ID:</label>
                                    <input type="text" name="product_id" id="product_id" class="form-control"
                                        value="{{ old('catagory_id', $category->id) }}" readonly>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $category->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <h3>Banners</h3>
                                <hr>
                                <div class="row">
                                    @if ($category->banners->count() == 0)
                                        <div class="col-md-12">
                                            <p>No banner found</p>
                                        </div>
                                    @else
                                        @foreach ($category->banners as $image)
                                            <div class="col-md-1 mb-3 d-flex justify-content-center">
                                                <div class="image-container">
                                                    <img src="{{ asset('storage/images/' . $image->banner) }}"
                                                        class="img-fluid w-48 h-48" alt="{{ $category->name }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>


                                <div class="mb-4 px-2">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Add More
                                        Banners:</label>
                                    <div id="imageInputs">
                                        <input type="file" name="images[]" id="images"
                                            class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                                            accept="image/*" multiple>
                                    </div>
                                </div>




                                <button type="submit" class="btn btn-success">Update</button>
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
