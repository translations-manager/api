<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phrase;
use AppBundle\Form\Type\PhraseType;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhraseController extends RestController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getPhrasesAction(Request $request)
    {
        $phrases = $this
            ->get('app.manager.phrase')
            ->listPhrases(
                $request->get('project'),
                $request->get('domain_ids', []),
                $request->get('q', '')
            )
        ;

        return $this->handleResponse(
            $this->get('app.builder.phrases_response')->build($phrases, $request->get('locale_ids', []))
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/phrases")
     */
    public function postPhraseAction(Request $request)
    {
        $phrase = new Phrase;
        $form = $this->createApiForm(PhraseType::class, $phrase);
        $form->handleRequest($request);

        $this->get('app.manager.phrase')->savePhrase($phrase);

        return $this->handleResponse($phrase, Response::HTTP_CREATED);
    }

    /**
     * @param Phrase $phrase
     *
     * @return Response
     *
     * @Route("/phrases/{id}")
     *
     * @ParamConverter("phrase", class="AppBundle:Phrase")
     */
    public function deletePhraseAction(Phrase $phrase)
    {
        $this->get('app.manager.phrase')->deletePhrase($phrase);

        return $this->handleResponse(null);
    }
}
