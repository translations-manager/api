<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ProjectManager
{
    /**
     * @var EntityRepository
     */
    private $projectRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityRepository $projectRepository
     * @param EntityManager $entityManager
     */
    public function __construct(EntityRepository $projectRepository, EntityManager $entityManager)
    {
        $this->projectRepository = $projectRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Project[]
     */
    public function listProjects()
    {
        return $this->projectRepository->findBy([], ['name' => 'ASC']);
    }

    /**
     * @param int $projectId
     *
     * @return Project|null
     */
    public function getProject($projectId)
    {
        return $this->projectRepository->find($projectId);
    }

    /**
     * @param Project $project
     */
    public function deleteProject(Project $project)
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    /**
     * @param Project $project
     */
    public function saveProject(Project $project)
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }
}
