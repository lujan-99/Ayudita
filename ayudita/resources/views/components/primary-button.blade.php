<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-full border border-transparent bg-primary px-5 py-3 text-xs font-semibold uppercase tracking-widest text-black transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:ring-offset-0']) }}>
    {{ $slot }}
</button>
