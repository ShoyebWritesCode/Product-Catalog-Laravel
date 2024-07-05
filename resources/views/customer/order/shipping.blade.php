<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shipping & Billing</title>
</head>

<body>
    <div id="popupContent" class="flex justify-between space-x-4">
        <!-- Shipping Address Form -->
        <div class="w-1/2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">Shipping Details</h3>
            <form action="{{ route('customer.order.billing.save', $order->id) }}" method="POST" id="shippingForm">
                @csrf
                <div class="mb-4">
                    <label for="shippingCity" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="shippingCity" name="city"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('city', $address['city'] ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label for="shippingAddress" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="shippingAddress" name="address" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('address', $address['address'] ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label for="shippingPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="shippingPhone" name="phone"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('phone', $address['phone'] ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <input type="checkbox" id="sameAsShipping" class="mr-2">
                    <label for="sameAsShipping" class="text-sm font-medium text-gray-700">Same address</label>
                </div>
            </form>
        </div>

        <!-- Billing Address Form -->
        <div class="w-1/2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">Billing Details</h3>
            <form action="{{ route('customer.order.billing.save', $order->id) }}" method="POST" id="billingForm">
                @csrf
                <div class="mb-4">
                    <label for="billingCity" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="billingCity" name="city"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('city', $billingaddress['city'] ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label for="billingAddress" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="billingAddress" name="address" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('address', $billingaddress['address'] ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label for="billingPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="billingPhone" name="phone"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('phone', $billingaddress['phone'] ?? '') }}" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Confirm
                </button>
            </form>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    console.log('Script loaded');
    const checkbox = document.getElementById('sameAsShipping');


    checkbox.addEventListener('change', function() {
        if (this.checked) {
            console.log('Checkbox is checked');

            document.getElementById('billingCity').value = document.getElementById('shippingCity').value;
            document.getElementById('billingAddress').value = document.getElementById('shippingAddress').value;
            document.getElementById('billingPhone').value = document.getElementById('shippingPhone').value;
        } else {
            document.getElementById('billingCity').value = '';
            document.getElementById('billingAddress').value = '';
            document.getElementById('billingPhone').value = '';
        }
    });
</script>

</html>
