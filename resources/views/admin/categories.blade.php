@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
            <p></p>
            <a href="{{ route('admin.catagory.create') }}" class="btn btn-primary">
                Add Category
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
            <x-table :headers="['ID', 'Category', 'Subcategories']" :rows="$categories->map(function ($category) use ($subcategories) {
                $subcategoryNames = $subcategories
                    ->where('parent_id', $category->id)
                    ->pluck('name')
                    ->implode('<br>');
                return [$category->id, $category->name, $subcategoryNames];
            })" />
        </div>

    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
