const webpack = require('webpack');
const { merge } = require('webpack-merge');
const path = require('path');
const dev = require('./webpack.js');

module.exports = merge(dev, {

	devServer: {
		hot: true,
		port: 1080,
		static:__dirname + "/public/js",
		historyApiFallback: true,
		
		/**
		 * This makes sure the main entrypoint is written to disk so it is
		 * loaded by Nextcloud though our existing addScript calls
		 */

		devMiddleware:{
			writeToDisk: true,
			
		},
		headers: {
			'Access-Control-Allow-Origin': '*'
		}
	},
	plugins: [
		new webpack.DefinePlugin({
			'process.env.HOT': true
		})
	],
	mode: 'development',
})
