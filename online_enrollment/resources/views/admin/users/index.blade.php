<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th
                                        class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="{{ $user->isAdmin() ? 'bg-indigo-50' : '' }}">
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                        <div class="flex items-center">
                                            @if($user->profile_picture)
                                            <img class="h-8 w-8 rounded-full object-cover mr-3"
                                                src="{{ asset('storage/' . $user->profile_picture) }}"
                                                alt="{{ $user->name }}">
                                            @else
                                            <div
                                                class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-white mr-3">
                                                <span>{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                            @endif
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                        {{ $user->email }}
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->isAdmin() ? 'bg-indigo-100 text-indigo-800' : 
                                            ($user->isTeacher() ? 'bg-blue-100 text-blue-800' : 
                                            'bg-gray-100 text-gray-800') }}">
                                            {{ $user->isAdmin() ? 'Admin' : ($user->isTeacher() ? 'Teacher' : 'Student') }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-sm font-medium rounded-md hover:bg-blue-200 transition">
                                                Edit
                                            </a>

                                            @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm font-medium rounded-md hover:bg-red-200 transition">
                                                    Delete
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination links -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>