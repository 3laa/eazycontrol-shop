<?php

namespace App\Controller\Backend\General;


use App\Form\Entity\General\EazyControlType;
use App\Service\BackendService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eazycontrol", name="eazycontrol_")
 */
class EazyControlController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @param BackendService $backendService
     * @return Response
     * @Route("/", name="index")
     */
    public function index(Request $request, BackendService $backendService): Response
    {
        $form = $this->createForm(EazyControlType::class, $backendService->getEazyControl());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'EazyControl has been successfully updated.');
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Edit EazyControl',
            'entity'=>$backendService->getEazyControl(),
            'form' => $form->createView()
        ]);
    }
}
