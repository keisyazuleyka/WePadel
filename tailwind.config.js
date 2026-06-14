import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: '#8eff4c',
                    dark: '#76e53d',
                    light: '#a9ff78',
                },
                padel: {
                    bg: '#080d07',
                    card: '#111a0e',
                    input: '#182614',
                    border: '#20331a',
                    muted: '#6f806a',
                }
            }
        },
    },

    plugins: [forms],
};
