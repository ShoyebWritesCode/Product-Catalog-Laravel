<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>

    @vite(['resources/scss/product.scss'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Products') }}
            </h2>
            <nav class="flex space-x-8">
                @foreach ($allParentCategories as $category)
                    <div class="relative group">
                        <a href="{{ route('customer.category.products', $category->id) }}"
                            class="text-gray-800 hover:text-gray-600 no-underline font-bold">
                            {{ $category->name }}
                        </a>
                        <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded w-56">
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
            <div class="flex">
                <div class="w-1/5 pr-4 mt-1">
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                        <form action="#" method="GET">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-xl font-semibold mb-0">Filters</h1>
                                <button type="reset" id="resetFilters"
                                    class="bg-blue-500 text-white py-1 px-2 rounded mt-0 ml-2">
                                    <i class="fas fa-undo"></i>
                                </button>


                            </div>

                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Subcategories</h3>
                                <ul>
                                    @foreach ($allChildCategoriesOfParent[$selectedCategory->id] as $childCategory)
                                        <li class="flex items-center">
                                            <input type="radio" id="category_{{ $childCategory->id }}"
                                                name="child_category" value="{{ $childCategory->id }}" class="mr-2"
                                                {{ request('child_category') == $childCategory->id ? 'checked' : '' }}>
                                            <label for="category_{{ $childCategory->id }}"
                                                class="block px-1 py-1 text-gray-800 hover:bg-gray-100 no-underline">{{ $childCategory->name }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Price Range</h3>
                                <div class="flex items-center mb-2">
                                    <input type="text" id="min_price" name="min_price" placeholder="Min"
                                        class="w-1/3 px-2 py-1 border rounded mr-2 text-sm opacity-0"
                                        value="{{ request('min_price') }}" readonly>
                                    <input type="text" id="max_price" name="max_price" placeholder="Max"
                                        class="w-1/3 px-2 py-1 border rounded text-sm opacity-0"
                                        value="{{ request('max_price') }}" readonly>
                                </div>
                                <div id="price-slider" class="w-3/4"></div>
                            </div>

                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Color</h3>
                                <div class="flex">
                                    <div class="flex flex-col">
                                        <ul>
                                            @foreach (['red', 'blue', 'green', 'gray'] as $color)
                                                <li>
                                                    <div class="flex items-center mb-2">
                                                        <input type="radio" id="color_{{ $color }}"
                                                            name="color" value="{{ $color }}" class="mr-2">
                                                        <div
                                                            class="w-6 h-6 bg-{{ $color }}-500 rounded-full mr-2 cursor-pointer">
                                                        </div>
                                                        <label for="color_{{ $color }}"
                                                            class="text-gray-800">{{ ucfirst($color) }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded mt-2">Apply
                                Filters</button>
                        </form>
                    </div>
                </div>


                <div class="ml-4 mt-1">
                </div>

                <div class="w-4/5" id="">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-2xl font-semibold">{{ $selectedCategory->name }} Products
                                    ({{ $countProducts }})
                                </h1>
                            </div>
                            <hr class="mb-4">
                            @if (session('success'))
                                <div class="alert alert-success mb-4" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (count($Products) === 0)
                                <p class="text-center text-gray-500">No products available.</p>
                            @else
                                <div class="flex flex-wrap gap-6" id="productList">
                                    <div id="product-container" class="flex flex-wrap gap-6">
                                        @include('partials.categoryproducts', [
                                            'Products' => $Products,
                                        ])
                                    </div>
                                    <div id="loading-indicator" class="text-center py-4 hidden">
                                        <p>Loading...</p>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-4">
                                {{ $Products->links() }}
                            </div>
                        </div>
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



    document.addEventListener('DOMContentLoaded', function() {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');

        const minPrice = minPriceInput.value || 0;
        const maxPrice = maxPriceInput.value || 10000;

        const slider = document.getElementById('price-slider');

        noUiSlider.create(slider, {
            start: [minPrice, maxPrice],
            connect: true,
            range: {
                'min': 0,
                'max': 10000
            },
            step: 50,
            format: {
                to: function(value) {
                    return Math.round(value);
                },
                from: function(value) {
                    return Math.round(Number(value));
                }
            },
            tooltips: [true, true],
        });

        slider.noUiSlider.on('update', function(values, handle) {
            if (handle === 0) {
                minPriceInput.value = Math.round(values[0]);
            } else {
                maxPriceInput.value = Math.round(values[1]);
            }
        });
        // const resetButton = document.getElementById('resetFilters');
        // resetButton.addEventListener('click', function() {
        //     console.log('Resetting filters');
        //     document.getElementById('filterForm').reset(); // Reset the form
        //     // You may also need to reset any custom input handling here, like sliders or other UI elements
        // });
    });
</script>
