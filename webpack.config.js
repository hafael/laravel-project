const path = require('path');
const webpack = require('webpack');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
        fallback: {
            'crypto': require.resolve('crypto-browserify'),
            'stream': require.resolve('stream-browserify'),
        }
    },
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false
        })
    ]
};
