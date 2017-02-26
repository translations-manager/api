<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Project;
use AppBundle\Repository\LocaleRepository;

class LocaleManager
{
    /**
     * @var LocaleRepository
     */
    private $localeRepository;

    /**
     * @param LocaleRepository $localeRepository
     */
    public function __construct(LocaleRepository $localeRepository)
    {
        $this->localeRepository = $localeRepository;
    }

    /**
     * @param Project $project
     * @param string $code
     */
    public function retrieveLocale(Project $project, $code)
    {
        $this->localeRepository->mergeLocale($project, $code);
    }
}
