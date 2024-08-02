<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    @vite(['resources/scss/product.scss'])
    <x-slot name="header">
        @include('partials.nav')
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex">
                <div class="w-1/5 pr-4 mt-1">
                    <div class="shadow-sm p-4 mb-4 bg-white">
                        <form
                            action="{{ isset($allChildCategoriesOfParent[$selectedCategory->id]) ? route('customer.category.products', $selectedCategory->id) : route('customer.subcategory.products', $selectedCategory->id) }}"
                            method="GET">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-3xl font-semibold mb-0">Filters</h1>
                                <button type="reset" id="resetFilters"
                                    class="bg-blue-500 text-white py-1 px-2 rounded mt-0 ml-2">
                                    <i class="fas fa-undo"></i>
                                </button>


                            </div>
                            @if (count($allParentCategories) > 0)
                                <div class="mb-4">
                                    <ul class="p-0">

                                        @if (isset($allChildCategoriesOfParent[$selectedCategory->id]))
                                            <h3 class="text-lg font-semibold mb-2 text-gray-400">Subcategories</h3>
                                            @foreach ($allChildCategoriesOfParent[$selectedCategory->id] as $childCategory)
                                                <li class="flex items-center">
                                                    <input type="radio" id="category_{{ $childCategory->id }}"
                                                        name="child_category" value="{{ $childCategory->id }}"
                                                        class="mr-2"
                                                        {{ request('child_category') == $childCategory->id ? 'checked' : '' }}>
                                                    <label for="category_{{ $childCategory->id }}"
                                                        class="block px-1 py-1 text-gray-800 hover:bg-gray-100 no-underline lext-sm">{{ $childCategory->name }}</label>
                                                </li>
                                            @endforeach
                                        @else
                                            <hr class="opacity-0 mb-0 mt-0">
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <hr class="opacity-0 mb-0 mt-0">
                            @endif


                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-400">Price Range</h3>
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
                                <h3 class="text-lg font-semibold mb-2 text-gray-400">Color</h3>
                                <div class="flex">
                                    <div class="flex flex-col">
                                        <ul class="p-0">
                                            @foreach (['red', 'blue', 'green', 'gray'] as $color)
                                                <li>
                                                    <div class="flex items-center mb-2">
                                                        <input type="radio" id="color_{{ $color }}"
                                                            name="color" value="{{ $color }}" class="mr-2">
                                                        <div
                                                            class="w-6 h-6 bg-{{ $color }}-500 rounded-full mr-2 cursor-pointer">
                                                        </div>
                                                        <label for="color_{{ $color }}"
                                                            class="text-gray-800 text-sm">{{ ucfirst($color) }}</label>
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
                    <div class="bg-white shadow-md overflow-hidden">
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
                                {{ $Products->links('pagination::bootstrap-5') }}
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
