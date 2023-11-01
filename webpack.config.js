const path = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");

module.exports={
    mode: "development",
    entry: "./index.js",
    devtool: 'inline-source-map', // 'eval-source-map
    output: {
        path: path.resolve(__dirname, "public"),
        filename: "main.js",
        publicPath: "/",
    },
    target: "web",
    devServer: {
        port: "9500",
        static: ["./public"],
        open: true,
        hot: true,
        liveReload: true,
        historyApiFallback: true,
    },
    resolve: {
        extensions: ['.js','.jsx','.json']
    },
    module:{
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use:  'babel-loader'
            },
            {
                test: /(\.css$)|(\.scss$)/i,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader',
                ],
            },
        ]
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: "./index.html"
        }),
    ],
}