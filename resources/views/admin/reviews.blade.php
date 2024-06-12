@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-table :headers="['ID', 'Product', 'User', 'Comment', 'Rating']" :rows="$reviews->map(function($review) {
                $userName = $review->user->name ?? 'Anonymous';
                return [$review->id, $review->product->name, $userName, $review->comment, $review->rating];
            })"/>
        </div>
        
    </div>
    @stop

    @section('css')
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @stop
    
    @section('js')
        <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    @stop