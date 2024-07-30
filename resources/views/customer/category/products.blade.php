<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    @vite(['resources/scss/product.scss'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('customer.product.home') }}" class="no-underline">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Product Catalogue') }}
                </h2>
            </a>
            <nav class="flex space-x-8">
                @foreach ($allParentCategories as $category)
                    <div class="relative group">
                        {{-- <a href="{{ route('customer.category.products', $category->id) }}"
                            class="text-gray-800 hover:text-gray-600 no-underline font-bold">
                            {{ $category->name }}
                        </a> --}}
                        <ul class="nav-item dropdown mt-2">
                            <a href="{{ route('customer.category.products', $category->id) }}"
                                class="text-white hover:text-gray-600 no-underline font-bold">
                                {{ $category->name }}
                            </a>
                            {{-- <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"> Submenu item 1</a></li>
                                <li><a class="dropdown-item" href="#"> Submenu item 2 </a></li>
                                <li><a class="dropdown-item" href="#"> Submenu item 3 </a></li>
                            </ul> --}}
                        </ul>
                        <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded w-32 z-2">
                            <ul class="grid grid-cols-1 gap-2 p-2 space-y-1 mb-0">
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
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('customer.order.history')">
                                {{ __('Order History') }}
                            </x-dropdown-link>


                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
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
                    <div class="bg-gray-100 shadow-sm p-4 mb-4">
                        <form action="{{ route('customer.category.products', $selectedCategory->id) }}" method="GET">
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
                                                            name="color" value="{{ $color }}"
                                                            class="mr-2">
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

                <div class="w-4/5 mx-auto mt-2 ">
                    @if ($selectedCategory->banners->count() === 0)
                        <hr class="opacity-0 mb-0 mt-0">
                    @else
                        <swiper-container class="h-[200px] mb-2" autoplay="true" autoplay-delay="5000" loop>
                            @foreach ($selectedCategory->banners as $banner)
                                <swiper-slide>
                                    <img src="{{ asset('storage/images/' . $banner->banner) }}"
                                        alt="{{ $selectedCategory->name }}" class="w-full h-full object-cover">
                                </swiper-slide>
                            @endforeach
                        </swiper-container>
                    @endif

                    <!-- Products Section -->
                    <div class="bg-gray-100 overflow-hidden">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-2xl font-semibold">{{ $selectedCategory->name }} Products
                                    ({{ $countProducts }})</h1>
                                <form action="{{ route('customer.products.sort', $selectedCategory->id) }}"
                                    method="GET" class="flex items-center">
                                    <select name="sort" id="sort"
                                        class="border rounded px-2 py-1 text-gray-700 ">
                                        <option value="" disabled {{ request('sort') ? '' : 'selected' }}>Select
                                        </option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                            Name(A-Z)</option>
                                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>
                                            Price(Low-High)</option>
                                    </select>
                                    <button type="submit"
                                        class="ml-2 bg-blue-500 text-white py-1 px-4 rounded">Sort</button>
                                </form>
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
