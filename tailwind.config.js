import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // Public hospital frontend (resources/scss, resources/views/frontend)
                // uses Poppins — namespaced separately so it doesn't affect the
                // admin panel's font-sans.
                poppins: ['Poppins', 'Hind Siliguri', 'SolaimanLipi', 'Kalpurush', 'SutonnyOMJ', 'SutonnyMJ', 'Segoe UI', 'sans-serif'],
            },
            colors: {
                // Values come from CSS custom properties defined once in
                // resources/scss/base/_base.scss (:root), themselves generated
                // from resources/scss/abstracts/_variables.scss. Edit the values
                // there only — not here. rgb(var(...) / <alpha-value>) keeps
                // opacity modifiers (e.g. bg-navy/90) working since the custom
                // properties hold raw "R G B" channels rather than a hex string.
                navy: {
                    DEFAULT: 'rgb(var(--color-navy) / <alpha-value>)',
                    dark: 'rgb(var(--color-navy-dark) / <alpha-value>)',
                },
                brand: {
                    cyan: 'rgb(var(--color-primary) / <alpha-value>)',
                    green: 'rgb(var(--color-accent-green) / <alpha-value>)',
                    red: 'rgb(var(--color-accent-red) / <alpha-value>)',
                },
                footer: {
                    bg: 'rgb(var(--color-secondary) / <alpha-value>)',
                },
                muted: 'rgb(var(--color-text-muted) / <alpha-value>)',
            },
            screens: {
                // Precise mapping aligned with responsive breakdown table:
                // Mobile: 320px - 575px
                // Small Tablet: 576px - 767px
                // Tablet: 768px - 991px
                // Laptop: 992px - 1199px
                // Desktop: 1200px - 1399px
                // Large Desktop: 1400px - 1919px
                // Big Screen / 2K+: 1920px - Unlimited (2K: 2560px, 4K: 3840px)
                'xs': '480px',
                'sm': '576px',
                'md': '768px',
                'lg': '992px',
                'xl': '1200px',
                '2xl': '1400px',
                '3xl': '1600px',
                '2k': '1920px',
                'qhd': '2560px',
                '4k': '3840px',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '1.25rem',
                    md: '1.5rem',
                    lg: '2rem',
                    xl: '2rem',
                    '2xl': '2.5rem',
                    '3xl': '2.5rem',
                    '2k': '2.5rem',
                    'qhd': '3rem',
                    '4k': '3.5rem',
                },
                screens: {
                    sm: '540px',
                    md: '720px',
                    lg: '960px',
                    xl: '1140px',
                    '2xl': '1340px',
                    '3xl': '1520px',
                    '2k': '1720px',
                    'qhd': '2160px',
                    '4k': '2560px',
                },
            },
        },
    },

    plugins: [forms],
};
