<x-app-layout>
    @vite(['resources/scss/product.scss'])
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('customer.product.home') }}" class="no-underline">
                    {{-- <h1 class="font-semibold text-xl text-white leading-tight">
                        {{ __('Product Catalogue') }}
                    </h1> --}}
                    <img src="{{ asset('storage/images/logo.png') }}" alt="logo" class="w-64 h-12">
                </a>
                <nav class="flex space-x-12 mt-2 ml-16">
                    @foreach ($allParentCategories as $category)
                        <div class="relative group">
                            <ul class="nav-item dropdown pl-0">
                                <a href="{{ route('customer.category.products', $category->id) }}"
                                    class="text-white hover:text-gray-600 no-underline font-bold">
                                    {{ $category->name }}
                                </a>
                            </ul>
                            <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded w-32 z-2">
                                <ul class="grid grid-cols-1 gap-2 p-2 space-y-1 mb-0">
                                    @foreach ($allChildCategoriesOfParent[$category->id] as $childCategory)
                                        <li>
                                            <a href="{{ route('customer.subcategory.products', $childCategory->id) }}"
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
            </div>

            <div class="flex items-center space-x-4">
                <a href="#" id="cartLink" class="text-gray-800 hover:text-gray-600 relative">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    <span
                        class="bg-white text-gray-800 rounded-full min-w-4 h-4 flex items-center justify-center absolute top-0 right-0 -mt-1 -mr-1 text-xs px-1 py-1">
                        {{ $numberOfItems }}
                    </span>
                </a>

                <div class="relative">
                    <button id="notificationDropdown" class="text-gray-800 hover:text-gray-600 relative">
                        <i class="fas fa-bell text-2xl"></i>
                        @if ($unreadNotifications->count() > 0)
                            <span
                                class="bg-white text-gray-800 rounded-full min-w-4 h-4 flex items-center justify-center absolute top-0 right-0 -mt-1 -mr-1 text-xs px-1 py-1">
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

    </x-slot>

    <div class="py-4">
        @session('success')
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endsession
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-lg p-2">
                @if ($order)
                    <div class="bg-gray-100  p-4 mb-2">
                        <h3 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h3>
                        <table class="min-w-full bg-gray-100 shadow-sm " id="orderItemsTable">
                            <thead class="bg-[#f8f9fa]">
                                <tr>
                                    <th class="px-2 py-1 border-b text-center">Image</th>
                                    <th class="px-2 py-1 border-b text-center">Name</th>
                                    <th class="px-2 py-1 border-b text-center">Size</th>
                                    <th class="px-2 py-1 border-b text-center">Color</th>
                                    <th class="px-2 py-1 border-b text-center">Price</th>
                                    <th class="px-2 py-1 border-b text-center">Quantity</th>
                                    <th class="px-2 py-1 border-b text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr data-item-id="{{ $item->id }}" data-price="{{ $item->product_price }}"
                                        data-prev-price="{{ $item->prev_price ?? $item->product_price }}"
                                        class="hover:bg-orange-300 bg-white">
                                        <td class="border-b px-4 py-2 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <img src="{{ asset('storage/images/' . $item->image) }}"
                                                    alt="{{ $item->product_name }}" class="w-16 h-8 object-cover ">
                                            </div>
                                        </td>
                                        <td class="border-b px-2 py-1 text-center">{{ $item->product_name }}</td>
                                        <td class="border-b px-2 py-1 text-center">{{ $item->size->name }}</td>
                                        <td class="border-b px-2 py-1 text-center">{{ $item->color->name }}</td>
                                        <td class="border-b px-2 py-1 text-center text-green-600">
                                            @if ($item->prev_price && $item->prev_price > $item->product_price)
                                                <del class="text-red-400 mr-2">{{ number_format($item->prev_price, 2) }}
                                                    BDT</del>
                                            @endif
                                            <br>
                                            {{ number_format($item->product_price, 2) }} BDT
                                        </td>
                                        <td class="border-b px-2 py-1 text-center">
                                            <input type="number" class="quantity-input" name="quantity[]"
                                                value="1" min="1" max="5">
                                        </td>
                                        <td class="border-b px-2 py-1 text-center">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="mt-2 flex justify-between items-center">
                            <div class="flex items-center opacity-0">
                                <span class="text-lg font-bold mr-4">Product Total: 0 BDT</span>
                                <span class="text-sm font-bold text-green-500"></span>
                            </div>
                            <div class="flex flex-col items-end mt-2">
                                <span id="prevTotal" class="text-md  mb-1">Product Total: 0 BDT</span>
                                <span id="discountAmount" class="text-md">Discount: 0 BDT</span>
                                <span id="discount" class="text-xs  text-green-500">Discount: 0 BDT</span>
                                <span id="productTotal" class="text-md mb-1">OrderTotal: 0 BDT</span>

                            </div>

                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="text-lg font-bold mr-4 opacity-0">Product Total: 0 BDT</span>
                                <span class="text-sm font-bold text-green-500"></span>
                            </div>
                            <a href="#" id="checkoutButton" class="no-underline text-gray-100">
                                <button type="button"
                                    class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Next
                                </button>
                            </a>
                        </div>


                    </div>
                @else
                    <p class="text-center text-gray-600">You have no open orders.</p>
                @endif
            </div>
        </div>
    </div>


    <div id="orderPopup"
        class="h-full w-full hidden fixed inset-x-0 top-0  bg-gray-500 bg-opacity-30 overflow-auto z-3 p-4 shadow-md">
        <button id="closePopup" class="float-right text-gray-700">&times;</button>
        <div id="popupContent" class="flex justify-between space-x-4 mt-16 ml-8"></div>
    </div>
    <div class="fixed inset-x-0 top-0 bg-gray-500 bg-opacity-30  shadow-lg p-2 w-1/10 overflow-auto h-full hidden"
        id="orderPopup1">
        {{-- <button id="closePopup1" class="float-right text-gray-700">&times;</button> --}}
        <div id="popupContent1" class="flex justify-between space-x-4 mt-16 ml-8">
        </div>
    </div>



