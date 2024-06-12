@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <x-ordertable :headers="['ID', 'Name', 'Total', 'Update']" :rows="$orders->map(function($order) {
            return [
                $order->id, 
                $order->user->name, 
                $order->total, 
                'update' 
            ];
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