<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Phrase;
use Doctrine\ORM\EntityRepository;

class PhraseRepository extends EntityRepository
{
    /**
     * @param int $projectId
     * @param array $domainsIds
     * @param string $query
     *
     * @return Phrase[]
     */
    public function search($projectId, array $domainsIds, $query)
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

        if ($query) {
            $queryBuilder
                ->leftJoin('p.translations', 't')
                ->andWhere('t.content like :query or d.name like :query or p.key like :query')
                ->setParameter('query', sprintf('%%%s%%', $query));
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
