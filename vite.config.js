import { defineConfig,loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader';

import fs from 'fs';
import { homedir } from 'os';
import { resolve } from 'path';
import {fileURLToPath} from 'url';

function detectServerConfig(mode) {
  // Load current .env-file
  const env = loadEnv(mode, process.cwd(), '');

  // we skip if no url
  if (!env.APP_URL) {
    return {};
  }

  // Set the host based on APP_URL
  let host = new URL(env.APP_URL).host;

  let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`);
  let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`);

  if (!fs.existsSync(keyPath)) {
    return {};
  }

  if (!fs.existsSync(certificatePath)) {
    return {};
  }

  return {
    hmr: { host },
    host,
    https: {
      key: fs.readFileSync(keyPath),
      cert: fs.readFileSync(certificatePath),
    },
  };
}

export default defineConfig(({ mode }) => ({
    server: detectServerConfig(mode),
    resolve: {
      alias: {
        '@': '/resources/js',
        '@icons': fileURLToPath(new URL('node_modules/@shopify/polaris-icons/dist/svg', import.meta.url)),
      },
      extensions: ['.gql', '.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue'],
    },
    plugins: [
        svgLoader(),
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
}));
