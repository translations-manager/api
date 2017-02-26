<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Domain;
use AppBundle\Entity\Project;
use AppBundle\Repository\DomainRepository;

class DomainManager
{
    /**
     * @var DomainRepository
     */
    private $domainRepository;

    /**
     * @param DomainRepository $domainRepository
     */
    public function __construct(DomainRepository $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    /**
     * @param Project $project
     * @param string $name
     *
     * @return Domain
     */
    public function retrieveDomain(Project $project, $name)
    {
        return $this->domainRepository->mergeDomain($project, $name);
    }
}
