const defaultTheme = require('tailwindcss/defaultTheme');
// const { iconsPlugin, dynamicIconsPlugin } = require("@egoist/tailwindcss-icons")
const { iconsPlugin, getIconCollections } = require("@egoist/tailwindcss-icons");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/preline/dist/*.js',//追加
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('preline/plugin'),//追加
        iconsPlugin({
            // 利用したい icon collection を利用する
            // https://icones.js.org/
            collections: getIconCollections("all"),
        }),

        // iconsPlugin(), dynamicIconsPlugin(),
        
        // iconsPlugin({
        //     // Select the icon collections you want to use
        //     // You can also ignore this option to automatically discover all individual icon packages you have installed
        //     // If you install @iconify/json, you should explicitly specify the collections you want to use, like this:
        //     // collections: getIconCollections(["mdi", "lucide"]),
        //     // If you want to use all icons from @iconify/json, you can do this:
        //     collections: getIconCollections("all"),
        //     // and the more recommended way is to use `dynamicIconsPlugin`, see below.
        // }),//追加
    ],
};


// module.exports = {
//     content: [
//         'node_modules/preline/dist/*.js',
//     ],
//     plugins: [
//         require('preline/plugin'),
//     ],
// }
