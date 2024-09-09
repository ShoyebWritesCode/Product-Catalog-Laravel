<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.products') }}"
            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600 no-underline">Back</a>
    </x-slot>

    <div class="py-12">
        <div class="w-3/4 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <hr>
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.product.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700">Description:</label>
                            <input type="text" name="description" id="description"
                                class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                            <input type="text" name="price" id="price"
                                class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('price')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Category:</label>
                            <div class="flex space-x-4">
                                @foreach ($categories as $category)
                                    <div class="flex flex-col mb-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="category_{{ $category->id }}"
                                                name="parent_categories[]" value="{{ $category->id }}"
                                                class="mr-2 parent-category">
                                            <label for="category_{{ $category->id }}"
                                                class="text-sm">{{ $category->name }}</label>
                                        </div>
                                        <div class="ml-6 hidden subcategories mt-2"
                                            id="subcategories_{{ $category->id }}">
                                            @foreach ($subcategories as $subcategory)
                                                @if ($subcategory->parent_id == $category->id)
                                                    <div class="flex items-center mb-2">
                                                        <input type="checkbox" id="subcategory_{{ $subcategory->id }}"
                                                            name="subcategories[]" value="{{ $subcategory->id }}"
                                                            class="mr-2" data-parent="{{ $category->id }}">
                                                        <label for="subcategory_{{ $subcategory->id }}"
                                                            class="text-sm">{{ $subcategory->name }}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4 px-2">
                            <label for="images" class="block text-sm font-medium text-gray-700">Images:</label>
                            <input type="file" name="images[]" id="images"
                                class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                                accept="image/*" multiple>
                            @error('images.*')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/custom/product.js'])
</x-app-layout>

<script>
    document.getElementById('addMore').addEventListener('click', function() {
        var div = document.createElement('div');
        div.innerHTML =
            '<input type="file" name="images[]" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">';
        document.getElementById('imageInputs').appendChild(div);
    });
</script>
