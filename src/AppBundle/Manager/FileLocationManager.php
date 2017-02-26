<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Project;
use AppBundle\Repository\FileLocationRepository;

class FileLocationManager
{
    /**
     * @var FileLocationRepository
     */
    private $fileLocationRepository;

    /**
     * @param FileLocationRepository $fileLocationRepository
     */
    public function __construct(FileLocationRepository $fileLocationRepository)
    {
        $this->fileLocationRepository = $fileLocationRepository;
    }

    /**
     * @param Project $project
     * @param string $path
     */
    public function retrieveFileLocation(Project $project, $path)
    {
        $this->fileLocationRepository->mergeFileLocation($project, $path);
    }
}
