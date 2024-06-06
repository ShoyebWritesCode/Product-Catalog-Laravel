<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
        <a href="{{ route('admin.product.home') }}" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                </hr>
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                    <form action="{{route('admin.product.save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                            <input type="text" name="name" id="name" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                            <input type="text" name="description" id="description" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                            <input type="text" name="price" id="price" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('price')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">Category:</label>
                            <select id="category" name="category" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                <option value="" name="category">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <input type="checkbox" id="subcat_checkbox">
                            <label for="subcat_checkbox" class="ml-2 text-sm font-medium text-gray-700">SubCategory?</label>
                        </div>
                        <div id="subcat_field" class="mb-4" style="display: none;">
                            <label for="subcategory_of" class="block text-sm font-medium text-gray-700">SubCategory of:</label>
                            <select id="subcategory_of" name="subcategory_of" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                <option value="" name="subcategory_of">Select Category</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-parent="{{ $subcategory->parent_id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_of')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image:</label>
                            <input type="file" name="image" id="image" class="mt-1 p-2 w-full border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            @error('image')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var checkbox = document.getElementById('subcat_checkbox');
            var subcatField = document.getElementById('subcat_field');
            checkbox.addEventListener('change', function () {
                if (checkbox.checked) {
                    subcatField.style.display = 'block';
                } else {
                    subcatField.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const subcategoryCheckbox = document.getElementById('subcat_checkbox');
    const subcatField = document.getElementById('subcat_field');
    const subcategorySelect = document.getElementById('subcategory_of');
    const subcategoryOptions = Array.from(subcategorySelect.options);

    subcategoryCheckbox.addEventListener('change', function() {
        if (this.checked) {
            subcatField.style.display = 'block';
        } else {
            subcatField.style.display = 'none';
        }
    });

    categorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;
        subcategorySelect.innerHTML = '<option value="" name="subcategory_of">Select Category</option>';
        subcategoryOptions.forEach(option => {
            if (option.dataset.parent == selectedCategoryId) {
                subcategorySelect.appendChild(option);
            }
        });
    });
});

    </script>
</x-app-layout>