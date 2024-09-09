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
