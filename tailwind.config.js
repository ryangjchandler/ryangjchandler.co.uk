module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './storage/framework/views/*.php'
    ],
    darkMode: 'class',
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography')
    ],
}
