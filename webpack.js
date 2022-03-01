const path = require('path')
const webpack = require('webpack')
const webpackConfig = require('@nextcloud/webpack-vue-config')

webpackConfig.entry['main'] = path.join(__dirname, 'src', 'main.js');
webpackConfig.plugins.push(new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/));

webpackConfig.stats = {
	context: path.resolve(__dirname, 'src'),
	assets: true,
	entrypoints: true,
	chunks: true,
	modules: true,
}

module.exports = webpackConfig;


