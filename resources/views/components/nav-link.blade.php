@props(['active'])

@php
$classes = ($active ?? false)
            ? 'active inline-flex w-full items-center gap-4 px-3 py-1 font-bold text-white text-xs font-medium leading-5 focus:outline-none bg-blue-800 uppercase rounded-3xl'
            : 'inline-flex w-full items-center gap-4 px-3 py-1 font-bold text-gray-700 text-xs font-medium leading-5 focus:outline-none uppercase ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
