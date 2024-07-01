@foreach ($products as $product)
    <div class="bg-white border border-gray-300 rounded-lg p-4 w-48 flex flex-col items-center">
        <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-md mb-2" loading="lazy">
        <a href="{{ route('customer.product.show', $product->id) }}" class="text-lg font-semibold text-center text-blue-500 hover:text-blue-700 mb-2">
            {{ $product->name }}
        </a>
        <p class="text-sm text-center mb-2">
            {{ Str::limit($product->description, 100, '...') }}
        </p>
        <p class="text-sm text-red-600 mb-2">{{ $product->price }} BDT</p>
        <p class="text-sm text-yellow-600 mb-2">
            {{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}
        </p>
        <div class="flex flex-wrap justify-center mt-2">
            @if(isset($nameparentcategories[$product->id]))
                @foreach($nameparentcategories[$product->id] as $category)
                    <div class="border border-green-600 rounded-md px-2 mx-1 mb-1">
                        <p class="text-sm text-green-600">{{ $category }}</p>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="flex flex-wrap justify-center mt-2">
            @if(isset($namesubcategories[$product->id]))
                @foreach($namesubcategories[$product->id] as $subcategory)
                    <div class="border border-green-600 rounded-md px-2 mx-1 mb-1">
                        <p class="text-sm text-green-600">{{ $subcategory }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endforeach
