@if ($featuredProducts->isEmpty())
    <p class="text-center text-gray-500">No products available in this section.</p>
@else
    <div class="flex flex-col mb-0">
        <div class="flex items-center justify-between mb-0">
        </div>
        <div class="overflow-x-auto hide-scrollbar">
            <div class="flex space-x-2 mb-3 mt-0" id="featuredProducts">
                @foreach ($featuredProducts as $product)
                    <div class="h-1/4 min-w-[200px] bg-white  shadow-md p-0 mt-2">
                        <img src="{{ asset('storage/images/' . $product->images->first()->path) }}"
                            alt="{{ $product->name }}" class="w-full h-40 object-cover  mb-2" loading="lazy">
                        <a href="{{ route('customer.product.show', $product->id) }}"
                            class="text-lg font-semibold text-gray-900 hover:text-blue-700  no-underline">
                            <p class="text-lg text-center mb-2">
                                {{ $product->name }}
                            </p>
                        </a>
                        <p class="text-sm text-center mb-2 text-gray-400">
                            {{ Str::limit($product->description, 20, '...') }}
                        </p>
                        <p class="text-orange-600 text-center">{{ number_format($product->price, 2) }} BDT</p>
                        <p class="text-sm text-yellow-600 text-center">
                            {{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}
                        </p>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
