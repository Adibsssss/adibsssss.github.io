@props(['href', 'active'])

@php
$classes = ($active ?? false)
? 'flex items-center px-2 py-2 text-sm font-medium rounded-md bg-gradient-to-r from-indigo-50 to-purple-50
text-indigo-700 border-l-4 border-indigo-500'
: 'flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-700
transition';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>