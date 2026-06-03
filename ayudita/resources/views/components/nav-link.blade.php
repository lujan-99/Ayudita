@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-full border border-primary px-4 py-2 text-sm font-medium leading-5 text-primary focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-full border border-transparent px-4 py-2 text-sm font-medium leading-5 text-muted hover:border-outline-variant hover:text-foreground focus:outline-none focus:text-foreground transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
