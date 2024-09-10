@extends('adminlte::page')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
            'title' => 'Attributes',
            'number' => $totalAttributes,
            'icon' => 'fas fa-star',
            'color' => 'teal',
            'link' => route('admin.attributes'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Colors',
            'number' => $totalColors,
            'icon' => 'fas fa-palette',
            'color' => 'danger',
            'link' => route('admin.colors'),
            'link_text' => 'More info',
        ])
        @include('components.index', [
            'title' => 'Sizes',
            'number' => $totalSizes,
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

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
        import {
            getAnalytics
        } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-analytics.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-messaging.js";


        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAvflfLnljo5aI5wln6wapt28uQOIk-XT4",
            authDomain: "product-catalogue-c802f.firebaseapp.com",
            projectId: "product-catalogue-c802f",
            storageBucket: "product-catalogue-c802f.appspot.com",
            messagingSenderId: "1097562957092",
            appId: "1:1097562957092:web:a34222a70e264758c23fb1",
            measurementId: "G-LRJX66KKSD"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);

        // Initialize Firebase Messaging
        const messaging = getMessaging(app);

        let pollingCount = 1;
        setInterval(function() {
            console.log(`Polling attempt: ${pollingCount}`); // Log the polling attempt

            fetch('admin/check-new-order', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.new_order) {
                        Notification.requestPermission().then(permission => {
                            if (permission === 'granted') {
                                // Get FCM token
                                getToken(messaging, {
                                    vapidKey: 'BGJnmNq3LW7qTyD498Avn3l93tGvG3V3fT9gvzWR475SwhdqkZCrGRLmFoJPzd9xC469IQ4W-Sf0GUmm9oOvkUQ'
                                }).then(currentToken => {
                                    if (currentToken) {
                                        console.log('FCM Token:', currentToken);

                                        fetch('admin/store-token', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector(
                                                            'meta[name="csrf-token"]')
                                                        .getAttribute('content')
                                                },
                                                body: JSON.stringify({
                                                    token: currentToken
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                console.log('Token stored successfully:',
                                                    data);
                                                console.log(
                                                    'Sending notification request...');
                                                fetch('admin/send-notification', {
                                                        method: 'GET',
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        console.log(
                                                            'Notification request sent successfully:',
                                                            data);
                                                    })
                                                    .catch(error => {
                                                        console.log(
                                                            'An error occurred while sending the notification:',
                                                            error);
                                                    });

                                                // Handle incoming messages when the app is in the foreground
                                                onMessage(messaging, (payload) => {
                                                    console.log(
                                                        'Message received. ',
                                                        payload);

                                                    const notificationTitle =
                                                        payload.notification.title;
                                                    const notificationOptions = {
                                                        body: payload
                                                            .notification.body,
                                                        url: payload
                                                            .notification.url
                                                    };

                                                    new Notification(
                                                        notificationTitle,
                                                        notificationOptions);
                                                });
                                            })
                                            .catch(error => {
                                                console.log(
                                                    'An error occurred while storing the token:',
                                                    error);
                                            });
                                    } else {
                                        console.log(
                                            'No registration token available. Request permission to generate one.'
                                        );
                                    }
                                }).catch(err => {
                                    console.log('An error occurred while retrieving token. ',
                                        err);
                                });
                            } else {
                                console.log('Unable to get permission to notify.');
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error checking for new order:', error);
                });

            pollingCount++; // Increment the polling counter
        }, 10000); // Polling interval set to 10 seconds
    </script>
@stop
