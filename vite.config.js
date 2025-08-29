// import { defineConfig } from "vite";
// import laravel from "laravel-vite-plugin";

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: [
//                 "resources/css/app.css",
//                 "resources/js/app.js",
//                 // "resources/css/home.css",
//                 // "resources/js/home.js",
//             ],
//             refresh: true,
//         }),
//     ],
// });
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { sync } from "glob";       // đồng bộ để lấy file
import path from "path";

// Lấy tất cả file JS trong resources/js/pages
const jsPages = sync("resources/js/pages/**/*.js");
const jsModals = sync("resources/js/modals/**/*.js");
const jsComponents = sync("resources/js/component/**/**/**/**/**/*.js");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                ...jsPages,   // tự add tất cả file JS trong pages
                ...jsModals,
                ...jsComponents,
            ],
            refresh: true,
        }),
    ],
});
