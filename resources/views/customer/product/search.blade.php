
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- <h1 class="text-2xl font-semibold mb-4">Search Results for "{{ $search }}"</h1> --}}

                    @if ($products->isEmpty())
                        <p class="text-center text-gray-500">No products found.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($products as $product)
                                <div class="bg-white border border-gray-300 rounded-lg p-4 flex flex-col items-center">
                                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-md mb-2">
                                    <a href="{{ route('customer.product.show', $product->id) }}" class="text-lg font-semibold text-center text-blue-500 hover:text-blue-700 mb-2">
                                        {{ $product->name }}
                                    </a>
                                    <p class="text-sm text-center mb-2">
                                        {{ Str::limit($product->description, 100, '...') }}
                                    </p>
                                    <p class="text-sm text-red-600 mb-2">{{ $product->price }} BDT</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

