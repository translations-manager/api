<?php

namespace AppBundle\ParamConverter;

use AppBundle\Entity\Project;
use AppBundle\Manager\ProjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectParamConverter implements ParamConverterInterface
{
    /**
     * @var ProjectManager
     */
    private $projectManager;

    /**
     * @param ProjectManager $projectManager
     */
    public function __construct(ProjectManager $projectManager)
    {
        $this->projectManager = $projectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $project = $request->get('id') ? $this->projectManager->getProject($request->get('id')) : new Project();

        if (!$project) {
            throw new NotFoundHttpException;
        }

        if (!isset($configuration->getOptions()['readonly']) || !$configuration->getOptions()['readonly']) {
            $project->setName($request->get('name'));
        }

        $request->attributes->set($configuration->getName(), $project);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Project::class;
    }
}
