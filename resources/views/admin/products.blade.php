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
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <x-table :headers="['ID', 'Name', 'Price']" :rows="$products->map(function($product) {
                return [$product->id, $product->name, $product->price];
            })"/>
        </div>
    </div>
@stop
