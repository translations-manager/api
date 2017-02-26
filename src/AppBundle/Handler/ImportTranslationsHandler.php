<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\Translation;
use AppBundle\Manager\DomainManager;
use AppBundle\Manager\FileLocationManager;
use AppBundle\Manager\LocaleManager;
use AppBundle\Manager\PhraseManager;
use AppBundle\Manager\ProjectManager;
use AppBundle\Manager\TranslationManager;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImportTranslationsHandler
{
    /**
     * @var ProjectManager
     */
    private $projectManager;

    /**
     * @var DomainManager
     */
    private $domainManager;

    /**
     * @var FileLocationManager
     */
    private $fileLocationManager;

    /**
     * @var LocaleManager
     */
    private $localeManager;

    /**
     * @var PhraseManager
     */
    private $phraseManager;

    /**
     * @var TranslationManager
     */
    private $translationsManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param ProjectManager $projectManager
     * @param DomainManager $domainManager
     * @param FileLocationManager $fileLocationManager
     * @param LocaleManager $localeManager
     * @param PhraseManager $phraseManager
     * @param TranslationManager $translationManager
     * @param EntityManager $entityManager
     * @param Logger $logger
     */
    public function __construct(
        ProjectManager $projectManager,
        DomainManager $domainManager,
        FileLocationManager $fileLocationManager,
        LocaleManager $localeManager,
        PhraseManager $phraseManager,
        TranslationManager $translationManager,
        EntityManager $entityManager,
        Logger $logger
    ) {
        $this->projectManager = $projectManager;
        $this->domainManager = $domainManager;
        $this->fileLocationManager = $fileLocationManager;
        $this->localeManager = $localeManager;
        $this->phraseManager = $phraseManager;
        $this->translationsManager = $translationManager;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     */
    public function import(Request $request)
    {
        $project = $this->projectManager->getProject($request->get('project_id'));
        if (!$project) {
            throw new NotFoundHttpException;
        }

        $filePath = $request->get('file_path');
        if (!$project) {
            throw new BadRequestHttpException;
        }

        list($domainName, $localeCode) = explode('.', basename($filePath));

        $domain = $this->domainManager->retrieveDomain($project, $domainName);
        $fileLocation = $this->fileLocationManager->retrieveFileLocation($project, dirname($filePath));
        $locale = $this->localeManager->retrieveLocale($project, $localeCode);
        $translations = $this->translationsManager->getTranslationsForImport($domain, $fileLocation, $locale);
        $phrases = $this->phraseManager->getPhrasesForImport($domain, $fileLocation);

        foreach ($request->get('translations') as $rawTranslation) {
            if (isset($translations[$rawTranslation['key']])) {
                $translations[$rawTranslation['key']]->setContent($rawTranslation['translation']);
                $this->entityManager->persist($translations[$rawTranslation['key']]);
            } elseif (isset($phrases[$rawTranslation['key']])) {
                $translation = new Translation();
                $translation->setPhrase($phrases[$rawTranslation['key']]);
                $translation->setLocale($locale);
                $translation->setContent($rawTranslation['translation']);
                $this->entityManager->persist($translation);
            } else {
                $phrase = new Phrase();
                $phrase->setDomain($domain);
                $phrase->setFileLocation($fileLocation);
                $phrase->setKey($rawTranslation['key']);
                $translation = new Translation();
                $translation->setLocale($locale);
                $translation->setPhrase($phrase);
                $translation->setContent($rawTranslation['translation']);
                $this->entityManager->persist($phrase);
                $this->entityManager->persist($translation);
            }
        }

        $this->entityManager->flush();
    }
}
