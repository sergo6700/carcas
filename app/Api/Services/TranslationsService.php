<?php

namespace Api\Services;

/**
 * Class TranslationsService
 * @package Api\Services
 */
class TranslationsService
{
    /**
     * @return array
     */
    public function get()
    {
        $translations = [];

        $langPath = resource_path('lang' . DIRECTORY_SEPARATOR . 'en');

        foreach (glob($langPath . DIRECTORY_SEPARATOR . '*.php') as $filename) {
            $filename = basename($filename);
            $filename = str_replace('.php', '', $filename);

            $translations[$filename] = trans($filename);
        }

        return $translations;
    }
}
