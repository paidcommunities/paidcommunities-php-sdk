const path = require('path');
const glob = require('glob');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const {kebabCase} = require('lodash');
const fs = require("fs");
const {
    requestToHandle,
    requestToExternal
} = require('./bin/webpack-helpers');

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
        library: ['paidcommunities', '[name]'],
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
            requestToExternal: requestToExternal,
            requestToHandle: requestToHandle
        }),
    ],
    /*optimization: {
        splitChunks: {
            cacheGroups: {
                commons: {
                    name: `admin-commons`,
                    chunks: 'all',
                }
            },
        }
    }*/
}

const paidcommunities = {
    ...defaults,
    entry: {
        paidcommunitiesApi: path.resolve(__dirname, 'assets/js/paidcommunities-api')
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: (chunkData) => {
            return `${kebabCase(chunkData.chunk.name)}.js`
        },
        library: {
            name: ['paidcommunities', 'wp', 'api'],
            type: 'this'
        }
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
        }),
    ],
}

const styling = {
    ...defaults,
    entry: {
        styles: glob.sync('./assets/css/**/*.{css,scss}')
    },
    output: {
        path: path.resolve(__dirname, './build')
    },
    module: {
        rules: [
            {
                test: /\.?scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: () => {
                return '[name].css';
            }
        }),
        new WebpackRTLPlugin({
            filename: '[name]-rtl.css',
            minify: {
                safe: true
            }
        }),
        {
            apply(compiler) {
                compiler.hooks.afterEmit.tap('afterEmit', this.deleteFiles.bind(this));
            },
            deleteFiles() {
                let files = glob.sync('./build/css/style.js');
                files.forEach(file => {
                    fs.unlink(file, (err) => {
                        if (err) {
                            console.log(`error removing file ${file}.`, err);
                        }
                    })
                })
            }
        }
        //new RemoveFilePlugin('./packages/blocks/build/styles.js')
    ],
    optimization: {
        minimizer: [
            new CssMinimizerPlugin()
        ]
    },

}

module.exports = [javascript, paidcommunities, styling];

