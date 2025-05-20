<nav x-data="{ 
    open: false, 
    expandedMenu: localStorage.getItem('expandedMenu') || null,
    setActiveMenu(menu) {
        this.expandedMenu = menu;
        localStorage.setItem('expandedMenu', menu);
    }
}" class="bg-white border-r border-gray-200 w-64 flex-shrink-0 h-screen sticky top-0 overflow-y-auto hidden md:block">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
        <div class="flex items-center">
            <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-8 w-auto">
            <span
                class="ml-2 text-xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 bg-clip-text text-transparent">ENROLL</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="py-4 px-2">
        @auth
        @if(auth()->user()->isAdmin())
        <!-- Admin Navigation Links -->
        <div class="space-y-1">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Dashboard') }}
            </x-sidebar-link>

            <!-- Academic Management Section -->
            <div class="pt-2">
                <button @click="setActiveMenu(expandedMenu === 'academic' ? null : 'academic')"
                    class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 transition">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Academic
                    </div>
                    <svg :class="expandedMenu === 'academic' ? 'transform rotate-90' : ''"
                        class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="expandedMenu === 'academic'" x-collapse
                    class="ml-4 space-y-1 mt-1 border-l-2 border-indigo-100 pl-2">
                    <x-sidebar-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                        {{ __('Courses') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('program.index')" :active="request()->routeIs('program.*')">
                        {{ __('Programs') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('sections.index')" :active="request()->routeIs('sections.*')">
                        {{ __('Sections') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('course_schedules.index')"
                        :active="request()->routeIs('course_schedules.*')">
                        {{ __('Schedules') }}
                    </x-sidebar-link>
                </div>
            </div>

            <!-- User Management Section -->
            <div class="pt-2">
                <button @click="setActiveMenu(expandedMenu === 'users' ? null : 'users')"
                    class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 transition">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </div>
                    <svg :class="expandedMenu === 'users' ? 'transform rotate-90' : ''"
                        class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="expandedMenu === 'users'" x-collapse
                    class="ml-4 space-y-1 mt-1 border-l-2 border-indigo-100 pl-2">
                    <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                        @click.prevent="window.location.href = '{{ route('admin.users.index') }}'">
                        {{ __('User Management') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('assigned.teachers.list')"
                        :active="request()->routeIs('assigned.teachers.list')"
                        @click.prevent="window.location.href = '{{ route('assigned.teachers.list') }}'">
                        {{ __('Assign Teachers') }}
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Enrollment Management -->
            <x-sidebar-link :href="route('admin.enrollments.index')"
                :active="request()->routeIs('admin.enrollments.index')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Student Enrollments') }}
            </x-sidebar-link>
        </div>
        @endif

        @if(auth()->user()->isStudent())
        <!-- Student Navigation Links -->
        <div class="space-y-1">
            <x-sidebar-link :href="route('student.enrollments')" :active="request()->routeIs('student.enrollments')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                {{ __('My Enrollments') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('certificate.registration')"
                :active="request()->routeIs('certificate.registration')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('Certificate of Registration') }}
            </x-sidebar-link>
        </div>
        @endif

        @if(auth()->user()->isTeacher())
        <!-- Teacher Navigation Links -->
        <div class="space-y-1">
            <x-sidebar-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Dashboard') }}
            </x-sidebar-link>
        </div>
        @endif
        @endauth
    </div>

    <!-- User Profile Section -->
    <div class="border-t border-gray-200 mt-auto">
        <div class="p-4">
            @auth
            <div class="flex items-center space-x-3">
                @if(Auth::user()->profile_picture)
                <img class="h-10 w-10 rounded-full object-cover"
                    src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" />
                @else
                <div
                    class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center text-white">
                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="mt-4 flex flex-col space-y-2">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-2 py-1.5 text-sm text-gray-700 rounded-md hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-2 py-1.5 text-sm text-gray-700 rounded-md hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Mobile navigation toggle -->
<div x-data="{ 
    mobileMenuOpen: false,
    expandedMobileMenu: localStorage.getItem('expandedMobileMenu') || null,
    setActiveMobileMenu(menu) {
        this.expandedMobileMenu = menu;
        localStorage.setItem('expandedMobileMenu', menu);
    }
}" class="md:hidden sticky top-0 z-50">
    <div class="bg-white shadow-sm flex items-center justify-between h-16 px-4 border-b border-gray-200">
        <div class="flex items-center">
            <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-8 w-auto">
            <span
                class="ml-2 text-xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 bg-clip-text text-transparent">ENROLL</span>
        </div>

        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="bg-white border-b border-gray-200 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @auth
            @if(auth()->user()->isAdmin())
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Mobile Academic Management Section -->
            <div>
                <button @click="setActiveMobileMenu(expandedMobileMenu === 'academic' ? null : 'academic')"
                    class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 transition">
                    <span>{{ __('Academic') }}</span>
                    <svg :class="expandedMobileMenu === 'academic' ? 'transform rotate-90' : ''"
                        class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="expandedMobileMenu === 'academic'" x-collapse
                    class="ml-4 space-y-1 mt-1 border-l-2 border-indigo-100 pl-2">
                    <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')"
                        @click.prevent="window.location.href = '{{ route('courses.index') }}'">
                        {{ __('Courses') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('program.index')" :active="request()->routeIs('program.*')"
                        @click.prevent="window.location.href = '{{ route('program.index') }}'">
                        {{ __('Programs') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('sections.index')" :active="request()->routeIs('sections.*')"
                        @click.prevent="window.location.href = '{{ route('sections.index') }}'">
                        {{ __('Sections') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('course_schedules.index')"
                        :active="request()->routeIs('course_schedules.*')"
                        @click.prevent="window.location.href = '{{ route('course_schedules.index') }}'">
                        {{ __('Course Schedule') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Mobile User Management Section -->
            <div>
                <button @click="setActiveMobileMenu(expandedMobileMenu === 'users' ? null : 'users')"
                    class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 transition">
                    <span>{{ __('Users') }}</span>
                    <svg :class="expandedMobileMenu === 'users' ? 'transform rotate-90' : ''"
                        class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="expandedMobileMenu === 'users'" x-collapse
                    class="ml-4 space-y-1 mt-1 border-l-2 border-indigo-100 pl-2">
                    <x-responsive-nav-link :href="route('admin.users.index')"
                        :active="request()->routeIs('admin.users.*')"
                        @click.prevent="window.location.href = '{{ route('admin.users.index') }}'">
                        {{ __('User Management') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('assigned.teachers.list')"
                        :active="request()->routeIs('assigned.teachers.list')"
                        @click.prevent="window.location.href = '{{ route('assigned.teachers.list') }}'">
                        {{ __('Assign Teacher') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link :href="route('admin.enrollments.index')"
                :active="request()->routeIs('admin.enrollments.index')">
                {{ __('Student Enrollments') }}
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->isStudent())
            <x-responsive-nav-link :href="route('student.enrollments')"
                :active="request()->routeIs('student.enrollments')">
                {{ __('My Enrollments') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('certificate.registration')"
                :active="request()->routeIs('certificate.registration')">
                {{ __('Certificate of Registration') }}
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->isTeacher())
            <x-responsive-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endif
            @endauth
        </div>

        <!-- Mobile profile section -->
        <div class="border-t border-gray-200 pt-4 pb-3">
            @auth
            <div class="flex items-center px-4">
                @if(Auth::user()->profile_picture)
                <img class="h-10 w-10 rounded-full object-cover"
                    src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" />
                @else
                <div
                    class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center text-white">
                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                @endif
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="w-full text-left">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endauth
        </div>
    </div>
</div>

<!-- Script to check route and toggle dropdown as needed -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check URLs to auto-expand appropriate sections
    const currentPath = window.location.pathname;

    // Check current path to determine which section to expand
    if (currentPath.includes('/courses') ||
        currentPath.includes('/program') ||
        currentPath.includes('/sections') ||
        currentPath.includes('/course_schedules')) {
        localStorage.setItem('expandedMenu', 'academic');
        localStorage.setItem('expandedMobileMenu', 'academic');
    }

    if (currentPath.includes('/admin/users') ||
        currentPath.includes('/assigned/teachers')) {
        localStorage.setItem('expandedMenu', 'users');
        localStorage.setItem('expandedMobileMenu', 'users');
    }
});
</script>