const Encore = require('@symfony/webpack-encore');
const config = require('dotenv').config().parsed;
const path = require('path');

Encore
    .setOutputPath('web/build/')
    .setPublicPath(config.WEBPACK_PUBLIC_PATH)
    .cleanupOutputBeforeBuild()

    .enableReactPreset()
    .enableSassLoader()
    .addEntry('app', ['./web-assets/SparePartsApp.jsx'])
    .addStyleEntry('tags_style', [
        './node_modules/react-tagsinput/react-tagsinput.css'
    ])
    .addLoader({
        test: /\.(graphql|gql)$/,
        exclude: /node_modules/,
        loader: 'graphql-tag/loader',
    })
    .addLoader({
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: 'babel-loader',
        query: {
            presets:[ 'react', 'stage-2' ]
        }
    })
    .enableSourceMaps(!Encore.isProduction())

;

const webpackConfig = Encore.getWebpackConfig();
webpackConfig.resolve.alias = {
};
module.exports = webpackConfig;
