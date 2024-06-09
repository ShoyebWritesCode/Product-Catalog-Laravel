<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-white border border-gray-300 rounded-lg p-4 flex">
                        <div class="flex-grow">
                            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                            <p class="text-lg mb-2">{{ $product->description }}</p>
                            <p class="text-lg text-red-600 mb-2">{{ $product->price }} BDT</p>
                            <div class="flex justify-center mt-2">
                                @if(isset($nameparentcategories[$product->id]))
                                    @foreach($nameparentcategories[$product->id] as $subcategory)
                                        <div class="border border-green-600 rounded-md px-2 mx-1">
                                            <p class="text-sm text-green-600">{{ $subcategory }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex justify-center mt-2">
                                @if(isset($namesubcategories[$product->id]))
                                    @foreach($namesubcategories[$product->id] as $subcategory)
                                        <div class="border border-green-600 rounded-md px-2 mx-1">
                                            <p class="text-sm text-green-600">{{ $subcategory }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 md:px-24 p-16 h-screen">
                            <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-md">
                        </div>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-2xl font-bold mb-4">Reviews & Ratings</h2>

                        <div class="mb-6">
                         <h3 class="text-xl font-semibold mb-2">Existing Reviews</h3>
                         @foreach ($reviews as $review)
                            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                                <p class="text-lg font-semibold">{{ $review->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                <p class="text-sm">Rating: {{ $review->rating }}/5</p>
                                <p class="text-xs text-gray-500">Posted on: {{ $review->created_at->format('Y-m-d') }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xl font-semibold mb-2">Add Your Review</h3>
                            <form action="{{ route('customer.product.reviews', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment:</label>
                                    <textarea name="comment" id="comment" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"></textarea>
                                    @error('comment')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating:</label>
                                    <select name="rating" id="rating" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    @error('rating')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Submit Review</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

