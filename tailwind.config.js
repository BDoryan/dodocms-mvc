/** @type {import('tailwindcss').Config} */
module.exports = {
  prefix: 'dodocms-',
  content: ["./**/*.{html,js,php}"],
  theme: {
    extend: {},
  },
  variants: {
    extend: {
      borderWidth: ['responsive', 'hover', 'focus'],
      borderColor: ['responsive', 'hover', 'focus', 'group-hover'],
    },
  },
  plugins: [],
}

