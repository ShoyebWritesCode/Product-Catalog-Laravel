<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order History') }}
            </h2>
            <div class="flex-1 text-center">
                <a href="{{ route('customer.product.home') }}" class="text-blue-500 hover:text-blue-700 mx-4">
                    {{ __('Product') }}
                </a>
            </div>
            <a href="{{ route('customer.order.home') }}" class="text-gray-800 hover:text-gray-600 relative">
                <i class="fas fa-shopping-cart text-xl"></i>
                <span class="bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center absolute top-0 right-0 -mt-1 -mr-1 text-xs">
                    {{ $numberOfItems }}  
                </span> 
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <button class="w-full bg-gray-200 text-left p-4 font-bold" onclick="toggleSection('pendingOrders')">
                        Pending Orders
                    </button>
                    <div id="pendingOrders" class="hidden mt-4">
                        @if($pendingorders->isEmpty())
                            <p class="text-center text-gray-600">You have no pending orders.</p>
                        @else
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border text-center">Order ID</th>
                                        <th class="px-4 py-2 border text-center">Total</th>
                                        <th class="px-4 py-2 border text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingorders as $order)
                                        <tr>
                                            <td class="border px-4 py-2 text-center">
                                                <a href="{{route('customer.order.orderdetail',$order->id)}}">{{ $order->id }}</a>
                                            </td>
                                            <td class="border px-4 py-2 text-center">{{ $order->total }} BDT</td>
                                            <td class="border px-4 py-2 text-center">{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div>
                    <button class="w-full bg-gray-200 text-left p-4 font-bold" onclick="toggleSection('completedOrders')">
                        Completed Orders
                    </button>
                    <div id="completedOrders" class="hidden mt-4">
                        @if($completedorders->isEmpty())
                            <p class="text-center text-gray-600">You have no completed orders.</p>
                        @else
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border text-center">Order ID</th>
                                        <th class="px-4 py-2 border text-center">Total</th>
                                        <th class="px-4 py-2 border text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedorders as $order)
                                        <tr>
                                            <td class="border px-4 py-2 text-center">
                                                <a href="{{route('customer.order.orderdetail',$order->id)}}">{{ $order->id }}</a>
                                            </td>
                                            <td class="border px-4 py-2 text-center">{{ $order->total }} BDT</td>
                                            <td class="border px-4 py-2 text-center">{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
