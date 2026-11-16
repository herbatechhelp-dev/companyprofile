/** @type {import('tailwindcss').Config} */
export default {
    // Semua file yang memakai class Tailwind untuk halaman publik.
    // Class yang dirangkai dinamis (mis. 'bg-' + warna) TIDAK akan terdeteksi:
    // selalu tulis nama class lengkap di file-file ini.
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
