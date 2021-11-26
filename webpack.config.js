//Конфигурация webpack для проекта 3 сделанного на курсе WEB-разработка в Nordic IT School
'use strict';

const path = require('path');
const {
  CleanWebpackPlugin
} = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const mode = process.env.NODE_ENV;
const isDev = mode === 'development';

module.exports = {
  entry: './src/index.js',
  output: {
    filename: './[name].js',
    path: path.resolve(__dirname, 'js'),
    environment: {
      arrowFunction: true,
    },
    publicPath: '/project/project3',
  },
  mode,
  plugins: [
    new CleanWebpackPlugin({
      dry: false,
      verbose: true,
      cleanOnceBeforeBuildPatterns: [
        '**/*', //Удаление файлов относительно каталога output.path
        `${path.resolve(__dirname, 'css')}/*`,
      ],
    }),
    new MiniCssExtractPlugin({
      filename: '../css/styles.css',
    }),
  ],
  module: {
    rules: [{
        test: /\.js$/i,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
        exclude: '/node_modules/',
      },
      {
        test: /\.(c|sa|sc)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              url: false,
              sourceMap: isDev,
            },
          },
          'sass-loader',
        ]
      },
    ]
  },
  devtool: isDev && 'source-map',
};
