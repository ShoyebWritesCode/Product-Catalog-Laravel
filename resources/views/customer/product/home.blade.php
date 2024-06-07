<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-semibold">List Product</h1>
                    </div>
                    <hr class="mb-4">
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-6">
                        @foreach ($products as $product)
                            <div class="bg-white border border-gray-300 rounded-lg p-4 w-48 h-48 flex flex-col items-center">
                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-md mb-2">
                                <a href="{{ route('customer.product.show', $product->id) }}" class="text-lg font-semibold text-center text-blue-500 hover:text-blue-700">
                                    {{ $product->name }}
                                </a>
                                <h3 class="text-sm text-center">
                                    {{ Str::limit($product->description, 100, '...') }}
                                </h3>
                                <p class="text-sm text-red-600">{{ $product->price }} BDT</p>
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
                        @endforeach
                    </div>
                    

                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>