import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  server: {
    host: '0.0.0.0',
    watch: {
      usePolling: true
    }
  },

  resolve: {
    alias: {
      '~': '/resources/js',
      '~images': '/resources/images',
      '~icons': '/resources/icons',
    }
  },

  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
          @use "./node_modules/bootstrap/scss/bootstrap.scss" as *;
          @use "./resources/scss/_variables.scss" as *;
        `,
      },
    },
  },

  plugins: [
    laravel({
      input: [
        'resources/scss/app.scss',
        'resources/js/app.js'
      ],
      refresh: true,
    }),

    vue({
      template: {
        transformAssetUrls: {
          // The Vue plugin will re-write asset URLs, when referenced
          // in Single File Components, to point to the Laravel web
          // server. Setting this to `null` allows the Laravel plugin
          // to instead re-write asset URLs to point to the Vite
          // server instead.
          base: null,

          // The Vue plugin will parse absolute URLs and treat them
          // as absolute paths to files on disk. Setting this to
          // `false` will leave absolute URLs un-touched so they can
          // reference assets in the public directory as expected.
          includeAbsolute: false,
        },
      },
    }),
  ],
});
