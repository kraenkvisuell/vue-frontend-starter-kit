module.exports = {
    future: {
        hoverOnlyWhenSupported: true,
    },
    content: [
        './resources/**/*.antlers.html',
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './content/**/*.md',
    ],
    theme: {
        fontFamily: {
            body: ['Outfit', 'ui-sans-serif', 'system-ui'],
        },
        fontSize: {
            'copy-2xs': '10px',
            'copy-xs': '12px',
            'copy-sm': '14px',
            'copy-base': '16px',
            'copy-lg': '18px',
            'copy-xl': '22px',
            'copy-2xl': '28px',

            'headline-3xs': '13px',
            'headline-2xs': '14px',
            'headline-xs': '16px',
            'headline-sm': '18px',
            'headline-base': '25px',
            'headline-lg': '30px',
            'headline-xl': '36px',
            'headline-2xl': '48px',
            'headline-3xl': '60px',
        },
        extend: {
            colors: {
                darkest: '#000000',
                black: '#292C28',
                white: '#FFFFFF',
                'gray-100': '#F4F4F4',
                'gray-200': '#e9eaed',
                'gray-300': '#d0d2d7',
                'gray-400': '#bdbfc4',
                'gray-600': '#8E8F92',
                'gray-800': '#595A58',
                'green-300': '#9FC141',
                highlight: '#4B8860',
                error: '#cc0000',
            },
            letterSpacing: {
                wide: '0.05em',
                wider: '0.08em',
                widest: '0.15em',
            },
            lineHeight: {
                'tightest': '1.05em',
                'normal': '1.7em',
            },
            height: {
                'dialog-img': 'calc(100vh - 60px)',
                'popup': 'calc(100vh - 20px)',
                'md-popup': 'calc(100vh - 60px)',
                'shopnavi': 'calc(100vh - 86px)',
                icon: '32px',
            },
            padding: {
                'bottom-of-slides': 'calc(100vh - 436px)',
            },
            maxHeight: theme => theme('height'),
            width: {
                icon: '32px',
            },
            boxShadow: {
                '3xl': '0 0 40px 30px rgba(0, 0, 0, 0.07)',
                'reverse': '0 -3px 6px 0 rgba(0, 0, 0, 0.07)',

            },
            screens: {
                'xs': '500px',
            },
            borderRadius: {
                DEFAULT: '3px',
            },
            animation: {
                cart: 'cart .6s ease-out',
                cartnumber: 'cartnumber .6s ease-in-out',
                cartping: 'cartping .6s cubic-bezier(0, 0, 0.2, 1) infinite',
            },
            keyframes: {
                cart: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '20%': { transform: 'scale(1)' },
                    '60%': { transform: 'scale(1.8)' },
                    '80%': { transform: 'scale(1.8)' },
                },
                cartnumber: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '30%': { transform: 'scale(2)' },
                    '80%': { transform: 'scale(2)' },
                },
                cartping: {
                    '75%, 100%': { transform: 'scale(3)', opacity: 0 },
                },
            },
            containers: {
                'card-sm': '150px',
                'card-md': '180px',
                'card-lg': '210px',
                'card-xl': '240px',
                'card-2xl': '270px',
                'card-3xl': '300px',
                'card-4xl': '330px',
                'card-5xl': '360px',
                'card-6xl': '410px',
                'card-7xl': '440px',
                'card-8xl': '470px',
                'card-9xl': '500px',

                'medium-sm': '450px',
                'medium-md': '600px',
                'medium-lg': '750px',
                'medium-xl': '900px',
                'medium-2xl': '1050px',
                'medium-3xl': '1200px',
            },
        },
    },
    safelist: [
        {
            pattern: /aspect-(w|h)-(1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20)/,
        },
        {
            pattern: /object-(bottom|center|left|right|top)/,
        },
        {
            pattern: /object-(left|right)-(bottom|top)/,
        },
    ],
    corePlugins: {
        aspectRatio: false,
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/container-queries'),
    ],
}
