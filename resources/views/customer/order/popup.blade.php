@if ($order && $orderItems->isNotEmpty())
    <div class="bg-white border border-gray-300 rounded-lg p-2 mb-2 max-w-sm mx-auto mt-12">
        <button id="closePopup1" class="float-right text-red-700 text-2xl">&times;</button>
        <h3 class="text-lg font-bold mb-1">Order #{{ $order->id }}</h3>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-2 py-1 border text-center text-sm">Image</th>
                    <th class="px-2 py-1 border text-center text-sm">Name</th>
                    <th class="px-2 py-1 border text-center text-sm">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td class="border px-2 py-1 text-center">
                            <div class="flex justify-center space-x-1">
                                <img src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->product_name }}"
                                    class="w-12 h-6 object-cover rounded-md">
                            </div>
                        </td>
                        <td class="border px-2 py-1 text-center text-sm">{{ $item->product_name }}</td>
                        <td class="border px-2 py-1 text-center text-green-600 text-sm">
                            @if ($item->prev_price && $item->prev_price > $item->product_price)
                                <del class="text-red-400 mr-1">{{ number_format($item->prev_price, 2) }} BDT</del>
                            @endif
                            <br>
                            {{ number_format($item->product_price, 2) }} BDT
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 flex justify-between items-center">
            <span class="text-sm font-bold opacity-0">Total: {{ $order->total }} BDT</span>
            <a href="{{ route('customer.order.home') }}">
                <button type="submit"
                    class="bg-red-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">
                    Proceed
                </button>
            </a>
        </div>
    </div>
@else
    <p class="text-center text-gray-600">You have no open orders.</p>
@endif

<script>
    document.getElementById('closePopup1').addEventListener('click', function() {
        document.getElementById('orderPopup').classList.add('hidden');
    });
</script>
