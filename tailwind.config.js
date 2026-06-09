import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                background: '#121414',
                'on-background': '#e2e2e2',
                'on-surface': '#e2e2e2',
                'on-surface-variant': '#cfc2d6',
                surface: '#121414',
                'surface-container': '#1a1c1c',
                'surface-container-strong': '#1e2020',
                'surface-container-low': '#1a1c1c',
                'surface-container-lowest': '#0c0f0f',
                'surface-container-high': '#282a2b',
                'surface-container-highest': '#333535',
                'surface-variant': '#333535',
                'outline-variant': '#27272a',
                primary: '#ddb7ff',
                'on-primary': '#490080',
                'primary-container': '#b76dff',
                outline: '#988d9f',
                'primary-fixed': '#f0dbff',
                'primary-fixed-dim': '#ddb7ff',
                'inverse-primary': '#842bd2',
                'surface-tint': '#ddb7ff',
                foreground: '#e2e2e2',
                muted: '#a6a6a6',
                secondary: '#c8c6c8',
                'secondary-container': '#474649',
                'secondary-fixed': '#e5e1e4',
                'secondary-fixed-dim': '#c8c6c8',
                tertiary: '#c8c6c9',
                'tertiary-container': '#919094',
                'tertiary-fixed': '#e4e1e5',
                'tertiary-fixed-dim': '#c8c6c9',
                error: '#ffb4ab',
                'error-container': '#93000a',
            },
            spacing: {
                'margin-mobile': '1.25rem',  /* 20px */
                'margin-desktop': '2.5rem',  /* 40px */
                'gutter': '1.5rem',          /* 24px */
                'bento-gap': '1.5rem',       /* 24px */
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
