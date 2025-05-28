@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Edit Product</h2>
            <a href="{{ route('products.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
                Back to List
            </a>
        </div>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
        <div
            class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-200 dark:text-red-800">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product->id) }}">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required
                    class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description"
                    class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Description</label>
                <textarea id="description" name="description"
                    class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Price --}}
            <div class="mb-6">
                <label for="price" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Price</label>
                <input id="price" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                    required
                    class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection