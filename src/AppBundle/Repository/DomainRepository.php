<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Domain;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class DomainRepository extends EntityRepository
{
    /**
     * @param Project $project
     * @param string $domainName
     *
     * @return Domain
     */
    public function mergeDomain(Project $project, $domainName)
    {
        $domain = $this
            ->createQueryBuilder('d')
            ->where('d.project = :project')
            ->andWhere('d.name = :name')
            ->setParameter('project', $project)
            ->setParameter('name', $domainName)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$domain) {
            $domain = new Domain();
            $domain->setProject($project);
            $domain->setName($domainName);
            $this->getEntityManager()->persist($domain);
            $this->getEntityManager()->flush();
        }

        return $domain;
    }
}
