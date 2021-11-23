<?php

namespace App\Controller\Frontend\General;

use App\Entity\FrontendForm;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/form", name="form_")
 */
class FrontendFormController extends AbstractController
{

    private MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * @param Request $request
     * @param FrontendForm $frontendForm
     * @param string $slug
     * @return JsonResponse
     * @Route("/{frontendForm}/{slug}", name="index", methods="POST")
     */
    public function index(Request $request, FrontendForm $frontendForm, string $slug = ''): JsonResponse
    {
        $form = $this->createForm($frontendForm->getType());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $function = $frontendForm->getFinisher();
            $result = $this->$function($form->getData(), $frontendForm);
        }
        else
        {
            $result = ['status'=>false, 'result'=>$form];
        }
        return $this->json($result);
    }

    public function sendEmail(array $data, FrontendForm $frontendForm): array
    {
        $email = (new TemplatedEmail())
            ->from($frontendForm->getSendFrom())
            ->to($frontendForm->getSendTo())
            ->subject($frontendForm->getName())
            ->context(['data' => $data, 'frontendForm' => $frontendForm])
            ->htmlTemplate('@frontend/website/sections/frontend-form/contact-us-template.html.twig')
            ;

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return ['status'=>false, 'result'=>$e->getMessage()];
        }
        return ['status'=>true, 'result'=>$data];
    }
}