</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize an array to store itemId-quantity pairs
        var itemQuantities = [];

        // Function to update the itemQuantities array
        function updateItemQuantities() {
            itemQuantities = [];
            $('#orderItemsTable tbody tr').each(function() {
                var itemId = $(this).data('item-id');
                var quantity = $(this).find('.quantity-input').val();
                itemQuantities.push({
                    itemId: itemId,
                    quantity: quantity
                });
            });
        }

        // Event listener for quantity input change
        $('#orderItemsTable').on('change', '.quantity-input', function() {
            updateItemQuantities();
        });

        $('#checkoutButton').on('click', function(event) {
            event.preventDefault();
            updateItemQuantities();

            $.ajax({
                url: '{{ route('customer.order.saveQuantities') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    order_items: itemQuantities
                }),
                success: function(response) {
                    console.log('Response from server:', response);
                    // Now fetch the shipping content
                    fetch('{{ route('customer.order.shipping') }}')
                        .then(response => response.text())
                        .then(htmlContent => {
                            $('#popupContent1').html(htmlContent);
                            $('#orderPopup1').removeClass('hidden');

                            // Execute any scripts in the loaded content
                            const scripts = $('#popupContent1').find('script');
                            scripts.each(function() {
                                eval($(this).html());
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching content:', error);
                        });
                },
                error: function(xhr, status, error) {
                    console.error('Error in AJAX request:', error);
                }
            });
        });

        $('#cartLink').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('customer.order.popup') }}',
                type: 'GET',
                success: function(response) {
                    $('#orderPopup').html(response);
                    $('#orderPopup').removeClass(
                        'hidden');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        });




        // Hide popup when clicking outside of it
        document.addEventListener('click', function(event) {
            const orderPopup = document.getElementById('orderPopup');
            if (event.target === orderPopup) {
                orderPopup.classList.add('hidden');
                console.log('Clicked outside');
            }
        });

        document.addEventListener('click', function(event) {
            const orderPopup1 = document.getElementById('orderPopup1');
            if (event.target === orderPopup1) {
                orderPopup1.classList.add('hidden');
                console.log('Clicked outside');
            }
        });


    });

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

    // Update totals and discounts
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const productTotalElement = document.getElementById('productTotal');
        const discountElement = document.getElementById('discount');
        const prevTotalElement = document.getElementById('prevTotal');
        const discountTotalElement = document.getElementById('discountAmount');

        const updateTotal = () => {
            let total = 0;
            quantityInputs.forEach(input => {
                const row = input.closest('tr');
                const price = parseFloat(row.getAttribute('data-price'));
                const quantity = parseInt(input.value);
                total += price * quantity;
            });
            productTotalElement.textContent = `Order Total: ${total.toFixed(2)} BDT`;
            updateDiscount(total);
            updatePrevTotal(total);
        };

        const updateDiscount = (total) => {
            let discount = 0;
            let prevTotal = 0;
            quantityInputs.forEach(input => {
                const row = input.closest('tr');
                const price = parseFloat(row.getAttribute('data-price'));
                const prevPrice = parseFloat(row.getAttribute('data-prev-price')) ||
                    price;
                const quantity = parseInt(input.value);
                prevTotal += prevPrice * quantity;
            });
            discount = ((prevTotal - total) / prevTotal) * 100;
            if (discount > 0) {
                discountElement.textContent = `You saved ${discount.toFixed(2)} %`;
                discountTotalElement.textContent =
                    `Discount: ${(prevTotal - total).toFixed(2)} BDT`;
            } else {
                discountElement.textContent = '';
                discountTotalElement.textContent = '';
            }
        };

        const updatePrevTotal = (total) => {
            let prevTotal = 0;
            quantityInputs.forEach(input => {
                const row = input.closest('tr');
                const prevPrice = parseFloat(row.getAttribute('data-prev-price'));
                const quantity = parseInt(input.value);
                prevTotal += prevPrice * quantity;
            });
            if (prevTotal - total > 0) {
                prevTotalElement.textContent = `Product Total: ${prevTotal.toFixed(2)} BDT`;
            } else {
                prevTotalElement.textContent = '';
            }
        };

        // Initialize total and discount on page load
        updateTotal();

        // Add event listeners to each quantity input
        quantityInputs.forEach(input => {
            input.addEventListener('change', updateTotal);
        });
    });
</script>
