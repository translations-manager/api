<?php

namespace AppBundle\Manager;

use AppBundle\Builder\TranslationsExportResponseBuilder;
use AppBundle\Entity\Domain;
use AppBundle\Entity\FileLocation;
use AppBundle\Entity\Locale;
use AppBundle\Entity\Translation;
use AppBundle\Repository\TranslationRepository;
use Doctrine\ORM\EntityManager;

class TranslationManager
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TranslationsExportResponseBuilder
     */
    private $translationsExportBuilder;

    /**
     * @param TranslationRepository $translationRepository
     * @param EntityManager $entityManager
     * @param TranslationsExportResponseBuilder $translationsExportResponseBuilder
     */
    public function __construct(
        TranslationRepository $translationRepository,
        EntityManager $entityManager,
        TranslationsExportResponseBuilder $translationsExportResponseBuilder
    ) {
        $this->translationRepository = $translationRepository;
        $this->entityManager = $entityManager;
        $this->translationsExportBuilder = $translationsExportResponseBuilder;
    }

    /**
     * @param Translation $translation
     */
    public function saveTranslation(Translation $translation)
    {
        $this->entityManager->persist($translation);
        $this->entityManager->flush();
    }

    /**
     * @param array $domainIds
     * @param array $locationIds
     * @param array $localeIds
     *
     * @return array
     */
    public function exportTranslations(array $domainIds, array $locationIds, array $localeIds)
    {
        $translations = $this->translationRepository->export($domainIds, $locationIds, $localeIds);

        return $this->translationsExportBuilder->build($translations);
    }

    /**
     * @param Domain $domain
     * @param FileLocation $fileLocation
     * @param Locale $locale
     *
     * @return Translation[]
     */
    public function getTranslationsForImport(Domain $domain, FileLocation $fileLocation, Locale $locale)
    {
        $translations = $this->translationRepository->findForImport($domain, $fileLocation, $locale);

        return array_combine(
            array_map(function(Translation $translation) {
                return $translation->getPhrase()->getKey();
            }, $translations),
            $translations
        );
    }
}
