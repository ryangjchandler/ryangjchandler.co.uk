const defaults = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {},
    fontFamily: {
      mono: [
        'Fira Code',
        ...defaults.fontFamily.mono
      ],
      sans: [
        'Inter',
        ...defaults.fontFamily.sans
      ]
    }
  },
  variants: {},
  plugins: [],
}
