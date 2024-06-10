<link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
                        <a href="{{ route('admin.product.create') }}" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Add a new Product</a>
                    </div>
                    <hr class="mb-4">
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                {{-- <th class="px-4 py-2">Image</th> --}}
                                <th class="px-4 py-2">Name</th>
                                {{-- <th class="px-4 py-2">Description</th> --}}
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2">Ratings</th>
                                {{-- <th class="px-4 py-2">Edit</th>
                                <th class="px-4 py-2">Delete</th> --}}
                                {{-- <th class="px-4 py-2">Categories</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                {{-- <td class="px-4 py-2">
                                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-md">
                                </td> --}}
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.product.show', $product->id) }}" class="text-blue-500 hover:text-blue-700">{{ $product->name }}</a>
                                </td>
                                {{-- <td class="px-4 py-2">{{ Str::limit($product->description, 50, '...') }}</td> --}}
                                <td class="px-4 py-2">{{ $product->price }} BDT</td>
                                <td class="px-4 py-2">{{ isset($averageRatings[$product->id]) ? number_format($averageRatings[$product->id], 2) : 'No Ratings' }}</td>
                                {{-- <td class="px-4 py-2">
                                    @if(isset($nameparentcategories[$product->id]))
                                        @foreach($nameparentcategories[$product->id] as $subcategory)
                                            <div class="border border-green-600 rounded-md px-2 mx-1">
                                                <p class="text-sm text-green-600">{{ $subcategory }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if(isset($namesubcategories[$product->id]))
                                        @foreach($namesubcategories[$product->id] as $subcategory)
                                            <div class="border border-green-600 rounded-md px-2 mx-1">
                                                <p class="text-sm text-green-600">{{ $subcategory }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </td> --}}
                                {{-- <td class="px-4 py-2">
              <i class="far fa-user"></i>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.product.show', $product->id) }}" class="text-blue-500 hover:text-blue-700">Delete</a>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    

                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
