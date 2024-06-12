<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex-1 text-center">
                <a href="{{ route('admin.product.home') }}" class="text-blue-500 hover:text-blue-700 mx-4">
                    {{ __('Product') }}
                </a>
                <a href="{{ route('admin.catagory.home') }}" class="text-blue-500 hover:text-blue-700 mx-4">
                    {{ __('Category') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.users') }}" class="text-green-500 hover:text-blue-700 mx-4">
                                        {{ __('Total Users') }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $totalUsers }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Total Products</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $totalProducts }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Total Categories</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $totalCategories }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Total Reviews</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $totalReviews }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

