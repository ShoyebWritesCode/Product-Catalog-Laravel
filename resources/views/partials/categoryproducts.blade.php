@foreach ($Products as $product)
    <div class="shadow-md w-48 flex flex-col relative bg-white">
        <img src="{{ asset('storage/images/' . $product->images->first()->path) }}" alt="{{ $product->name }}"
            class="w-full h-32 object-cover mb-2" loading="lazy">
        <a href="{{ route('customer.product.show', $product->id) }}"
            class="text-lg font-semibold text-center text-blue-500 hover:text-blue-700 mb-2">
            {{ $product->name }}
        </a>
        <div class="text-center mb-2">
            <p class="text-sm text-red-600">{{ $product->price }} BDT</p>
            @if (isset($product->prev_price) && $product->prev_price > $product->price)
                <p class="text-sm text-center text-gray-400 flex justify-center items-center">
                    <del class="mr-2">{{ number_format($product->prev_price, 2) }} BDT</del>
                    <span class="text-green-600">
                        -{{ number_format((($product->prev_price - $product->price) / $product->prev_price) * 100, 2) }}%
                    </span>
                </p>
            @endif
            <p class="text-sm text-yellow-600">
                {{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}
            </p>
        </div>
    </div>
@endforeach
