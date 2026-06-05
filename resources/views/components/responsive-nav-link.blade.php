@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl border border-primary px-4 py-3 text-start text-base font-medium text-primary bg-black/20 focus:outline-none focus:text-primary transition duration-150 ease-in-out'
            : 'block w-full rounded-2xl border border-transparent px-4 py-3 text-start text-base font-medium text-muted hover:border-outline-variant hover:bg-black/10 hover:text-foreground focus:outline-none focus:text-foreground transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
