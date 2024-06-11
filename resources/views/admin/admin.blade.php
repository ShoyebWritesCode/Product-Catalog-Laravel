@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        @include('components.index', [
            'title' => 'Products',
            'number' => $totalProducts,
            'icon' => 'fas fa-box',
            'color' => 'info',
            'link' => route("admin.products"),
            'link_text' => 'More info'
        ])
        @include('components.index', [
            'title' => 'Users',
            'number' => $totalUsers,
            'icon' => 'fas fa-users',
            'color' => 'success',
            'link' => route("admin.users"),
            'link_text' => 'More info'
        ])
        @include('components.index', [
            'title' => 'Categories',
            'number' => $totalCategories,
            'icon' => 'fas fa-th-large',
            'color' => 'warning',
            'link' => route("admin.categories"),
            'link_text' => 'More info'
        ])
        @include('components.index', [
            'title' => 'Reviews',
            'number' => $totalReviews,
            'icon' => 'fas fa-comments',
            'color' => 'danger',
            'link' => route("admin.reviews"),
            'link_text' => 'More info'
        ])
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
