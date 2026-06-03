<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center rounded-full border border-outline-variant bg-surface-container px-4 py-2 text-xs font-semibold uppercase tracking-widest text-foreground shadow-sm transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-0 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
