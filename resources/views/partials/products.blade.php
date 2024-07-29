@foreach ($products as $product)
    <div class="bg-white border border-gray-300 rounded-lg p-4 w-48 flex flex-col relative">
        <img src="{{ asset('storage/images/' . $product->images->first()->path) }}" alt="{{ $product->name }}"
            class="w-full h-32 object-cover rounded-md mb-2" loading="lazy">
        <a href="{{ route('customer.product.show', $product->id) }}"
            class="text-lg font-semibold text-center text-blue-500 hover:text-blue-700 mb-2">
            {{ $product->name }}
        </a>
        <p class="text-sm text-center mb-2">
            {{ Str::limit($product->description, 100, '...') }}
        </p>
        <div class="text-center mb-2">
            <p class="text-sm text-red-600">{{ $product->price }} BDT</p>
            <p class="text-sm text-yellow-600">
                {{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}
            </p>
        </div>
        <div class="flex flex-wrap justify-center mt-2">
            @if (isset($nameparentcategories[$product->id]))
                @foreach ($nameparentcategories[$product->id] as $category)
                    <div class="border border-green-600 rounded-md px-2 mx-1 mb-1">
                        <p class="text-sm text-green-600">{{ $category }}</p>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="flex flex-wrap justify-center mt-2">
            @if (isset($namesubcategories[$product->id]))
                @foreach ($namesubcategories[$product->id] as $subcategory)
                    <div class="border border-green-600 rounded-md px-2 mx-1 mb-1">
                        <p class="text-sm text-green-600">{{ $subcategory }}</p>
                    </div>
                @endforeach
            @endif
        </div>
        @if (isset($discountPercent[$product->id]))
            <span
                class="bg-red-500 text-white rounded-full py-1 px-3 flex items-center justify-center absolute top-0 right-0 -mt-3 -mr-3 text-sm">
                Discount: {{ $discountPercent[$product->id] }}%
            </span>
        @endif
    </div>
@endforeach
