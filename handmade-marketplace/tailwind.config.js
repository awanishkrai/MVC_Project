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
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                craft: {
                    50: '#fdf8f3',
                    100: '#f9ede0',
                    200: '#f2d9bd',
                    300: '#e8bf94',
                    400: '#dd9f66',
                    500: '#d48244',
                    600: '#c66a38',
                    700: '#a55330',
                    800: '#85442d',
                    900: '#6c3927',
                },
            },
            boxShadow: {
                craft: '0 4px 24px -4px rgba(108, 57, 39, 0.12), 0 8px 16px -8px rgba(108, 57, 39, 0.08)',
                'craft-lg': '0 12px 40px -8px rgba(108, 57, 39, 0.18)',
            },
            animation: {
                'fade-up': 'fadeUp 0.5s ease-out forwards',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
