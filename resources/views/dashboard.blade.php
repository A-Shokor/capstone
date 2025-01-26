<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                
                    <a href="{{ route('product.index') }}" style="
    display: inline-block;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    text-align: center;
    transition: background-color 0.3s ease;
">
    Go to Products
</a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
