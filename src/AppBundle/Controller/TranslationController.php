<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Translation;
use AppBundle\Form\Type\TranslationType;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationController extends RestController
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/translations")
     */
    public function postTranslationAction(Request $request)
    {
        $translation = new Translation;
        $form = $this->createApiForm(TranslationType::class, $translation);
        $form->handleRequest($request);

        $this->get('app.manager.translation')->saveTranslation($translation);

        return $this->handleResponse($translation, Response::HTTP_CREATED);
    }
}
