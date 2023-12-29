/** @type {import('tailwindcss').Config} */
module.exports = {
    prefix: 'dodocms-',
    content: ["./**/*.{html,js,php}"],
    theme: {
        extend: {
            toastStyles: {
                info: {
                    backgroundColor: 'gray',
                    backgroundShade: 600,
                    borderColor: 'gray',
                    borderShade: 500
                },
                error: {
                    backgroundColor: 'red',
                    backgroundShade: 800,
                    borderColor: 'gray',
                    borderShade: 700
                },
                warning: {
                    backgroundColor: 'orange',
                    backgroundShade: 800,
                    borderColor: 'gray',
                    borderShade: 700
                },
                success: {
                    backgroundColor: 'green',
                    backgroundShade: 800,
                    borderColor: 'gray',
                    borderShade: 700
                }
            }
        },
    },
    variants: {
        extend: {
            borderWidth: ['responsive', 'hover', 'focus'],
            borderColor: ['responsive', 'hover', 'focus', 'group-hover'],
        },
    },
    plugins: [
        function ({addUtilities, theme, variants}) {
            const toastStyles = theme('toastStyles', {});
            const utilities = {};

            const colors = theme('colors', {});

            Object.entries(toastStyles).forEach(([key, value]) => {
                utilities[`.toast-${key}`] = {
                    backgroundColor: colors[value.backgroundColor][value.backgroundShade],
                    border: '1px solid ',
                    borderColor: colors[value.borderColor][value.borderShade],
                };
            });
            console.log(utilities)

            addUtilities(utilities, variants('toastStyles'));
        },
    ],
}

