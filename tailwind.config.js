/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f4f6fb',
                    100: '#e7ebf6',
                    200: '#c7d1ea',
                    300: '#a2b2da',
                    400: '#7188c4',
                    500: '#4d67ab',
                    600: '#3a4f8b',
                    700: '#31406f',
                    800: '#2a375c',
                    900: '#26304d',
                },
                accent: {
                    50: '#fbf7f1',
                    100: '#f4ead9',
                    200: '#e6cfa9',
                    300: '#d6ac72',
                    400: '#c68d4b',
                    500: '#b3743a',
                    600: '#985c30',
                    700: '#7b482a',
                    800: '#663c27',
                    900: '#563322',
                },
            },
            fontFamily: {
                sans: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                soft: '0 2px 8px 0 rgba(38, 48, 77, 0.06), 0 1px 2px 0 rgba(38, 48, 77, 0.04)',
                card: '0 4px 16px 0 rgba(38, 48, 77, 0.08)',
            },
            borderRadius: {
                xl2: '1.25rem',
            },
        },
    },
    plugins: [],
};
