module.exports = {
    purge: [
        './resources/views/**/*.blade.php'
    ],
    theme: {
        extend: {
            colors: {
                'primary': {
                    100: '#E6F2FF',
                    200: '#BFDEFF',
                    300: '#99CAFF',
                    400: '#4DA2FF',
                    500: '#007AFF',
                    600: '#006EE6',
                    700: '#004999',
                    800: '#003773',
                    900: '#00254D',
                },
            }
        },
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms')
    ],
}
