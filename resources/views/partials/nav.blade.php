<div class="flex justify-between items-center">
    <a href="{{ route('customer.product.home') }}" class="no-underline">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Catalogue') }}
        </h1>
    </a>
    <nav class="flex space-x-8 mt-2">
        @foreach ($allParentCategories as $category)
            <div class="relative group">
                {{-- <a href="{{ route('customer.category.products', $category->id) }}"
                    class="text-gray-800 hover:text-gray-600 no-underline font-bold">
                    {{ $category->name }}
                </a> --}}
                <ul class="nav-item dropdown">
                    <a href="{{ route('customer.category.products', $category->id) }}"
                        class="text-gray-800 hover:text-gray-600 no-underline font-bold">
                        {{ $category->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"> Submenu item 1</a></li>
                        <li><a class="dropdown-item" href="#"> Submenu item 2 </a></li>
                        <li><a class="dropdown-item" href="#"> Submenu item 3 </a></li>
                    </ul>
                </ul>
                <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded  w-32">
                    <ul class="grid grid-cols-1 gap-2 py-2">
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
        {{-- <a href="{{ route('customer.order.history') }}" id="historyLink"
            class="text-gray-800 hover:text-gray-600 relative">
            <i class="fas fa-history text-xl"></i>
        </a> --}}

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
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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