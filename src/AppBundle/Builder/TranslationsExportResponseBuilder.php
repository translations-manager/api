<?php

namespace AppBundle\Builder;

use AppBundle\Entity\Translation;

class TranslationsExportResponseBuilder
{
    /**
     * @param Translation[] $translations
     *
     * @return array
     */
    public function build($translations)
    {
        $out = [];

        foreach ($translations as $translation) {
            $path = $translation->getPhrase()->getFileLocation()->getPath();
            $domain = $translation->getPhrase()->getDomain()->getName();
            $locale = $translation->getLocale()->getCode();
            if (!array_key_exists($path, $out)) {
                $out[$path] = [];
            }
            if (!array_key_exists($domain, $out[$path])) {
                $out[$path][$domain] = [];
            }
            if (!array_key_exists($locale, $out[$path][$domain])) {
                $out[$path][$domain][$locale] = [];
            }

            $out[$path][$domain][$locale][] = [
                'key' => $translation->getPhrase()->getKey(),
                'translation' => $translation->getContent()
            ];
        }

        return $out;
    }
}
