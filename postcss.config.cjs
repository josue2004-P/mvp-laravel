// postcss.config.cjs
module.exports = {
  plugins: {
    // ❌ Antes: 'tailwindcss': {},
    // ✅ Ahora: Usa el nombre del paquete de PostCSS que instalaste
    '@tailwindcss/postcss': {}, 
    'autoprefixer': {}, // Si lo dejaste instalado
  },
};