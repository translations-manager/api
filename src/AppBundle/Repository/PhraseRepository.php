<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Domain;
use AppBundle\Entity\FileLocation;
use AppBundle\Entity\Phrase;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class PhraseRepository extends EntityRepository
{
    const NB_RESULTS_PER_PAGE = 20;

    /**
     * @param int $projectId
     * @param array $domainsIds
     * @param string $query
     *
     * @return QueryBuilder
     */
    private function getSearchQueryBuilder($projectId, array $domainsIds, $query)
    {
        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->join('p.domain', 'd')
            ->join('p.fileLocation', 'l')
            ->andWhere('d.project = :project')
            ->andWhere('l.project = :project')
            ->setParameter('project', $projectId)
            ->groupBy('p.id')
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

        return $queryBuilder;
    }

    /**
     * @param int $projectId
     * @param array $domainsIds
     * @param string $query
     *
     * @return array
     */
    public function getSearchMetadata($projectId, array $domainsIds, $query)
    {
        $count = $this
            ->getSearchQueryBuilder($projectId, $domainsIds, $query)
            ->select('COUNT (p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'total' => $count,
            'nb_pages' => ceil($count / self::NB_RESULTS_PER_PAGE)
        ];
    }

    /**
     * @param int $projectId
     * @param array $domainsIds
     * @param string $query
     * @param int $page
     *
     * @return Phrase[]
     */
    public function search($projectId, array $domainsIds, $query, $page)
    {
        return $this
            ->getSearchQueryBuilder($projectId, $domainsIds, $query)
            ->setFirstResult(($page - 1) * self::NB_RESULTS_PER_PAGE)
            ->setMaxResults(self::NB_RESULTS_PER_PAGE)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Domain $domain
     * @param FileLocation $fileLocation
     *
     * @return Phrase[]
     */
    public function findForImport(Domain $domain, FileLocation $fileLocation)
    {
        return $this
            ->createQueryBuilder('p')
            ->where('p.domain = :domain')
            ->andWhere('p.fileLocation = :fileLocation')
            ->setParameter('domain', $domain)
            ->setParameter('fileLocation', $fileLocation)
            ->getQuery()
            ->getResult();
    }
}
