const Dotenv = require('dotenv-webpack');

module.exports = {
    configureWebpack: {
        plugins: [
            new Dotenv({
                path: __dirname + '/.env',
                safe: true,
                systemvars: true,
                silent: false
            })
        ]
    }
};