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
                    {{ $numberOfItems }} </span> </a>
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
                        <table class="min-w-full bg-white border" id="orderItemsTable">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border text-center">Image</th>
                                    <th class="px-4 py-2 border text-center">Name</th>
                                    <th class="px-4 py-2 border text-center">Price</th>
                                    <th class="px-4 py-2 border text-center">Quantity</th>
                                    <th class="px-4 py-2 border text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr data-item-id="{{ $item->id }}">
                                        <td class="border px-4 py-2 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <img src="{{ asset('storage/images/' . $item->image) }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="w-16 h-16 object-cover rounded-md">
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2 text-center">{{ $item->product_name }}</td>
                                        <td class="border px-4 py-2 text-center text-gray-600">
                                            {{ $item->product_price }} BDT</td>
                                        <td class="border px-2 py-1 text-center">
                                            <input type="number" class="quantity-input" name="quantity[]"
                                                value="1" min="1" max="{{ $item->product->inventory }}">
                                        </td>


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
                            {{-- <span class="text-lg font-bold">Total: {{ $order->total }} BDT</span> --}}
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

    <div id="orderPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/10">
            <button id="closePopup" class="float-right text-gray-700">&times;</button>
            <div id="popupContent" class="flex justify-between space-x-4"></div>
        </div>
    </div>



</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // console.log('Hello from the order page');
    // document.getElementById('checkoutButton').addEventListener('click', function(event) {
    //     event.preventDefault();

    //     // // First fetch request to get shipping details
    //     // fetch('{{ route('customer.order.shipping') }}')
    //     //     .then(response => response.text())
    //     //     .then(htmlContent => {
    //     //         document.getElementById('popupContent').innerHTML = htmlContent;
    //     //         document.getElementById('orderPopup').classList.remove('hidden');
    //     //         const scripts = document.getElementById('popupContent').getElementsByTagName('script');
    //     //         for (let script of scripts) {
    //     //             eval(script.innerHTML);
    //     //         }


    //     //     })
    //     //     .catch(error => {
    //     //         console.error('Error fetching content:', error);
    //     //     });
    //     // Extract necessary data for the POST request
    //     const quantity = document.getElementById('quantity').value;

    //     // Second fetch request - POST to save order items quantity
    //     fetch('{{ route('customer.order.saveQuantities') }}', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: JSON.stringify({
    //                 quantity
    //             })
    //         })
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error('Network response was not ok');
    //             }
    //             // Handle successful response if needed
    //         })
    //         .catch(error => {
    //             console.error('Error in second fetch request:', error);
    //         });
    // });
    // $(document).ready(function() {
    //     // Event listener for clicking on an element with id checkoutButton
    //     $('#checkoutButton').click(function(event) {
    //         event.preventDefault();


    //         fetch('{{ route('customer.order.shipping') }}')
    //             .then(response => response.text())
    //             .then(htmlContent => {
    //                 $('#popupContent').html(htmlContent); // Update HTML content
    //                 $('#orderPopup').removeClass('hidden'); // Remove 'hidden' class to show popup

    //                 // Optional: Evaluate scripts in the fetched content
    //                 const scripts = $('#popupContent').find('script');
    //                 scripts.each(function() {
    //                     eval($(this).html()); // Execute script content
    //                 });
    //             })
    //             .catch(error => {
    //                 console.error('Error fetching content:', error);
    //             });

    //         // Extract necessary data for the POST request
    //         const quantity = $('#quantity').val();

    //         // jQuery AJAX POST request to save order items quantity
    //         $.ajax({
    //             url: '{{ route('customer.order.saveQuantities') }}',
    //             type: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //             },
    //             contentType: 'application/json',
    //             data: JSON.stringify({
    //                 quantity
    //             }),
    //             success: function(response) {
    //                 console.log('Quantities updated successfully:', response);
    //                 // Handle success response if needed
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error in AJAX request:', error);
    //             }
    //         });
    //     });
    // });

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

        // Event listener for the "Next" button click
        $('#checkoutButton').on('click', function(event) {
            event.preventDefault();
            updateItemQuantities();
            fetch('{{ route('customer.order.shipping') }}')
                .then(response => response.text())
                .then(htmlContent => {
                    $('#popupContent').html(htmlContent);
                    $('#orderPopup').removeClass('hidden');


                    const scripts = $('#popupContent').find('script');
                    scripts.each(function() {
                        eval($(this).html());
                    });
                })
                .catch(error => {
                    console.error('Error fetching content:', error);
                });

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
                    alert(JSON.stringify(response));
                },
                error: function(xhr, status, error) {
                    console.error('Error in AJAX request:', error);
                }
            });
        });
    });




    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('orderPopup').classList.add('hidden');
    });

    document.addEventListener('click', function(event) {
        if (event.target.id === 'orderPopup') {
            document.getElementById('orderPopup').classList.add('hidden');
        }
    });
</script>
