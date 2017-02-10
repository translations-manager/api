<?php

namespace AppBundle\Builder;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\Translation;

class PhrasesResponseBuilder
{
    /**
     * @param Phrase[] $phrases
     * @param int[] $localeIds
     *
     * @return array
     */
    public function build($phrases, array $localeIds = [])
    {
        $out = [];

        foreach ($phrases as $phrase) {
            $translations = [];
            foreach ($localeIds as $localeId) {
                $translation = $this->retrieveTranslation($phrase, $localeId);
                $translations[] = [
                    'id' => $translation ? $translation->getId() : null,
                    'content' => $translation ? $translation->getContent() : null,
                    'locale' => $localeId
                ];
            }
            $out[] = [
                'id' => $phrase->getId(),
                'key' => $phrase->getKey(),
                'domain' => $phrase->getDomain()->getName(),
                'translations' => $translations
            ];
        }

        return $out;
    }

    /**
     * @param Phrase $phrase
     * @param int $localeId
     *
     * @return Translation|null
     */
    private function retrieveTranslation(Phrase $phrase, $localeId)
    {
        foreach ($phrase->getTranslations() as $translation) {
            if ($translation->getLocale()->getId() == $localeId) {
                return $translation;
            }
        }

        return null;
    }
}
