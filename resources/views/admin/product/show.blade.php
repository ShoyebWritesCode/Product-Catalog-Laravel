<x-app-layout>
    @vite(['resources/scss/show.scss'])
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
                            <p class="text-sm text-yellow-600">
                                Rating: {{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}
                            </p>
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
                        <div class="ml-4 p-4">
                            {{-- <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-80 h-64 object-cover rounded-md"> --}}
                            <!-- Slider main container -->
                            <div class="swiper">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                <!-- Slides -->
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover rounded-md">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/' . $product->image1) }}" alt="{{ $product->name }}" class="object-cover rounded-md">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/' . $product->image2) }}" alt="{{ $product->name }}" class="object-cover rounded-md">
                                </div>
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>
                            
                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            
                                <!-- If we need scrollbar -->
                                {{-- <div class="swiper-scrollbar"></div> --}}
                            </div>
                        </div>
                     </div>
                    

                        <div class="mt-8">
                            @if ($reviews->isNotEmpty())
                            <h2 class="text-2xl font-bold mb-4">Reviews & Ratings</h2>
    
                            <div class="mb-6">
                                    <h3 class="text-xl font-semibold mb-2">Existing Reviews</h3>
                                    @foreach ($reviews as $review)
                                        <div class="bg-gray-100 p-4 rounded-lg mb-4">
                                            <p class="text-lg font-semibold">
                                                @if ($review->user_id == null)
                                                    Anonymous
                                                @else
                                                    {{ $review->user->name }}
                                                @endif
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                            <p class="text-sm">Rating: {{ $review->rating }}/5</p>
                                            <p class="text-xs text-gray-500">Posted on: {{ $review->created_at->format('Y-m-d') }}</p>
                                        </div>
                                    @endforeach
                            </div>
                            @endif
                            
                        </div>
                    </div>
            </div>
        </div>
    </div>
@vite(['resources/js/custom/show.js'])
</x-app-layout>

