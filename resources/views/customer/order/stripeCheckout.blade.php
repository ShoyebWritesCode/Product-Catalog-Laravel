<x-app-layout>
    <x-slot name="header">
        @include('partials.nav')
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($order)
                    <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4">
                        <h3 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h3>
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border text-center">Image</th>
                                    <th class="px-4 py-2 border text-center">Name</th>
                                    <th class="px-4 py-2 border text-center">Size</th>
                                    <th class="px-4 py-2 border text-center">Color</th>
                                    <th class="px-4 py-2 border text-center">Price</th>
                                    <th class="px-4 py-2 border text-center">Quantity</th>
                                    <th class="px-4 py-2 border text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <img src="{{ asset('storage/images/' . $item->image) }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="w-16 h-16 object-cover rounded-md">
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2 text-center">{{ $item->product_name }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $item->size->name }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $item->color->name }}</td>
                                        <td class="border px-4 py-2 text-center text-red-600">
                                            {{ $item->product_price }} BDT</td>
                                        <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                                        <td class="border px-4 py-2 text-center">
                                            {{ $item->quantity * $item->product_price }} BDT</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-1 flex justify-between items-center">
                            <span class="text-lg font-bold opacity-0"></span>
                            <br>
                            <br>
                            <span class="text-lg font-bold text-green-300">Grand Total: {{ $order->total }}
                                BDT</span>
                        </div>
                    </div>


                    <div class="flex justify-start mt-4">
                    </div>
                @else
                    <p class="text-center text-gray-600">You have no open orders.</p>
                @endif

            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-2xl font-bold px-6 py-4">Payment Details</h1>
                <form id="payment-form" class="px-6 py-2">
                    <div class="mb-4">
                        <label for="holder-name" class="block text-gray-700">Holder Name</label>
                        <input id="holder-name" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Card Number</label>
                        <div id="card-number-element" class="border p-4 rounded-md">
                            <!-- Stripe Card Number Element -->
                        </div>
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700">Expiration Date</label>
                            <div id="expiry-element" class="border p-4 rounded-md">
                                <!-- Stripe Expiration Date Element -->
                            </div>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700">CVC</label>
                            <div id="cvc-element" class="border p-4 rounded-md">
                                <!-- Stripe CVC Element -->
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="zip-code" class="block text-gray-700">Zip Code</label>
                        <input id="zip-code" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <button id="submit-button"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded relative flex items-center justify-center">
                        <span id="button-text">Pay Now</span>
                    </button>

                    <div id="payment-message" class="mt-4 text-red-500"></div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();

        // Create and mount individual Stripe Elements
        const cardNumberElement = elements.create('cardNumber', {
            style: {
                base: {
                    color: '#000',
                    fontSize: '16px',
                    fontFamily: '"Source Code Pro", monospace',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                    padding: '10px',
                    border: '1px solid #d1d5db',
                    borderRadius: '0.375rem'
                },
                invalid: {
                    color: '#e5424d',
                    iconColor: '#e5424d',
                },
            },
        });
        cardNumberElement.mount('#card-number-element');

        const expiryElement = elements.create('cardExpiry', {
            style: {
                base: {
                    color: '#000',
                    fontSize: '16px',
                    fontFamily: '"Source Code Pro", monospace',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                    padding: '10px',
                    border: '1px solid #d1d5db',
                    borderRadius: '0.375rem'
                },
                invalid: {
                    color: '#e5424d',
                    iconColor: '#e5424d',
                },
            },
        });
        expiryElement.mount('#expiry-element');

        const cvcElement = elements.create('cardCvc', {
            style: {
                base: {
                    color: '#000',
                    fontSize: '16px',
                    fontFamily: '"Source Code Pro", monospace',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                    padding: '10px',
                    border: '1px solid #d1d5db',
                    borderRadius: '0.375rem'
                },
                invalid: {
                    color: '#e5424d',
                    iconColor: '#e5424d',
                },
            },
        });
        cvcElement.mount('#cvc-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const paymentMessage = document.getElementById('payment-message');
        const buttonText = document.getElementById('button-text');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.classList.remove('bg-blue-500', 'hover:bg-blue-700');
            submitButton.classList.add('bg-red-500');
            buttonText.textContent = 'Proceeding...';

            const {
                clientSecret
            } = await fetch("{{ route('create-payment-intent') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: "{{ $order->id }}"
                })
            }).then(response => response.json());

            const {
                paymentIntent,
                error
            } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardNumberElement,
                }
            });

            if (error) {
                paymentMessage.textContent = error.message;
            } else {
                if (paymentIntent.status === 'succeeded') {
                    await fetch("{{ route('handle-payment-success') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            payment_intent: paymentIntent.id
                        })
                    });
                    paymentMessage.textContent = 'Payment successful!';
                    submitButton.classList.add('bg-blue-500', 'hover:bg-blue-700');
                    submitButton.classList.remove('bg-red-500');
                    buttonText.textContent = 'Pay Now';

                    window.location.href =
                        "{{ route('customer.order.orderdetail', ['order' => $order->id]) }}";

                }
            }
        });
    </script>


</x-app-layout>
