<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleResponse($data, $statusCode = null)
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}
