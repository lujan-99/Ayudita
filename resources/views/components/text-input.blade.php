@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-2xl border border-outline-variant bg-surface-container px-4 py-3 text-foreground shadow-[0_10px_30px_rgba(0,0,0,0.18)] placeholder:text-muted/70 focus:border-primary focus:ring-2 focus:ring-primary/30']) }}>
