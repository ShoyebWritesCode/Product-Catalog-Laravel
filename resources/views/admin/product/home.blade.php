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

                    <div class="overflow-x-auto">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>