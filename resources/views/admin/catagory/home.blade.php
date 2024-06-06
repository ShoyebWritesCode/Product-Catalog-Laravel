<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catagory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-semibold">List Category</h1>
                        <a href="{{ route('admin.catagory.create') }}" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">Add a new Catagory</a>
                    </div>
                    <hr class="mb-4">
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-4 border-b border-gray-300">Serial No.</th>
                                    <th class="py-2 px-4 border-b border-gray-300">Catagory</th>
                                    <th class="py-2 px-4 border-b border-gray-300">Subcategories</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index => $category)
                                    <tr>
                                        <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $index + 1 }}</td>
                                        <td class="py-2 px-4 border-b border-gray-300">{{ $category->name }}</td>
                                        <td class="py-2 px-4 border-b border-gray-300">
                                            @foreach ($subcategories as $subcategory)
                                                @if ($subcategory->parent_id == $index + 1)
                                                    {{ $subcategory->name }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
