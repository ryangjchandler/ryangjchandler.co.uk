const defaults = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {},
    fontFamily: {
      mono: [
        'Fira Code',
        ...defaults.fontFamily.mono
      ]
    }
  },
  variants: {},
  plugins: [],
}
