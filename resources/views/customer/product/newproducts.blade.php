<x-app-layout>
    @vite(['resources/scss/product.scss'])
    {{-- @vite(['resources/js/custom/product.js']) --}}
    <x-slot name="header">
        @include('partials.nav')
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-0">
                        <h1 class="text-2xl font-semibold">New Products</h1>
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


                    <hr class="mb-0">
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
                                @include('partials.products', ['products' => $newProducts])
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
