<hr class="mb-4">
@if (session('success'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

@if ($featuredProducts->isEmpty())
    <p class="text-center text-gray-500">No products available in this section.</p>
@else
    <div class="flex flex-col mb-8">
        <div class="flex items-center justify-between mb-2">
        </div>
        <div class="overflow-x-auto hide-scrollbar">
            <div class="flex space-x-4" id="featuredProducts">
                @foreach ($featuredProducts as $product)
                    <div class="min-w-[200px] bg-white rounded-lg shadow-md p-4">
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-32 object-cover rounded-md mb-2" loading="lazy">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-lg mb-2">{{ $product->description }}</p>
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
