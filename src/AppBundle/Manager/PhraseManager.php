<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Phrase;
use AppBundle\Repository\PhraseRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PhraseManager
{
    /**
     * @var PhraseRepository
     */
    private $phraseRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param PhraseRepository $phraseRepository
     * @param EntityManager $entityManager
     */
    public function __construct(PhraseRepository $phraseRepository, EntityManager $entityManager)
    {
        $this->phraseRepository = $phraseRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $projectId
     * @param array $domainsIds
     * @param string $query
     *
     * @return Phrase[]
     */
    public function listPhrases($projectId, array $domainsIds, $query)
    {
        return $this->phraseRepository->search($projectId, $domainsIds, $query);
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
