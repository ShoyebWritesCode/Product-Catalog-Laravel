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
                @if($order)
                    <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4">
                        <h3 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h3>
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border text-center">Image</th>
                                    <th class="px-4 py-2 border text-center">Name</th>
                                    <th class="px-4 py-2 border text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <img src="{{ asset('storage/images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md">
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2 text-center">{{ $item->product->name }}</td>
                                        <td class="border px-4 py-2 text-center text-red-600">{{ $item->product->price }} BDT</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Total: {{ $order->total }} BDT</span>
                            <form action="{{ route('customer.order.checkout', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-600">You have no open orders.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

