<x-app-layout>
    @vite(['resources/scss/show.scss'])
    <x-slot name="header">
        @include('partials.nav')
    </x-slot>

    <div id="successMessage" class="alert alert-success mb-4" role="alert" style="display: none;"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden ">
                <div class="p-4 text-gray-900">
                    <div class="bg-gray-100 border border-orange-300  p-4 flex shadow-md">
                        <div class="flex-grow">
                            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                            <p class="text-lg mb-2">{{ $product->description }}</p>

                            <div class="text-lg text-center text-gray-400 flex flex-col items-center">
                                <span class="text-lg text-orange-600 mb-2">{{ $product->price }} BDT</span>

                                @if (isset($product->prev_price) && $product->prev_price > $product->price)
                                    <del class="mr-2">{{ number_format($product->prev_price, 2) }} BDT</del>
                                    <span class="text-green-600">
                                        -{{ number_format((($product->prev_price - $product->price) / $product->prev_price) * 100, 2) }}%
                                    </span>
                                @endif

                                <span class="text-sm text-yellow-600 mt-2">
                                    @if (isset($averageRatings[$product->id]))
                                        @php
                                            $rating = $averageRatings[$product->id];
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                            $emptyStars = 5 - ($fullStars + $halfStar);
                                        @endphp

                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star text-yellow-500 text-2xl"></i>
                                        @endfor

                                        @for ($i = 0; $i < $halfStar; $i++)
                                            <i class="fas fa-star-half-alt text-yellow-500 text-2xl"></i>
                                        @endfor

                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star text-yellow-500 text-2xl"></i>
                                        @endfor
                                        <span class="text-lg text-gray-900 onhover: cursor-pointer"
                                            onclick="scrollToReviews()">({{ $product->reviewCount() }})</span>
                                    @else
                                        No Ratings
                                    @endif
                                </span>
                            </div>


                            <div class="flex justify-center mt-2">
                                @if (isset($nameparentcategories[$product->id]))
                                    @foreach ($nameparentcategories[$product->id] as $subcategory)
                                        <div class="border border-orange-600  px-2 mx-1">
                                            <p class="text-sm text-orange-600 m-1">{{ $subcategory }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex justify-center mt-2">
                                @if (isset($namesubcategories[$product->id]))
                                    @foreach ($namesubcategories[$product->id] as $subcategory)
                                        <div class="border border-orange-600 px-2 mx-1">
                                            <p class="text-sm text-orange-600 m-1">{{ $subcategory }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 p-4">
                            {{-- <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-80 h-64 object-cover rounded-md"> --}}
                            <!-- Slider main container -->
                            <div class="swiper shadow-sm">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach ($product->images as $image)
                                        <div class="swiper-slide ">
                                            <img src="{{ asset('storage/images/' . $image->path) }}"
                                                alt="{{ $product->name }}" class="object-cover ">
                                        </div>
                                    @endforeach
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

                    @if ($product->totalQuantity() > 0)
                        <div class="flex flex-col mt-4">
                            <form id="addToCartForm" action="{{ route('customer.order.add', $product->id) }}"
                                method="POST" class="w-full ">
                                @csrf

                                <!-- Select Size and Color in the same line -->
                                <div class="flex mb-4">
                                    <!-- Select Size -->
                                    <div class="mr-48">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Size:</label>
                                        <div class="flex items-center">
                                            @foreach ($sizes as $size)
                                                <input type="radio" id="size_{{ $size->id }}" name="size"
                                                    value="{{ $size->id }}" class="hidden size-option-input">
                                                <label for="size_{{ $size->id }}"
                                                    class="size-option bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded cursor-pointer mr-2 hover:bg-gray-300">
                                                    {{ $size->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Select Color -->
                                    <div class="mr-32">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Color:</label>
                                        <div class="flex items-center">
                                            @foreach ($colors as $color)
                                                <input type="radio" id="color_{{ $color->id }}" name="color"
                                                    value="{{ $color->id }}" class="hidden color-option-input">
                                                <label for="color_{{ $color->id }}"
                                                    class="color-option bg-{{ $color->description }}-500 text-gray-800 font-semibold py-2 px-4 rounded cursor-pointer mr-2 hover:bg-gray-300">
                                                    {{ $color->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="stock mt-6"></div>
                                </div>
                                <div class="w-1/6 self-end ml-auto">
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        id="CartButton">
                                        Add to Cart
                                    </button>
                                </div>

                            </form>
                        </div>
                    @else
                        <div class="stock">
                            <p class="text-red-500 text-center mt-4">Out of Stock</p>
                        </div>
                    @endif

                    <div class="mt-8">
                        <!-- Tab Navigation -->
                        <div class="flex space-x-4 mb-0">

                            <button id="detailsTab" class="tab-button" onclick="showTab('details')">Details</button>
                            <button id="specificationsTab" class="tab-button"
                                onclick="showTab('specifications')">Specifications</button>
                            <button id="reviewsTab" class="tab-button active"
                                onclick="showTab('reviews')">Reviews</button>

                        </div>
                        <hr class=" border-2 border-orange-600 mt-0">

                        <!-- Tab Content -->
                        <div id="details" class="tab-content hidden">
                            @if ($product->Detailes == null)
                                <p>This product does not have any details.</p>
                            @else
                                {!! $product->Detailes !!}
                            @endif

                        </div>

                        <div id="specifications" class="tab-content hidden">
                            @if ($product->attCount() == 0)
                                <p>This product does not have any specifications.</p>
                            @else
                                <table class="w-3/4">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-300 p-2 w-1/3">Attribute</th>
                                            <th class="border border-gray-300 p-2 w-2/3">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->attributes as $attribute)
                                            <tr>
                                                <td class="border border-gray-300 p-2">{{ $attribute->name->name }}
                                                </td>
                                                <td class="border border-gray-300 p-2">{{ $attribute->value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @endif
                        </div>

                        <div id="reviews" class="tab-content">
                            @php
                                $totalReviews = $reviews->count();
                                $totalRating = $reviews->sum('rating');
                                $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 2) : 0;
                                $ratingDistribution = array_fill(1, 5, 0);

                                foreach ($reviews as $review) {
                                    $ratingDistribution[$review->rating]++;
                                }
                            @endphp

                            <div class="mb-4 w-full flex justify-between items-center">
                                <div class="w-1/4">
                                    <h2 class="text-2xl font-bold mb-4">Average customer rating</h2>
                                    <p class="text-4xl font-bold mb-2">{{ $averageRating }} / 5</p>
                                    <p class="text-gray-500 mb-4">{{ $totalReviews }}
                                        review{{ $totalReviews != 1 ? 's' : '' }}</p>
                                    @php
                                        $rating = $averageRating;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - ($fullStars + $halfStar);
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-yellow-500 text-2xl"></i>
                                    @endfor

                                    @for ($i = 0; $i < $halfStar; $i++)
                                        <i class="fas fa-star-half-alt text-yellow-500 text-2xl"></i>
                                    @endfor

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-yellow-500 text-2xl"></i>
                                    @endfor
                                </div>

                                <div class="w-1/2 pr-6 pt-4">
                                    @foreach ([5, 4, 3, 2, 1] as $star)
                                        <div class="flex items-center mb-2">
                                            <div class="w-20 text-right mr-4">{{ $star }}
                                                star{{ $star > 1 ? 's' : '' }}</div>
                                            <div class="w-full bg-gray-200 rounded-full h-4">
                                                <div class="bg-yellow-500 h-4 rounded-full"
                                                    style="width: {{ $ratingDistribution[$star] > 0 ? ($ratingDistribution[$star] / $totalReviews) * 100 : 0 }}%;">
                                                </div>
                                            </div>
                                            <div class="flex items-center ml-4"> <!-- Added flex here -->
                                                <div class="w-12 text-right">{{ $ratingDistribution[$star] }}</div>
                                                <div class="text-right ml-1">
                                                    <!-- Optional: Adjust margin for spacing -->
                                                    ({{ $totalReviews > 0 ? round(($ratingDistribution[$star] / $totalReviews) * 100, 2) : 0 }}%)
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="w-1/10">
                                </div>

                            </div>


                            @if ($reviews->isNotEmpty())
                                <div class="mb-6">
                                    <h3 class="text-xl font-semibold mb-2">Existing Reviews</h3>
                                    @foreach ($reviews as $review)
                                        <div class="bg-gray-100 p-4 shadow-lg mb-4">
                                            <p class="text-lg font-semibold">
                                                @if ($review->user_id == null)
                                                    Anonymous
                                                @else
                                                    {{ $review->user->name }}
                                                @endif
                                            </p>

                                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                            <span class="text-sm text-yellow-600 mt-2">
                                                @if (isset($review->rating))
                                                    @php
                                                        $rating = $review->rating;
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                                        $emptyStars = 5 - ($fullStars + $halfStar);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fas fa-star text-yellow-500 text-xl"></i>
                                                    @endfor

                                                    @for ($i = 0; $i < $halfStar; $i++)
                                                        <i class="fas fa-star-half-alt text-yellow-500 text-xl"></i>
                                                    @endfor

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="far fa-star text-yellow-500 text-xl"></i>
                                                    @endfor
                                                @else
                                                    No Ratings
                                                @endif
                                            </span>
                                            <p class="text-xs text-gray-500">Posted on:
                                                {{ $review->created_at->format('Y-m-d') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @php
                                $lastReviewTime = Session::get("last_review_time_product_$product->id");
                            @endphp

                            @if (!$lastReviewTime || now()->diffInMinutes($lastReviewTime) >= 1)
                                <h3 class="text-xl font-semibold mb-2">Add Your Review</h3>
                                <form action="{{ route('customer.product.reviews', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="comment"
                                            class="block text-sm font-medium text-gray-700">Comment:</label>
                                        <textarea name="comment" id="comment"
                                            class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"></textarea>
                                        @error('comment')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="rating"
                                            class="block text-sm font-medium text-gray-700">Rating:</label>
                                        <select name="rating" id="rating"
                                            class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
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
                                    <div class="mb-4">
                                        <input type="checkbox" name="anonymous" id="anonymous" class="mr-2">
                                        <label for="anonymous" class="text-sm font-medium text-gray-700">Post as
                                            Anonymous</label>
                                    </div>
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Submit
                                        Review</button>
                                </form>
                            @else
                                <p class="text-red-500">You can only submit a review once every hour.</p>
                            @endif
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @vite(['resources/js/custom/show.js'])
    <script>
        function scrollToReviews() {
            const reviews = showTab('reviews');
            const reviewsSection = document.getElementById('reviews');
            reviewsSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }


        function showTab(tabName) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            document.getElementById(tabName).classList.remove('hidden');

            document.getElementById(tabName + 'Tab').classList.add('active');
        }
        showTab('details');

        document.addEventListener('DOMContentLoaded', function() {
            const sizeInputs = document.querySelectorAll('.size-option-input');
            const colorInputs = document.querySelectorAll('.color-option-input');

            // Event listener for size and color inputs
            sizeInputs.forEach(sizeInput => {
                sizeInput.addEventListener('change', function() {
                    updateInventory();
                });
            });

            colorInputs.forEach(colorInput => {
                colorInput.addEventListener('change', function() {
                    updateInventory();
                });
            });

            // Function to update inventory via AJAX
            function updateInventory() {
                const selectedSize = document.querySelector('input[name="size"]:checked');
                const selectedColor = document.querySelector('input[name="color"]:checked');
                const productId =
                    {{ $product->id }};

                if (selectedSize && selectedColor) {
                    const sizeId = selectedSize.value;
                    const colorId = selectedColor.value;

                    // AJAX request
                    fetch(
                            `{{ route('product.inventory.quantity') }}?size_id=${sizeId}&color_id=${colorId}&product_id=${productId}`
                        )
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Inventory Quantity:', data.quantity);
                                if (data.quantity > 0) {
                                    document.querySelector('.stock').innerHTML =
                                        `<p class="text-green-500">In Stock</p>`;
                                    document.getElementById('CartButton').style.display = 'block';
                                } else {
                                    document.querySelector('.stock').innerHTML =
                                        `<p class="text-red-500">Out of Stock</p>`;
                                    document.getElementById('CartButton').style.display = 'none';
                                }
                            } else {
                                document.querySelector('.stock').innerHTML =
                                    `<p class="text-red-500">Out of Stock</p>`;
                                document.getElementById('CartButton').style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching inventory quantity:', error);
                        });
                }
            }
        });


        document.getElementById('notificationDropdown').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('notificationDropdownContent').classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdownContent');
            if (!event.target.closest('#notificationDropdown') && !event.target.closest(
                    '#notificationDropdownContent')) {
                dropdown.classList.add('hidden');
            }
        });









        document.getElementById('cartLink').addEventListener('click', function(event) {
            event.preventDefault();

            fetch('{{ route('customer.order.popup') }}')
                .then(response => response.text())
                .then(htmlContent => {
                    document.getElementById('orderPopup').innerHTML = htmlContent;
                })
                .catch(error => {
                    console.error('Error fetching content:', error);
                });

            document.getElementById('orderPopup').classList.remove('hidden');
        });

        document.addEventListener('click', function(event) {
            if (event.target.id === 'orderPopup') {
                document.getElementById('orderPopup').classList.add('hidden');
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.id === 'orderPopup') {
                document.getElementById('orderPopup').classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
