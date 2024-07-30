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
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Subcategories</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @php
                                    $subcategoryNames = $subcategories
                                        ->where('parent_id', $category->id)
                                        ->pluck('name')
                                        ->implode('<br>');
                                @endphp
                                {!! $subcategoryNames !!}
                            </td>
                            <td>
                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                    class="btn btn-sm btn-warning mr-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
