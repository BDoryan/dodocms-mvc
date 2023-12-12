/** @type {import('tailwindcss').Config} */
module.exports = {
  prefix: 'dodocms-',
  content: ["./**/*.{html,js,php}"],
  theme: {
    extend: {},
  },
  variants: {
    extend: {
      borderWidth: ['responsive', 'hover', 'focus'], // Importe les variantes pour les médias queries, le hover, et le focus
      borderColor: ['responsive', 'hover', 'focus', 'group-hover'], // Exemple avec les bordures de couleur
      // Ajoutez d'autres classes de bordure ou personnalisez selon vos besoins
    },
  },
  plugins: [],
}

