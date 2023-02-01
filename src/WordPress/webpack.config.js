const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const {kebabCase} = require('lodash');

const env = process.env.NODE_ENV || 'development';
const isDev = env === 'development';

const defaults = {
    watch: isDev,
    watchOptions: {
        ignored: /node_modules/,
        poll: 5000 //5 secs
    },
    devtool: 'source-map'
}

const javascript = {
    ...defaults,
    entry: {
        licenseSettings: path.resolve(__dirname, 'assets/js/license-settings')
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: (chunkData) => {
            return `${kebabCase(chunkData.chunk.name)}.js`
        },
        library: ['wcPPCP', '[name]'],
        libraryTarget: 'this'
    },
    module: {
        rules: [
            {
                test: /\.m?jsx?$/,
                resolve: {
                    fullySpecified: false
                },
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        cacheDirectory: true,
                        presets: [
                            [
                                '@babel/preset-env',
                                {
                                    modules: false,
                                    targets: {
                                        browsers: [
                                            'extends @wordpress/browserslist-config'
                                        ]
                                    }
                                }
                            ]
                        ],
                        plugins: [
                            require.resolve('@babel/plugin-proposal-object-rest-spread'),
                            require.resolve('@babel/plugin-proposal-async-generator-functions'),
                            require.resolve('@babel/plugin-transform-runtime'),
                            require.resolve('@babel/plugin-proposal-class-properties'),
                        ]
                    }
                }
            },
            {
                test: /\.s?css$/,
                use: {
                    loader: 'ignore-loader',
                }
            }
        ]
    },
    plugins: [
        new DependencyExtractionWebpackPlugin({
            injectPolyfill: true,
            //requestToExternal: requestToExternal,
            //requestToHandle: requestToHandle
        }),
    ],
    optimization: {
        splitChunks: {
            cacheGroups: {
                commons: {
                    name: `admin-commons`,
                    chunks: 'all',
                }
            },
        }
    }
}

module.exports = [javascript];

