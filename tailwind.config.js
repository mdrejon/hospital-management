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
            // Responsive type + spacing scale for the public frontend. The values
            // live in resources/scss/abstracts/_tokens.scss (one row per token,
            // one column per device, separate Bangla rows) and reach here as
            // CSS custom properties written by resources/scss/base/_base.scss.
            // Edit the numbers there only — these entries just name the
            // utilities: text-h2, text-body, leading-heading, py-section, ...
            fontSize: {
                'hero-title': ['var(--fs-hero-title)', { lineHeight: 'var(--lh-display)' }],
                'hero-sub': ['var(--fs-hero-sub)', { lineHeight: 'var(--lh-heading)' }],
                'hero-text': ['var(--fs-hero-text)', { lineHeight: 'var(--lh-body)' }],
                'hero-btn': ['var(--fs-hero-btn)', { lineHeight: 'var(--lh-ui)' }],
                h1: ['var(--fs-h1)', { lineHeight: 'var(--lh-heading)' }],
                h2: ['var(--fs-h2)', { lineHeight: 'var(--lh-heading)' }],
                h3: ['var(--fs-h3)', { lineHeight: 'var(--lh-heading)' }],
                h4: ['var(--fs-h4)', { lineHeight: 'var(--lh-heading)' }],
                h5: ['var(--fs-h5)', { lineHeight: 'var(--lh-heading)' }],
                h6: ['var(--fs-h6)', { lineHeight: 'var(--lh-heading)' }],
                subheading: ['var(--fs-subheading)', { lineHeight: 'var(--lh-heading)' }],
                eyebrow: ['var(--fs-eyebrow)', { lineHeight: 'var(--lh-ui)' }],
                lead: ['var(--fs-lead)', { lineHeight: 'var(--lh-body)' }],
                body: ['var(--fs-body)', { lineHeight: 'var(--lh-body)' }],
                'body-sm': ['var(--fs-body-sm)', { lineHeight: 'var(--lh-body)' }],
                small: ['var(--fs-small)', { lineHeight: 'var(--lh-ui)' }],
                caption: ['var(--fs-caption)', { lineHeight: 'var(--lh-ui)' }],
                tiny: ['var(--fs-tiny)', { lineHeight: 'var(--lh-ui)' }],
                'btn-lg': ['var(--fs-btn-lg)', { lineHeight: 'var(--lh-ui)' }],
                btn: ['var(--fs-btn)', { lineHeight: 'var(--lh-ui)' }],
                'btn-sm': ['var(--fs-btn-sm)', { lineHeight: 'var(--lh-ui)' }],
                input: ['var(--fs-input)', { lineHeight: 'var(--lh-ui)' }],
                menu: ['var(--fs-menu)', { lineHeight: 'var(--lh-ui)' }],
                submenu: ['var(--fs-submenu)', { lineHeight: 'var(--lh-ui)' }],
            },
            lineHeight: {
                display: 'var(--lh-display)',
                heading: 'var(--lh-heading)',
                body: 'var(--lh-body)',
                ui: 'var(--lh-ui)',
            },
            spacing: {
                section: 'var(--space-section)',
                'section-sm': 'var(--space-section-sm)',
                'section-gap': 'var(--space-section-gap)',
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
                    cyan: 'rgb(var(--color-secondary) / <alpha-value>)',
                    green: 'rgb(var(--color-accent-green) / <alpha-value>)',
                    red: 'rgb(var(--color-accent-red) / <alpha-value>)',
                    primary: 'rgb(var(--color-primary) / <alpha-value>)',
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
                    '2xl': '2rem',
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
