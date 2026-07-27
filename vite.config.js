import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'dist',
    emptyOutDir: true, // czyści dist przed każdym buildem
    rollupOptions: {
      input: 'assets/js/main.js',
      output: {
        entryFileNames: 'js/main.min.js',
        assetFileNames: 'css/main.min.[ext]',
      },
    },
  },
});