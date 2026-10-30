/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{vue,js,ts,jsx,tsx}',
    ],
    // Explicitly disable backgroundImage gradients to enforce 100% solid colors
    corePlugins: {
        backgroundImage: false,
    },
    theme: {
        extend: {
            colors: {
                surface: {
                    canvas: '#F3F4F6',
                    'canvas-dark': '#0F141C',
                    card: '#FFFFFF',
                    'card-dark': '#18202C',
                    elevated: '#E5E7EB',
                    'elevated-dark': '#222D3D',
                    inverse: '#111827',
                },
                win: {
                    blue: '#0078D4',
                    'blue-active': '#005A9E',
                    'blue-dark': '#2899F5',
                    navy: '#002050',
                    'navy-dark': '#0A2E65',
                    gold: '#D4AF37',
                    'gold-active': '#B59024',
                    'gold-dark': '#E5C158',
                    amber: '#D83B01',
                    teal: '#008272',
                    'teal-dark': '#00B294',
                    green: '#107C10',
                    purple: '#5C2D91',
                    crimson: '#A80000',
                    slate: '#323130',
                },
            },
            borderRadius: {
                '3d-curve': '28px',
                '3d-asym': '36px 0px 36px 0px',
                '3d-asym-rtl': '0px 36px 0px 36px',
            },
            boxShadow: {
                'none': 'none',
                'solid-3d-navy': '6px 6px 0px #002050',
                'solid-3d-dark': '6px 6px 0px #090C10',
                'solid-3d-gold': '6px 6px 0px #D4AF37',
                'solid-3d-blue': '6px 6px 0px #0078D4',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', '"IBM Plex Sans Arabic"', '"Segoe UI"', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'monospace'],
            },
        },
    },
    plugins: [],
};
