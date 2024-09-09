@extends('adminlte::page')

@section('title', 'Attributes')

@section('content_header')
    <h1>Attributes</h1>
@stop

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
            <p></p>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#inventoryModal">
                Add Attribute
            </a>
            <div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="inventoryModalLabel">
                                Add a New Attribute </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.attributes.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Attribute Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
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
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Attribute</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attributes as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('js')
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
