const defaults = require('tailwindcss/defaultTheme')

module.exports = {
    experimental: 'all',
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: [
        './resources/views/**/*.blade.php'
    ],
    theme: {
        extend: {
            fontFamily: {
                mono: [
                    'Fira Code',
                    ...defaults.fontFamily.mono
                ]
            },
            colors: {
                'brand-primary': {
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
                primary: {
                    light: "#99CAFF",
                    default: "#007AFF",
                    dark: "#003773",
                },
            },
            screens: {
                'print': {
                    'raw': 'print'
                }
            }
        },
    },
    variants: {},
    plugins: [
        require('kutty')
    ],
}
