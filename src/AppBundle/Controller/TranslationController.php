<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Translation;
use AppBundle\Form\Type\TranslationType;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

    /**
     * @param Translation $translation
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/translations/{id}")
     *
     * @ParamConverter("translation", class="AppBundle:Translation")
     */
    public function putTranslationAction(Translation $translation, Request $request)
    {
        $form = $this->createApiForm(TranslationType::class, $translation, [
            'method' => Request::METHOD_PUT
        ]);
        $form->handleRequest($request);

        $this->get('app.manager.translation')->saveTranslation($translation);

        return $this->handleResponse($translation);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getTranslationsAction(Request $request)
    {
        return $this->handleResponse($this->get('app.manager.translation')->exportTranslations(
            $request->get('domain_ids', []),
            $request->get('location_ids', []),
            $request->get('locale_ids', [])
        ));
    }
}
