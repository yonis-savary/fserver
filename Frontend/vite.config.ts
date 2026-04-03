import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite';
import { PrimeVueResolver } from '@primevue/auto-import-resolver';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
  // Charge les variables d'env en fonction du mode (development, production, etc.)
  const env = loadEnv(mode, process.cwd(), '')

  return {
    server: {
      host: '0.0.0.0',
      port: 5173,
      allowedHosts: [env.VITE_ALLOWED_HOST || 'localhost']
    },
    envDir: "..",
    plugins: [
      vue(),
      Components({
        resolvers: [
          PrimeVueResolver()
        ]
      }),
      tailwindcss()
    ],
  }
})
