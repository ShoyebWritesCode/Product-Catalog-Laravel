@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dashboard</h1>
        <div class="dropdown">
            <a href="#" class="btn btn-secondary dropdown-toggle" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell"></i>
                @if ($unreadNotifications->count() > 0)
                    <span class="badge badge-danger">{{ $unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                @if ($unreadNotifications->count() > 0)
                    @foreach ($unreadNotifications as $notification)
                        <a class="dropdown-item notification-item" href="{{ route('admin.order.show', $notification->data['order_id']) }}" data-id="{{ $notification->id }}">
                            <i class="fas fa-shopping-cart"></i> New order placed with total ${{ $notification->data['order_total'] }}
                            <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                    @endforeach
                @else
                    <span class="dropdown-item">No unread notifications</span>
                @endif
            </div>
        </div>
    </div>
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
         @include('components.index', [
            'title' => 'Pending Orders',
            'number' => $totalPendingOrders,
            'icon' => 'fas fa-shopping-cart',
            'color' => 'primary',
            'link' => route("admin.pendingorders"),
            'link_text' => 'More info'
        ])
         @include('components.index', [
            'title' => 'Delivered Orders',
            'number' => $totalCompletedOrders,
            'icon' => 'fas fa-shopping-cart',
            'color' => 'secondary',
            'link' => route("admin.completedorders"),
            'link_text' => 'More info'
        ])
        @include('components.index', [
            'title' => 'Mail Templates',
            'number' => $totalTemplates,
            'icon' => 'fas fa-envelope',
            'color' => 'dark',
            'link' => route("admin.templates.index"),
            'link_text' => 'More info'
        ])
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $('.notification-item').on('click', function(event) {
                
                var notificationId = $(this).data('id');
                var notificationItem = $(this);

                $.ajax({
                    url: "{{ route('admin.notifications.markAsRead') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: notificationId
                    },
                    success: function() {
                        notificationItem.remove();
                    }
                });
            });
        });
    </script>
@stop


