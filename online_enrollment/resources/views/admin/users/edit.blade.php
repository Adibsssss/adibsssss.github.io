<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="name">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="roles">Role</label>
                        <select name="roles[]" id="roles" multiple
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple roles.
                        </p>
                    </div>

                    <!-- Profile Picture -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="avatar">Profile Picture</label>
                        @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile Picture"
                            class="w-24 h-24 mb-2 rounded-full object-cover">
                        @endif
                        <input type="file" name="avatar" id="avatar"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>