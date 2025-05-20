<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Success message -->
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Profile Avatar Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h4 class="text-xl font-medium text-gray-700 mb-4">Your Avatar:</h4>
            <div class="flex items-center space-x-4">
                @if(Auth::user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture"
                    class="w-32 h-32 rounded-full object-cover shadow-md">
                @else
                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-white">
                    <span>No image</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Profile Picture Upload Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload New Profile
                        Picture</label>
                    <input type="file" name="image" id="image" required
                        class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>