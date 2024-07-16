@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sizes Dashboard</h1>
@stop

@section('content')

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
            <p></p>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                Add Size
            </a>
            <div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="inventoryModalLabel">Add
                                Add a new Size</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Size</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mb-4">
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert" id="successAlert">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <x-table :headers="['ID', 'Name', 'Description']" :rows="$sizess->map(function ($size) {
                return [$size->id, $size->name, $size->description];
            })" />
        </div>
    </div>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openModal(btn) {
            var target = $(btn).data('target');
            $(target).modal('show');
        }
        $(document).ready(function() {
            $('#successAlert').fadeOut(2000);
        });
    </script>
@stop
