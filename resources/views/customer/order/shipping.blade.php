@vite(['resources/scss/address.scss'])
<div id="popupContent" class="container">
    <!-- Shipping Address Form -->
    <div id="shippingFormContainer" class="w-1/2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-3 mb-4 mx-auto">
        <button id="closePopup1" class="float-right text-red-700 text-2xl">&times;</button>
        <h3 class="text-xl font-bold mb-2">Shipping Details</h3>
        <form action="{{ route('customer.order.billing.save', $order->id) }}" method="POST" id="shippingForm">
            @csrf
            <div class="mb-2">
                <label for="shippingCity" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" id="shippingCity" name="city"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('city', $address['city'] ?? '') }}" required>
            </div>
            <div class="mb-2">
                <label for="shippingAddress" class="block text-sm font-medium text-gray-700">Address</label>
                <input id="shippingAddress" name="address" rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('address', $address['address'] ?? '') }}" required>
            </div>
            <div class="mb-2">
                <label for="shippingPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" id="shippingPhone" name="phone"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('phone', $address['phone'] ?? '') }}" required>
            </div>
            <div class="mb-2">
                <input type="checkbox" id="sameAsShipping" class="mr-2" checked>
                <label for="sameAsShipping" class="text-sm font-medium text-gray-700">Same address</label>
            </div>
            <div id="billingFormContainer" class="w-full bg-white">
                <h3 class="text-xl font-bold mb-2">Billing Details</h3>
                {{-- <form action="{{ route('customer.order.billing.save', $order->id) }}" method="POST" id="billingForm">
                    @csrf --}}
                <div class="mb-2">
                    <label for="billingCity" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="billingCity" name="city"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('city', $billingaddress['city'] ?? '') }}" required>
                </div>
                <div class="mb-2">
                    <label for="billingAddress" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="billingAddress" name="address" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('address', $billingaddress['address'] ?? '') }}" required>
                </div>
                <div class="mb-2">
                    <label for="billingPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="billingPhone" name="phone"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('phone', $billingaddress['phone'] ?? '') }}" required>
                </div>
                {{-- </form> --}}
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Confirm
            </button>
        </form>
    </div>

    <!-- Billing Address Form -->
    {{-- <div id="billingFormContainer" class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">

    </div> --}}
</div>

<script>
    console.log('Script loaded');
    const checkbox = document.getElementById('sameAsShipping');
    const billingFormContainer = document.getElementById('billingFormContainer');
    const shippingFormContainer = document.getElementById('shippingFormContainer');

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            console.log('Checkbox is checked');
            document.getElementById('billingCity').value = document.getElementById('shippingCity').value;
            document.getElementById('billingAddress').value = document.getElementById('shippingAddress').value;
            document.getElementById('billingPhone').value = document.getElementById('shippingPhone').value;
            billingFormContainer.classList.add('collapsed');
            shippingFormContainer.classList.add('flex-grow');
        } else {
            document.getElementById('billingCity').value = '';
            document.getElementById('billingAddress').value = '';
            document.getElementById('billingPhone').value = '';
            billingFormContainer.classList.remove('collapsed');
            shippingFormContainer.classList.remove('flex-grow');
        }
    });

    //if checked when script loaded do the same
    if (checkbox.checked) {
        document.getElementById('billingCity').value = document.getElementById('shippingCity').value;
        document.getElementById('billingAddress').value = document.getElementById('shippingAddress').value;
        document.getElementById('billingPhone').value = document.getElementById('shippingPhone').value;
        billingFormContainer.classList.add('collapsed');
        shippingFormContainer.classList.add('flex-grow');
    }

    // Close popup functionality
    document.getElementById('closePopup1').addEventListener('click', function() {
        document.getElementById('orderPopup1').classList.add('hidden');
    });
</script>
