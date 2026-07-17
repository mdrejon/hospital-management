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
                poppins: ['Poppins', 'Segoe UI', 'sans-serif'],
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
                },
                footer: {
                    bg: 'rgb(var(--color-secondary) / <alpha-value>)',
                },
                muted: 'rgb(var(--color-text-muted) / <alpha-value>)',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    lg: '1rem',
                },
                screens: {
                    sm: '640px',
                    md: '768px',
                    lg: '1024px',
                    xl: '1140px',
                },
            },
        },
    },

    plugins: [forms],
};
