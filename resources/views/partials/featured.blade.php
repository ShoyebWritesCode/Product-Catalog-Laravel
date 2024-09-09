@if ($featuredProducts->isEmpty())
    <p class="text-center text-gray-500">No products available in this section.</p>
@else
    <div class="flex flex-col mb-0">
        <div class="flex items-center justify-between mb-0">
        </div>
        <div class="overflow-x-auto hide-scrollbar">
            <div class="flex space-x-2 mb-3 mt-0" id="featuredProducts">
                @foreach ($featuredProducts as $product)
                    <div class="h-[350px] min-w-[200px] bg-white  shadow-md p-0 mt-2">
                        <a href="{{ route('customer.product.show', ['product' => $product->id, 'slug' => $product->slug]) }}"
                            class="no-underline">
                            <img src="{{ asset('storage/images/' . $product->images->first()->path) }}"
                                alt="{{ $product->name }}" class="w-full h-40 object-cover  mb-2" loading="lazy">

                            <p
                                class="text-lg text-center mb-2 font-semibold text-gray-900 hover:text-blue-700  no-underline">
                                {{ $product->name }}
                            </p>

                            <p class="text-sm text-center mb-2 text-gray-400">
                                {{ Str::limit($product->description, 20, '...') }}
                            </p>
                            <p class="text-orange-600 text-center">{{ number_format($product->price, 2) }} BDT</p>
                            @if (isset($product->prev_price) && $product->prev_price > $product->price)
                                <p class="text-sm text-center text-gray-400 flex justify-center items-center">
                                    <del class="mr-2">{{ number_format($product->prev_price, 2) }} BDT</del>
                                    <span class="text-green-600">
                                        -{{ number_format((($product->prev_price - $product->price) / $product->prev_price) * 100, 2) }}%
                                    </span>
                                </p>
                            @endif
                            <p class="text-sm text-yellow-600 text-center">
                                {{ $product->averageRating() !== null ? number_format($product->averageRating(), 2) : 'No Ratings' }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
