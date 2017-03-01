<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends RestController
{
    /**
     * @return Response
     *
     * @Route("/login")
     */
    public function postLoginAction()
    {
        return $this->handleResponse([
            'token' => $this->getUser()->getAuthToken()
        ]);
    }
}
