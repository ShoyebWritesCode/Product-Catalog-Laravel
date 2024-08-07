@extends('adminlte::page')

@section('title', 'Notifications')

@section('content_header')
    <h1>Notifications</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-tab" data-toggle="pill" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="unread-tab" data-toggle="pill" href="#unread" role="tab" aria-controls="unread" aria-selected="false">Unread</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="read-tab" data-toggle="pill" href="#read" role="tab" aria-controls="read" aria-selected="false">Read</a>
                            </li>
                        </ul>
                        <div>
                            {{-- <form id="markAllAsReadForm" method="POST" action="{{ route('admin.notifications.markAllAsRead') }}"> --}}
                                {{-- @csrf --}}
                               <a href="{{ route('admin.notifications.markAllAsRead') }}" id="markAllAsRead" class="btn btn-success ml-2">Mark All as Read</a>
                            {{-- </form> --}}
                            <a href="{{ route('admin.notifications.deleteAll') }}" id="markAllAsRead" class="btn btn-danger ml-2">Delete All </a>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            @include('admin.notification-list', ['notifications' => $notifications])
                        </div>
                        <div class="tab-pane fade" id="unread" role="tabpanel" aria-labelledby="unread-tab">
                            @include('admin.notification-list', ['notifications' => $unreadNotifications, 'unread' => true])
                        </div>
                        <div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="read-tab">
                            @include('admin.notification-list', ['notifications' => $readNotifications])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
     document.addEventListener('DOMContentLoaded', function() {
        const markAllButton = document.getElementById('markAllAsRead');

        markAllButton.addEventListener('click', function(event) {
            event.preventDefault();

        

            fetch("{{ route('admin.notifications.markAllAsRead') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => {
                    console.log('Notifications marked as read successfully');
                    // Optionally update UI instead of reloading the whole page
                    // location.reload();
            })
            .catch(error => {
                console.error('Error marking notifications as read:', error);
            });
        });
    </script>
@stop
