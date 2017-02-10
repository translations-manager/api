<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Phrase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PhraseManager
{
    /**
     * @var EntityRepository
     */
    private $phraseRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityRepository $phraseRepository
     * @param EntityManager $entityManager
     */
    public function __construct(EntityRepository $phraseRepository, EntityManager $entityManager)
    {
        $this->phraseRepository = $phraseRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Phrase[]
     */
    public function listPhrases()
    {
        return $this->phraseRepository->findAll();
    }

    /**
     * @param Phrase $phrase
     */
    public function savePhrase(Phrase $phrase)
    {
        $this->entityManager->persist($phrase);
        $this->entityManager->flush();
    }
}
