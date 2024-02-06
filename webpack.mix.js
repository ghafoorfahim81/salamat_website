const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);

// Optional: If you're using Vue 3, include .vue() to enable Vue.js support
mix.vue();

// Optional: Set publicPath for asset versioning
// mix.setPublicPath('public');

// Optional: Customize asset versioning file name
// mix.versionFileName('my-version.json');

// Additional customization or asset compilation can be added here

// Example: Compile assets with versioning and source maps enabled
// mix.js('resources/js/app.js', 'public/js').vue()
//     .postCss('resources/css/app.css', 'public/css', [
//         require("tailwindcss"),
//     ]).version().sourceMaps();

// Example: Compile assets for production with minification and versioning
// if (mix.inProduction()) {
//     mix.js('resources/js/app.js', 'public/js').vue()
//         .postCss('resources/css/app.css', 'public/css', [
//             require("tailwindcss"),
//         ]).version();
// }
