<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <h1 class="text-2xl font-bold mb-2">{{ 'My Order' }}</h1>
            </h2>
            <div class="flex-1 text-center">
                <a href="{{ route('customer.product.home') }}" class="text-blue-500 hover:text-blue-700 mx-4">
                    {{ __('Product') }}
                </a>
            </div>
            <a href="{{ route('customer.order.home') }}" class="text-gray-800 hover:text-gray-600 relative">
                <i class="fas fa-shopping-cart text-xl"></i>
                <span
                    class="bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center absolute top-0 right-0 -mt-1 -mr-1 text-xs">
                    {{ $numberOfItems }}
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        @session('success')
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endsession
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($order)
                    <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4">
                        <h3 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h3>
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border text-center">Image</th>
                                    <th class="px-4 py-2 border text-center">Name</th>
                                    <th class="px-4 py-2 border text-center">Price</th>
                                    <th class="px-4 py-2 border text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <img src="{{ asset('storage/images/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-16 h-16 object-cover rounded-md">
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2 text-center">{{ $item->product->name }}</td>
                                        <td class="border px-4 py-2 text-center text-gray-600">
                                            {{ $item->product->price }} BDT</td>
                                        <td class="border px-4 py-2 text-center">
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
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Total: {{ $order->total }} BDT</span>
                            <button id="checkoutButton" type="button"
                                class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Next
                            </button>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-600">You have no open orders.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Billing Address Popup --}}
    <div id="billingPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h3 class="text-xl font-bold mb-4">Billing Address Details</h3>
            <form action="{{ route('customer.order.billing.save', $order->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="billingCity" name="city"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('city', $billingaddress['city'] ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="billingAddress" name="address" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('address', $billingaddress['address'] ?? '') }}" required></input>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="billingPhone" name="phone"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('phone', $billingaddress['phone'] ?? '') }}" required>
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Confirm</button>
            </form>
            <br>
            <div class="mb-4">
                <input type="checkbox" id="sameAsShipping" class="mr-2">
                <label for="sameAsShipping" class="text-sm font-medium text-gray-700">Same as shipping
                    address</label>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('sameAsShipping').addEventListener('change', function() {
            if (this.checked) {
                $.ajax({
                    url: "{{ route('customer.order.sameaddr', $order->id) }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        document.getElementById('billingCity').value = data.city;
                        document.getElementById('billingAddress').value = data.address;
                        document.getElementById('billingPhone').value = data.phone;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                document.getElementById('billingCity').value = "{{ old('city', $billingaddress['city'] ?? '') }}";
                document.getElementById('billingAddress').value =
                    "{{ old('address', $billingaddress['address'] ?? '') }}";
                document.getElementById('billingPhone').value =
                    "{{ old('phone', $billingaddress['phone'] ?? '') }}";
            }
        });
    </script>


</x-app-layout>
