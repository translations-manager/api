<?php

namespace AppBundle\Manager;

use AppBundle\Entity\FileLocation;
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
     *
     * @return FileLocation
     */
    public function retrieveFileLocation(Project $project, $path)
    {
        return $this->fileLocationRepository->mergeFileLocation($project, $path);
    }
}
