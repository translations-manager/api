<?php

namespace AppBundle\Repository;

use AppBundle\Entity\FileLocation;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class FileLocationRepository extends EntityRepository
{
    /**
     * @param Project $project
     * @param string $path
     *
     * @return FileLocation
     */
    public function mergeFileLocation(Project $project, $path)
    {
        $fileLocation = $this
            ->createQueryBuilder('l')
            ->where('l.project = :project')
            ->andWhere('l.path= :path')
            ->setParameter('project', $project)
            ->setParameter('path', $path)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$fileLocation) {
            $fileLocation = new FileLocation();
            $fileLocation->setProject($project);
            $fileLocation->setPath($path);
            $this->getEntityManager()->persist($fileLocation);
            $this->getEntityManager()->flush();
        }

        return $fileLocation;
    }
}
