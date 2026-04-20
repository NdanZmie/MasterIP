export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
// tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  safelist: [
    'bg-red-100', 'text-red-700',
    'bg-yellow-100', 'text-yellow-700',
    'bg-green-100', 'text-green-700',
    'bg-gray-100', 'text-gray-500',
  ],
  // ...
}