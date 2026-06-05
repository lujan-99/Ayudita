<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-full border border-transparent bg-[#8f3b44] px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-[#a44651] active:bg-[#742d35] focus:outline-none focus:ring-2 focus:ring-[#ddb7ff]/30 focus:ring-offset-0']) }}>
    {{ $slot }}
</button>
