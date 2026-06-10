import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                background: 'var(--color-background)',
                'on-background': 'var(--color-on-background)',
                'on-surface': 'var(--color-on-surface)',
                'on-surface-variant': 'var(--color-on-surface-variant)',
                surface: 'var(--color-surface)',
                'surface-container': 'var(--color-surface-container)',
                'surface-container-strong': 'var(--color-surface-container-strong)',
                'surface-container-low': 'var(--color-surface-container-low)',
                'surface-container-lowest': 'var(--color-surface-container-lowest)',
                'surface-container-high': 'var(--color-surface-container-high)',
                'surface-container-highest': 'var(--color-surface-container-highest)',
                'surface-variant': 'var(--color-surface-variant)',
                'outline-variant': 'var(--color-outline-variant)',
                primary: 'var(--color-primary)',
                'on-primary': 'var(--color-on-primary)',
                'primary-container': 'var(--color-primary-container)',
                outline: 'var(--color-outline)',
                'primary-fixed': 'var(--color-primary-fixed)',
                'primary-fixed-dim': 'var(--color-primary-fixed-dim)',
                'inverse-primary': 'var(--color-inverse-primary)',
                'surface-tint': 'var(--color-surface-tint)',
                foreground: 'var(--color-foreground)',
                muted: 'var(--color-muted)',
                secondary: 'var(--color-secondary)',
                'secondary-container': 'var(--color-secondary-container)',
                'secondary-fixed': 'var(--color-secondary-fixed)',
                'secondary-fixed-dim': 'var(--color-secondary-fixed-dim)',
                tertiary: 'var(--color-tertiary)',
                'tertiary-container': 'var(--color-tertiary-container)',
                'tertiary-fixed': 'var(--color-tertiary-fixed)',
                'tertiary-fixed-dim': 'var(--color-tertiary-fixed-dim)',
                error: 'var(--color-error)',
                'error-container': 'var(--color-error-container)',
            },
            spacing: {
                'margin-mobile': '1.25rem',  /* 20px */
                'margin-desktop': '2.5rem',  /* 40px */
                'gutter': '1.5rem',          /* 24px */
                'bento-gap': '1.5rem',       /* 24px */
                'section-padding-desktop': '7.5rem', /* 120px */
            },
            borderRadius: {
                'DEFAULT': '0.5rem',         /* 8px */
            },
            maxWidth: {
                'container-max': '1280px',
            },
            fontFamily: {
                sans: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
                'body-lg': ['Geist', ...defaultTheme.fontFamily.sans],
                'body-sm': ['Geist', ...defaultTheme.fontFamily.sans],
                'headline-md': ['Geist', ...defaultTheme.fontFamily.sans],
                'headline-lg': ['Geist', ...defaultTheme.fontFamily.sans],
                'headline-lg-mobile': ['Geist', ...defaultTheme.fontFamily.sans],
                display: ['Geist', ...defaultTheme.fontFamily.sans],
                'label-mono': ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            fontSize: {
                'body-lg': ['16px', { lineHeight: '1.6', letterSpacing: '0', fontWeight: '400' }],
                'body-sm': ['14px', { lineHeight: '1.5', letterSpacing: '0', fontWeight: '400' }],
                'headline-md': ['24px', { lineHeight: '1.3', letterSpacing: '-0.01em', fontWeight: '500' }],
                'headline-lg': ['32px', { lineHeight: '1.2', letterSpacing: '-0.02em', fontWeight: '600' }],
                'headline-lg-mobile': ['24px', { lineHeight: '1.2', letterSpacing: '-0.02em', fontWeight: '600' }],
                display: ['56px', { lineHeight: '1.1', letterSpacing: '-0.04em', fontWeight: '600' }],
                'label-mono': ['12px', { lineHeight: '1.0', letterSpacing: '0.05em', fontWeight: '500' }],
            },
        },
    },

    plugins: [forms],
};
