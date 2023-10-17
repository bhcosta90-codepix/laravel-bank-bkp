import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    plugins: [require('flowbite/plugin')],
    content: [
        "./node_modules/flowbite/**/*.js",
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
