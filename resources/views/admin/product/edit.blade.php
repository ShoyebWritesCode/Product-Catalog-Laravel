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

                                <div class="accordion" id="inventoryAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingRed">
                                            <button class="accordion-button" type="button" style="background-color: red ;"
                                                data-bs-toggle="collapse" data-bs-target="#collapseRed" aria-expanded="true"
                                                aria-controls="collapseRed">
                                                Red
                                            </button>

                                        </h2>
                                        <div id="collapseRed" class="accordion-collapse collapse show"
                                            aria-labelledby="headingRed" data-bs-parent="#inventoryAccordion">
                                            <div class="accordion-body">
                                                <div class="mb-4">
                                                    <label for="quantitySR" class="form-label">Quantity SR:</label>
                                                    <input type="number" name="quantitySR" id="quantitySR"
                                                        class="form-control" value="{{ old('quantitySR') }}">
                                                    @error('quantitySR')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label for="quantityMR" class="form-label">Quantity MR:</label>
                                                    <input type="number" name="quantityMR" id="quantityMR"
                                                        class="form-control" value="{{ old('quantityMR') }}">
                                                    @error('quantityMR')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label for="quantityLR" class="form-label">Quantity LR:</label>
                                                    <input type="number" name="quantityLR" id="quantityLR"
                                                        class="form-control" value="{{ old('quantityLR') }}">
                                                    @error('quantityLR')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingBlue">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseBlue"
                                                style="background-color: blue" aria-expanded="false"
                                                aria-controls="collapseBlue">
                                                Blue
                                            </button>
                                        </h2>
                                        <div id="collapseBlue" class="accordion-collapse collapse"
                                            aria-labelledby="headingBlue" data-bs-parent="#inventoryAccordion">
                                            <div class="accordion-body">
                                                <div class="mb-4">
                                                    <label for="quantitySB" class="form-label">Quantity SB:</label>
                                                    <input type="number" name="quantitySB" id="quantitySB"
                                                        class="form-control" value="{{ old('quantitySB') }}">
                                                    @error('quantitySB')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label for="quantityMB" class="form-label">Quantity MB:</label>
                                                    <input type="number" name="quantityMB" id="quantityMB"
                                                        class="form-control" value="{{ old('quantityMB') }}">
                                                    @error('quantityMB')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label for="quantityLB" class="form-label">Quantity LB:</label>
                                                    <input type="number" name="quantityLB" id="quantityLB"
                                                        class="form-control" value="{{ old('quantityLB') }}">
                                                    @error('quantityLB')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingGreen">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseGreen"
                                                style="background-color: green " aria-expanded="false"
                                                aria-controls="collapseGreen">
                                                Green
                                            </button>
                                        </h2>
                                        <div id="collapseGreen" class="accordion-collapse collapse"
                                            aria-labelledby="headingGreen" data-bs-parent="#inventoryAccordion">
                                            <div class="accordion-body">
                                                <div class="mb-4">
                                                    <label for="quantitySG" class="form-label">Quantity SG:</label>
                                                    <input type="number" name="quantitySG" id="quantitySG"
                                                        class="form-control" value="{{ old('quantitySG') }}">
                                                    @error('quantitySG')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label for="quantityMG" class="form-label">Quantity MG:</label>
                                                    <input type="number" name="quantityMG" id="quantityMG"
                                                        class="form-control" value="{{ old('quantityMG') }}">
                                                    @error('quantityMG')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label for="quantityLG" class="form-label">Quantity LG:</label>
                                                    <input type="number" name="quantityLG" id="quantityLG"
                                                        class="form-control" value="{{ old('quantityLG') }}">
                                                    @error('quantityLG')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@stop
