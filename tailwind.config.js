/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html", "./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        // Values come from CSS custom properties defined once in
        // src/scss/base/_base.scss (:root), themselves generated from
        // src/scss/abstracts/_variables.scss. Edit the values in
        // _variables.scss only — not here.
        // rgb(var(...) / <alpha-value>) keeps opacity modifiers
        // (e.g. bg-navy/90) working since the custom properties hold
        // raw "R G B" channels rather than a hex string.
        navy: {
          DEFAULT: "rgb(var(--color-navy) / <alpha-value>)",
          dark: "rgb(var(--color-navy-dark) / <alpha-value>)",
        },
        brand: {
          cyan: "rgb(var(--color-primary) / <alpha-value>)",
        },
        footer: {
          bg: "rgb(var(--color-secondary) / <alpha-value>)",
        },
        muted: "rgb(var(--color-text-muted) / <alpha-value>)",
      },
      fontFamily: {
        sans: ["Poppins", "Segoe UI", "sans-serif"],
      },
      container: {
        center: true,
        padding: {
          DEFAULT: "1rem",
          lg: "1rem",
        },
        screens: {
          sm: "640px",
          md: "768px",
          lg: "1024px",
          xl: "1140px",
        },
      },
    },
  },
  plugins: [],
};
