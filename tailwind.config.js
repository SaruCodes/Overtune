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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            height: {
                '10v': '10vh',
                '15v': '15vh',
                '65v': '65vh',
            },
            colors: {
                header: '#783F8E',
                nav: '#4f1271',
                main: '#f4eeff',
                footer: '#33094a',
                'text-dark': '#141414',
                text: '#141414',
            },
        },
    },

    plugins: [forms, require('daisyui')],

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: '#783F8E',
                    secondary: '#f18701',
                    accent: "#F35B04", //
                    neutral: '#33094a',
                    'base-100': '#ffffff',
                    'base-content': '#222222',
                },
            },
        ],
        darkTheme: 'dark',
    },
};
