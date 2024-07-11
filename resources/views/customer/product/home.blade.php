<x-app-layout>
    @vite(['resources/scss/product.scss'])
    @vite(['resources/js/custom/product.js'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Products') }}
            </h2>
            <nav class="flex space-x-8">
                @foreach ($allParentCategories as $category)
                    <div class="relative group">
                        <a href="#" class="text-gray-800 hover:text-gray-600 no-underline font-bold">
                            {{ $category->name }}
                        </a>
                        <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded  w-56">
                            <ul class="grid grid-cols-2 gap-2 py-2">
                                @foreach ($allChildCategoriesOfParent[$category->id] as $childCategory)
                                    <li>
                                        <a href="#"
                                            class="block px-1 py-1 text-gray-800 hover:bg-gray-100 font-semibold no-underline">
                                            {{ $childCategory->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </nav>





            <div class="flex items-center space-x-4">

                <a href="#" id="cartLink" class="text-gray-800 hover:text-gray-600 relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span
                        class="bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center absolute top-0 right-0 -mt-1 -mr-1 text-xs">
                        {{ $numberOfItems }}
                    </span>
                </a>
                <p></p>
                <a href="{{ route('customer.order.history') }}" id="historyLink"
                    class="text-gray-800 hover:text-gray-600 relative">
                    <i class="fas fa-history text-xl"></i>
                </a>

                <div class="relative">
                    <button id="notificationDropdown" class="text-gray-800 hover:text-gray-600 relative">
                        <i class="fas fa-bell text-xl"></i>
                        @if ($unreadNotifications->count() > 0)
                            <span
                                class="bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center absolute top-0 right-0 -mt-1 -mr-1 text-xs">
                                {{ $unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    <div id="notificationDropdownContent"
                        class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-10">
                        @if ($unreadNotifications->count() > 0)
                            <ul class="notification-list">
                                @foreach ($unreadNotifications as $notification)
                                    <li class="dropdown-item notification-item">
                                        <form method="POST"
                                            action="{{ route('customer.notifications.markAsRead', $notification->id) }}"
                                            class="inline">
                                            @csrf
                                            <button type="submit" class="w-full text-left p-2">
                                                <i class="fas fa-shopping-cart"></i> Order
                                                no.#{{ $notification->data['order_id'] }} Delivered.
                                                <span
                                                    class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="dropdown-item">No unread notifications</span>
                        @endif
                    </div>





                </div>

            </div>
        </div>

        <!-- Popup Container -->
        <div id="orderPopup"
            class="max-h-96 hidden fixed inset-auto top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 bg-gray-500 bg-opacity-50 overflow-auto z-50 p-4 rounded shadow-md">
            <span class="close-btn absolute top-right p-2 text-xl cursor-pointer hover:text-red-500">&times;</span>
        </div>

    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-semibold">All Products</h1>
                        <div class="">
                            <form action="#" method="GET">
                                <div class="flex items-center">
                                    <input type="search" name="search" id="searchInput"
                                        class="form-input rounded-md shadow-sm block w-full sm:text-sm sm:leading-5"
                                        placeholder="Search products...">
                                    <button type="submit"
                                        class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <hr class="mb-4">
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($initialProducts->isEmpty())
                        <p class="text-center text-gray-500">No products available.</p>
                    @else
                        <div class="flex flex-wrap gap-6" id="productList">
                            <div id="product-container" class="flex flex-wrap gap-6">
                                @include('partials.products', ['products' => $initialProducts])
                            </div>
                            <div id="loading-indicator" class="text-center py-4 hidden">
                                <p>Loading...</p>
                            </div>
                        </div>
                    @endif
                    {{-- <div class="mt-4">
                        {{ $products->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('notificationDropdown').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('notificationDropdownContent').classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('notificationDropdownContent');
        if (!event.target.closest('#notificationDropdown') && !event.target.closest(
                '#notificationDropdownContent')) {
            dropdown.classList.add('hidden');
        }
    });









    document.getElementById('cartLink').addEventListener('click', function(event) {
        event.preventDefault();

        fetch('{{ route('customer.order.popup') }}')
            .then(response => response.text())
            .then(htmlContent => {
                document.getElementById('orderPopup').innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('Error fetching content:', error);
            });

        document.getElementById('orderPopup').classList.remove('hidden');
    });

    document.addEventListener('click', function(event) {
        if (event.target.id === 'orderPopup') {
            document.getElementById('orderPopup').classList.add('hidden');
        }
    });

    document.addEventListener('click', function(event) {
        if (event.target.id === 'orderPopup') {
            document.getElementById('orderPopup').classList.add('hidden');
        }
    });
</script>
