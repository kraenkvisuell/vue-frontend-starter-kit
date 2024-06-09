const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './resources/**/*.{vue,js,ts,jsx,tsx}',
    ],
    theme: {
        colors: {
            transparent: 'transparent',
            black: '#000000',
            white: '#ffffff',
            current: 'currentColor',
            blue: {
                100: '#eaf5ff',
                200: '#abd9ff',
                300: '#82c5ff',
                DEFAULT: '#43a9ff',
                400: '#43a9ff',
                500: '#2e9fff',
                600: '#298fe6',
                700: '#257fcc',
                800: '#206fb3',
                900: '#175080',
            },
            gray: {
                100: '#fafcff',
                200: '#f5f8fc',
                300: '#eef2f6',
                400: '#dde3e9',
                500: '#c4ccd4',
                600: '#a7b3be',
                700: '#73808c',
                750: '#354248',
                775: '#2e393d',
                800: '#1c2e36',
                900: '#19292f',
                950: '#141a1f',
                DEFAULT: '#73808c',
            },
            orange: {
                light: '#fcc062',
                DEFAULT: '#f5a82f',
                dark: '#e08a1e',
            },
            pink: {
                light: '#ff5ba7',
                DEFAULT: '#ff269e',
                dark: '#e00095',
            },
            purple: {
                light: '#e0b7ff',
                DEFAULT: '#c471ed',
                dark: '#a855cd',
            },
            yellow: {
                light: '#ffffe0',
                DEFAULT: '#fbfab0',
                dark: '#e8dc1e',
            },
            amber: colors.amber,
            green: colors.green,
            red: colors.red,
        },
    },
    plugins: [],
}
