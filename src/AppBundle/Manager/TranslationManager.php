<?php

namespace AppBundle\Manager;

use AppBundle\Builder\TranslationsExportResponseBuilder;
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
}
