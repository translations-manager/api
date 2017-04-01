<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;

class RestController extends FOSRestController
{
    /**
     * @param mixed $type
     * @param mixed $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createApiForm($type, $data = null, $options = [])
    {
        return $this->get('form.factory')->createNamed('', $type, $data, $options);
    }

    /**
     * @param mixed $data
     * @param int|null $statusCode
     *
     * @return Response
     */
    public function handleResponse($data, $statusCode = Response::HTTP_OK)
    {
        return $this->handleView($this->view($data, $statusCode));
    }

    /**
     * @param mixed $data
     * @param array $groups
     * @param int $statusCode
     *
     * @return Response
     */
    public function handleResponseToGroupSerialize($data, array $groups, $statusCode = Response::HTTP_OK)
    {
        $serialized = $this
            ->get('jms_serializer')
            ->serialize($data, 'json', SerializationContext::create()->setGroups($groups));

        return $this->handleJsonEncodedResponse($serialized, $statusCode);
    }

    /**
     * @param string $data
     * @param int $statusCode
     *
     * @return Response
     */
    public function handleJsonEncodedResponse($data, $statusCode = Response::HTTP_OK)
    {
        return new Response($data, $statusCode, [
            'Content-type' => 'application/json'
        ]);
    }
}
