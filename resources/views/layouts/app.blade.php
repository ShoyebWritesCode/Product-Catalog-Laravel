<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Product Catalogue') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP5PT1QvAtDRF/MB1ZPZzt1FCnwlz/2V3zpX6E5b1s="
        crossorigin="anonymous"></script> --}}
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8 bg-orange-600">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
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

        // Request permission to send notifications
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                // Get FCM token
                getToken(messaging, {
                    vapidKey: 'BGJnmNq3LW7qTyD498Avn3l93tGvG3V3fT9gvzWR475SwhdqkZCrGRLmFoJPzd9xC469IQ4W-Sf0GUmm9oOvkUQ'
                }).then(currentToken => {
                    if (currentToken) {
                        console.log('FCM Token:', currentToken);

                        fetch('/store-token', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    token: currentToken
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Token stored successfully:', data);
                            })
                            .catch(error => {
                                console.log('An error occurred while storing the token:', error);
                            });
                    } else {
                        console.log('No registration token available. Request permission to generate one.');
                    }
                }).catch(err => {
                    console.log('An error occurred while retrieving token. ', err);
                });
            } else {
                console.log('Unable to get permission to notify.');
            }
        });


        console.log('Sending notification request...');
        fetch('/send-notification', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                console.log('Notification request sent successfully:', data);
            })
            .catch(error => {
                console.log('An error occurred while sending the notification:', error);
            });

        // Handle incoming messages when the app is in the foreground
        onMessage(messaging, (payload) => {
            console.log('Message received. ', payload);

            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon
            };

            new Notification(notificationTitle, notificationOptions);
        });
    </script>
</body>

</html>
