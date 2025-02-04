import preset from "./vendor/filament/support/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    plugins: [require("flowbite/plugin")],
    darkMode: "class",
    theme: {
        colors: {
            "vintage-light": "#EEEDEB",
            "vintage-cream": "#E0CCBE",
            "vintage-brem": "#747264",
            "vintage-dark": "#3C3633",
        },
    },
};
