<x-app-layout>
    <x-slot name="header">
        @include('partials.nav')
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($order)
                    <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold">Order #{{ $order->id }}</h3>
                            @if ($order->refund === null && $order->status != 2)
                                <div class="mx-4"></div>
                                <a href="{{ route('customer.order.cancel', $order->id) }}">
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Cancel Order
                                    </button>
                                </a>
                            @endif
                            @if ($order->refund === 0)
                                <span class="text-yellow-500">Refund Request Pending</span>
                            @elseif ($order->refund == 1)
                                <span class="text-green-500">Refund Request Approved</span>
                            @elseif ($order->refund == 2)
                                <span class="text-red-500">Refund Request Rejected</span>
                            @endif
                            @if ($order->status === 2)
                                <span class="text-blue-500">Order Delivered</span>
                            @endif
                        </div>
                    </div>

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border text-center">Image</th>
                                <th class="px-4 py-2 border text-center">Name</th>
                                <th class="px-4 py-2 border text-center">Price</th>
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
                                    <td class="border px-4 py-2 text-center text-red-600">
                                        {{ $item->product_price }} BDT</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold">Total: {{ $order->total }} BDT</span>
                    </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 grid grid-cols-2 gap-6">
                <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4 col-span-2 sm:col-span-1">
                    <h3 class="text-xl font-bold mb-4">Shipping Address Details</h3>
                    <div class="mb-4">
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">City: {{ $order->city }}</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Address: {{ $order->address }}</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Phone No. {{ $order->phone }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4 col-span-2 sm:col-span-1">
                    <h3 class="text-xl font-bold mb-4">Billing Address Details</h3>
                    <div class="mb-4">
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">City: {{ $order->billing_city }}</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Address: {{ $order->billing_address }}</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Phone No. {{ $order->bolling_phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <form action="{{ route('customer.order.reorder', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Re-Order
                    </button>
                </form>




            </div>
        @else
            <p class="text-center text-gray-600">You have no open orders.</p>
            @endif
        </div>
    </div>
    </div>
</x-app-layout>
