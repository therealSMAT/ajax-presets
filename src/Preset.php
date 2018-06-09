<?php

namespace therealsmat\AjaxPreset;

use Illuminate\Foundation\Console\Presets\Preset as ConsolePreset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Preset extends ConsolePreset {

    public static function install()
    {
        static::cleanSassDirectory();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
        static::loadHelper();
    }

    public static function cleanSassDirectory()
    {
        File::cleanDirectory(resource_path('assets/sass'));
    }

    public static function updatePackageArray($packages)
    {
        return array_merge(['laravel-mix-tailwind' => '^0.1.0'], Arr::except($packages, [
            'popper.js',
            'lodash',
            'jquery'
        ]));
    }

    public static function updateMix()
    {
        copy(__DIR__.'/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    public static function updateScripts()
    {
        copy(__DIR__.'/stubs/app.js', resource_path('assets/js/app.js'));
        copy(__DIR__.'/stubs/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }

    private static function copyHelper()
    {
        copy(__DIR__.'/stubs/Helpers.php', app_path('Helpers.php'));
    }

    /**
     * Copy the Helper.php file
     */
    public static function loadHelper()
    {
        static::copyHelper();

        static::updateComposerFile();
    }

    /**
     * Update the composer.json file with our new helper file
     */
    private static function updateComposerFile()
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $autoload = $packages['autoload'];

        $packages['autoload'] = array_merge($autoload, [
            'files' => ['app/Helpers.php']
        ]);

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
