<hr class="mb-0">
@if (session('success'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

@if ($featuredProducts->isEmpty())
    <p class="text-center text-gray-500">No products available in this section.</p>
@else
    <div class="flex flex-col mb-0">
        <div class="flex items-center justify-between mb-2">
        </div>
        <div class="overflow-x-auto hide-scrollbar">
            <div class="flex space-x-4 mb-3 mt-2" id="featuredProducts">
                @foreach ($featuredProducts as $product)
                    <div class="h-1/4 min-w-[200px] bg-gray-300 rounded-lg shadow-md p-4 mt-2">
                        <img src="{{ asset('storage/images/' . $product->images->first()->path) }}"
                            alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-md mb-2" loading="lazy">
                        <a href="{{ route('customer.product.show', $product->id) }}"
                            class="text-lg font-semibold text-center text-blue-500 hover:text-blue-700 mb-2 no-underline">
                            {{ $product->name }}
                        </a>
                        <p class="text-sm text-center mb-2">
                            {{ Str::limit($product->description, 20, '...') }}
                        </p>
                        <p class="text-gray-600">{{ number_format($product->price, 2) }} BDT</p>
                        <p class="text-sm text-yellow-600">
                            {{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}
                        </p>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
