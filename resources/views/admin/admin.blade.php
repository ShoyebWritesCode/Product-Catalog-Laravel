@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dashboard</h1>
        <div class="dropdown">
            <a href="#" class="btn btn-secondary dropdown-toggle" id="notificationsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell"></i>
                @if ($unreadNotifications->count() > 0)
                    <span class="badge badge-danger">{{ $unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="notificationsDropdown">
                @if ($unreadNotifications->count() > 0)
                    @foreach ($unreadNotifications->take(3) as $notification)
                        <li class="dropdown-item notification-item">
                            <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}"
                                class="inline">
                                @csrf
                                <button type="submit" class="w-full text-left p-2 ">
                                    <i class="fas fa-shopping-cart"></i> Order no.#{{ $notification->data['order_id'] }}
                                    placed<br>
                                    total {{ $notification->data['order_total'] }} BDT
                                    <span
                                        class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                                </button>
                            </form>
                        </li>
                    @endforeach
                    <a href="{{ route('admin.notifications.index') }}" class="dropdown-item view-more-btn badge-primary">
                        View More
                    </a>
                @else
                    <span class="dropdown-item">No unread notifications</span>
                    <a href="{{ route('admin.notifications.index') }}" class="dropdown-item view-more-btn badge-primary">
                        View More
                    </a>
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
            'link' => route('admin.products'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Categories',
            'number' => $totalCategories,
            'icon' => 'fas fa-th-large',
            'color' => 'warning',
            'link' => route('admin.categories'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Colors',
            'number' => $totalReviews,
            'icon' => 'fas fa-palette',
            'color' => 'danger',
            'link' => route('admin.colors'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Sizes',
            'number' => $totalPendingOrders,
            'icon' => 'fas fa-expand',
            'color' => 'primary',
            'link' => route('admin.sizes'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Users',
            'number' => $totalUsers,
            'icon' => 'fas fa-users',
            'color' => 'success',
            'link' => route('admin.users'),
            'link_text' => 'More info',
        ])

        @include('components.index', [
            'title' => 'Reviews',
            'number' => $totalReviews,
            'icon' => 'fas fa-comments',
            'color' => 'danger',
            'link' => route('admin.reviews'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Pending Orders',
            'number' => $totalPendingOrders,
            'icon' => 'fas fa-shopping-cart',
            'color' => 'primary',
            'link' => route('admin.pendingorders'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Delivered Orders',
            'number' => $totalCompletedOrders,
            'icon' => 'fas fa-shopping-cart',
            'color' => 'secondary',
            'link' => route('admin.completedorders'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Mail Templates',
            'number' => $totalTemplates,
            'icon' => 'fas fa-envelope',
            'color' => 'dark',
            'link' => route('admin.templates.index'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Sales Reports',
            'number' => 3,
            'icon' => 'fas fa-chart-line',
            'color' => 'info',
            'link' => route('admin.charts.index'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Payment History',
            'number' => $totalPayments,
            'icon' => 'fas fa-money-bill-wave',
            'color' => 'success',
            'link' => route('admin.payment-history'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Refund Requests',
            'number' => $totalRefundRequests,
            'icon' => 'fas fa-ban',
            'color' => 'warning',
            'link' => route('admin.refundrequests'),
            'link_text' => 'More info',
        ])

    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        //   $(document).ready(function(){
        //     $('.notification-item').on('click', function(event) {
        //         event.preventDefault(); // Prevent default link behavior

        //         var notificationId = $(this).data('id');
        //         var notificationItem = $(this);

        //         $.ajax({
        //             url: "{{ route('admin.notifications.markAsRead', ':id') }}".replace(':id', notificationId),
        //             method: 'POST',
        //             data: {
        //                 _token: "{{ csrf_token() }}"
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     notificationItem.remove();
        //                     // Optionally show a success message or handle further actions
        //                 } else {
        //                     console.error('Error marking notification as read:', response.message);
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('Error marking notification as read:', error);
        //             }
        //         });
        //     });
        // });
    </script>
@stop
