import { defineConfig } from 'vite';
import { resolve } from 'node:path';

export default defineConfig({
	build: {
		manifest: true,
		outDir: 'build',
		emptyOutDir: true,
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/js/main.js'),
				styles: resolve(__dirname, 'src/scss/main.scss'),
				editor: resolve(__dirname, 'src/scss/editor.scss'),
			},
			output: {
				entryFileNames: 'js/[name].[hash].js',
				chunkFileNames: 'js/[name].[hash].js',
				assetFileNames: (assetInfo) => {
					const name = assetInfo.name ?? '';
					if (name.endsWith('.css')) return 'css/[name].[hash][extname]';
					if (/\.(png|jpe?g|gif|svg|webp|avif)$/.test(name)) return 'images/[name].[hash][extname]';
					if (/\.(woff2?|ttf|otf|eot)$/.test(name)) return 'fonts/[name].[hash][extname]';
					return 'assets/[name].[hash][extname]';
				},
			},
		},
	},
	css: {
		preprocessorOptions: {
			scss: {
				api: 'modern-compiler',
			},
		},
	},
});
