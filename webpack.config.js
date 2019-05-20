let webpack = require('webpack');
let path = require('path');
const publicPath = '/';
const TerserJSPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

var config = {
	entry: './src/js/app.js',
	output: {
		// path: path.resolve(__dirname, 'dist'), 
		// filename: 'js/app.js',
		// publicPath: './dist/js'
		filename: 'js/[name].js',
	    path: path.resolve(__dirname, 'public'),
	    publicPath: publicPath,
	},
	optimization: {
    	minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  	},
	module: {
		rules: [
			{
				test: /\.(sa|sc|c)ss$/,
				use: [
				{
					loader: MiniCssExtractPlugin.loader,
					options: {
						publicPath: (resourcePath, context) => {
		                // publicPath is the relative path of the resource to the context
		                // e.g. for ./css/admin/main.css the publicPath will be ../../
		                // while for ./css/main.css the publicPath will be ../
		                return path.relative(path.dirname(resourcePath), context) + '/';
		              },
						hmr: process.env.NODE_ENV === 'development',
					},
				},
				"css-loader",
				"sass-loader"		    
				]
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					loaders: {
						// Since sass-loader (weirdly) has SCSS as its default parse mode, we map
						// the "scss" and "sass" values for the lang attribute to the right configs here.
						// other preprocessors should work out of the box, no loader config like this necessary.
						'scss': [
							'vue-style-loader',
							'css-loader',
							'sass-loader'
						],
						'sass': [
							'vue-style-loader',
							'css-loader',
							'sass-loader?indentedSyntax'
						]
					}
				}
			},
		]
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'css/[name].css',
			// chunkFilename: "[id].css"
		}),
		new VueLoaderPlugin()
	],
	resolve: {
	    alias: {
	      'vue$': 'vue/dist/vue.esm.js'
	    },
		extensions: ['*', '.js', '.vue', '.json']
	},
};

module.exports = (env, argv) => {

	if (argv.mode === 'development') {
		config.devtool = 'source-map';
	}

	if (argv.mode === 'production') {
    //...
	}

	return config;
};