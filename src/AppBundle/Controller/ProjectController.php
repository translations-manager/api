<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\Type\ProjectType;
use FOS\RestBundle\Controller\Annotations\Route;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends RestController
{
    /**
     * @return Response
     */
    public function getProjectsAction()
    {
        $projects = $this->get('app.manager.project')->listProjects();

        $serialized = $this
            ->get('jms_serializer')
            ->serialize($projects, 'json', SerializationContext::create()->setGroups(['list']));

        return $this->handleJsonEncodedResponse($serialized);
    }

    /**
     * @param Project $project
     *
     * @return Response
     *
     * @Route("/projects/{id}")
     *
     * @ParamConverter("project", converter="project_param_converter", options={"readonly": true})
     */
    public function getProjectAction(Project $project)
    {
        return $this->handleResponseToGroupSerialize($project, ['read']);
    }

    /**
     * @param Project $project
     *
     * @return Response
     *
     * @Route("/projects")
     *
     * @ParamConverter("project", converter="project_param_converter")
     */
    public function postProjectAction(Project $project)
    {
        $this->get('app.manager.project')->saveProject($project);

        return $this->handleResponse($project, Response::HTTP_CREATED);
    }

    /**
     * @param Project $project
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/projects/{id}")
     *
     * @ParamConverter("project", converter="project_param_converter")
     */
    public function putProjectAction(Project $project, Request $request)
    {
        $form = $this->createApiForm(ProjectType::class, $project, ['method' => Request::METHOD_PUT]);
        $form->handleRequest($request);

        $this->get('app.manager.project')->saveProject($project);

        return $this->handleResponse($project);
    }

    /**
     * @param Project $project
     *
     * @return Response
     *
     * @Route("/projects/{id}")
     *
     * @ParamConverter("project", converter="project_param_converter")
     */
    public function deleteProjectAction(Project $project)
    {
        $this->get('app.manager.project')->deleteProject($project);

        return $this->handleResponse([]);
    }
}
