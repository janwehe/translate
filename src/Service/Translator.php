<?php

namespace App\Service;

use App\Entity\Origin;
use DeepL\AppInfo;
use DeepL\DeepLClient;

class Translator
{
    public function __construct(
        private string $deeplApiKey,
        private string $deeplAppInfoVersion
    ) {
    }

    /*
     * Translates an origin text to the chosen language
     */
    public function translate(Origin $origin, string $iso_code): string
    {
        $payload = [
            'txt' => $origin->getTxt(),
            'language_source' => $origin->getLanguage()->getIsoCode(),
            'language_target' => $iso_code
        ];

        // send request to DeepL
        $options = ['app_info' => new AppInfo('symfony-translator-app', $this->deeplAppInfoVersion)];
        $deeplClient = new DeepLClient($this->deeplApiKey, $options);

        try {
            $translation = $deeplClient->translateText(
                $payload['txt'],
                $payload['language_source'],
                $payload['language_target']
            );

            return $translation->text;
        }
        catch (\Exception $e) {
            throw new \Exception("Translation failed: " . $e->getMessage());
        }

    }
}