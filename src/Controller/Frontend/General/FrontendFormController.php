<?php

namespace App\Controller\Frontend\General;

use App\Entity\FrontendForm;
use App\Form\Entity\Website\Section\FrontendForm\ContactUsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/form", name="form_")
 */
class FrontendFormController extends AbstractController
{
    /**
     * @param Request $request
     * @param FrontendForm $frontendForm
     * @param string $slug
     * @return JsonResponse
     * @Route("/{frontendForm}/{slug}", name="index", methods="POST")
     */
    public function index(Request $request, FrontendForm $frontendForm, string $slug = ''): JsonResponse
    {
        $result = [];
        $form = $this->createForm($frontendForm->getType());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result = ['status'=>true, 'data'=>$form->getData()];
        }
        else
        {
            $result = ['status'=>false, 'data'=>$form];
        }
        return $this->json($result);
    }
}
