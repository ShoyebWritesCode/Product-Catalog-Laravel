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
                    {{-- <div class="container mx-auto px-4"> --}}
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
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

