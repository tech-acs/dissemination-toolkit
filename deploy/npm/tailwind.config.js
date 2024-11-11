import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/ChartEditor/*.jsx'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'point-right': {
                    '0%, 100%': {
                        transform: 'translateX(-15%)',
                        'animation-timing-function': 'cubic-bezier(0.8, 0, 1, 1)'
                    },
                    '50%': {
                        transform: 'translateX(0)',
                        'animation-timing-function': 'cubic-bezier(0, 0, 0.2, 1)'
                    }
                },
                'point-left': {
                    '0%, 100%': {
                        transform: 'translateX(15%)',
                        'animation-timing-function': 'cubic-bezier(0.8, 0, 1, 1)'
                    },
                    '50%': {
                        transform: 'translateX(0)',
                        'animation-timing-function': 'cubic-bezier(0, 0, 0.2, 1)'
                    }
                }
            },
            animation: {
                'point-right': 'point-right 1s ease-in-out infinite',
                'point-left': 'point-left 1s ease-in-out infinite',
            }
        },
    },

    plugins: [forms, typography],
};
