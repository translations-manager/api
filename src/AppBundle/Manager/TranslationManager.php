<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Translation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class TranslationManager
{
    /**
     * @var EntityRepository
     */
    private $translationRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityRepository $translationRepository
     * @param EntityManager $entityManager
     */
    public function __construct(EntityRepository $translationRepository, EntityManager $entityManager)
    {
        $this->translationRepository = $translationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Translation $translation
     */
    public function saveTranslation(Translation $translation)
    {
        $this->entityManager->persist($translation);
        $this->entityManager->flush();
    }
}
