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
                    {{ __('Catagory') }}
                </a>
            </div>
        </div>
    </x-slot>
    
    

    <div class="flex flex-wrap gap-6">
        <img src="{{ asset('images/admin.jpg') }}" alt="Admin Dashboard" class="w-full h-32 object-cover rounded-md mb-2">
    </div>
    
    
</x-app-layout>
