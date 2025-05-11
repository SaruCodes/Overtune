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

            height:{
                "10v":"10vh",
                "15v":"15vh",
                "65v":"65vh"
            },

            colors: {
                "header":"#2e0059",
                "nav":"#2e0059",
                "main":"#f4eeff",
                "footer":"#130630",
                "text-dark": "#111111",
                "text": "#141414"
            },
        },
    },
    plugins: [forms, require("daisyui")],
};
