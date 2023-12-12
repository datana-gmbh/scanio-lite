/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './assets/**/*.js',
    './assets/**/*.vue',
    './templates/**/*.html.twig',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          25: '#dcf0f3',
          50: '#6d9db5',
          100: '#6095af',
          200: '#1F8696',
          300: '#00768d',
          400: '#006074',
          500: '#004b5a',
          600: '#003b46',
          700: '#003641',
          800: '#002127',
          900: '#000b0e',
        },
        secondary: '#F0C81A',
        green: {
          100: '#e6f5e6',
          200: '#ccf0cc',
          300: '#b3e6b3',
          400: '#99e099',
          500: '#80d980',
          600: '#66cc66',
          700: '#4db84d',
          800: '#33ad33',
          900: '#1a991a',
        },
      },
      extend: {
        transitionProperty: {
          height: 'height',
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
