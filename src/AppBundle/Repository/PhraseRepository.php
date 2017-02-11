<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Phrase;
use Doctrine\ORM\EntityRepository;

class PhraseRepository extends EntityRepository
{
    /**
     * @param int $projectId
     * @param array $domainsIds
     *
     * @return Phrase[]
     */
    public function search($projectId, array $domainsIds)
    {
        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->join('p.domain', 'd')
            ->join('p.fileLocation', 'l')
            ->andWhere('d.project = :project')
            ->andWhere('l.project = :project')
            ->setParameter('project', $projectId)
        ;

        if ($domainsIds) {
            $queryBuilder
                ->andWhere('d.id in (:domainsIds)')
                ->setParameter('domainsIds', $domainsIds);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
