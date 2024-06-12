import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { glob } from "glob";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                ...glob.sync("resources/js/custom/*.js"),
                ...glob.sync("resources/scss/*.sccss"),
                "resources/scss/show.scss",
                "resources/scss/table.scss",
            ],
            refresh: true,
        }),
    ],
});
