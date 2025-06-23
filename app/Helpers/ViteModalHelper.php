<?php

namespace App\Helpers;

class ViteModalHelper
{
    public static function getModalAssets()
    {
        $modalDir = resource_path('js/modals');
        $files = glob($modalDir . '/*.js');
        $assets = [];

        foreach ($files as $file) {
            $basename = basename($file, '.js');
            $assets[$basename] = 'resources/js/modals/' . $basename . '.js';
        }
        return $assets;
    }
}
    