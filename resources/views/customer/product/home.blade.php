<x-app-layout>
    @vite(['resources/scss/product.scss'])
    @vite(['resources/js/custom/product.js'])
    <style>

    </style>
    <x-slot name="header">
        @include('partials.nav')
    </x-slot>

    <div class="py-0 mt-2 bg-gray-200">
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden">
                <div class="p-2 text-gray-900">
                    <div class="flex items-center justify-between mb-0">
                        <h1 class="text-2xl font-semibold mb-0">Featured Products</h1>
                    </div>
                    @include('partials.featured')
                    <div class="flex justify-center mt-4">
                        <a href="{{ route('customer.product.featured') }}">
                            <button
                                class="text-white bg-orange-600 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md px-4 py-0 transition duration-150 ease-in-out">
                                View All
                            </button>
                        </a>
                    </div>
                    <hr class="mb-0">
                </div>
            </div>
        </div>

    </div>



    <div class="py-0 bg-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden">
                <div class="p-2 text-gray-900">
                    <div class="flex items-center justify-between mb-0">
                        <h1 class="text-2xl font-semibold mb-0">New Products</h1>
                    </div>
                    @include('partials.featured', ['featuredProducts' => $newProducts])
                    <div class="flex justify-center mt-4">
                        <a href="{{ route('customer.product.new') }}">
                            <button
                                class="text-white bg-orange-600 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md px-4 py-0 transition duration-150 ease-in-out">
                                View All
                            </button>
                        </a>
                    </div>
                    <hr class="mb-0">
                </div>
            </div>
        </div>
    </div>

    <div class="py-0 bg-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden">
                <div class="p-2 text-gray-900">
                    <div class="flex items-center justify-between mb-0">
                        <h1 class="text-2xl font-semibold mb-0">All Products</h1>
                    </div>
                    @include('partials.featured', ['featuredProducts' => $initialProducts])
                    <div class="flex justify-center mt-4">
                        <a href="{{ route('customer.product.all') }}">
                            <button
                                class="text-white bg-orange-600 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md px-4 py-0 transition duration-150 ease-in-out">
                                View All
                            </button>
                        </a>
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
</script>
