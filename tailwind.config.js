const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                light: {
                    // Define your light mode color palette here
                    primary: '#ffffff', // Example primary color
                    secondary: '#f0f0f0', // Example secondary color
                    // Add more colors as needed
                },
                dark: {
                    // Define your dark mode color palette here
                    primary: '#121212', // Example primary color
                    secondary: '#1a202c', // Example secondary color
                    // Add more colors as needed
                },
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
