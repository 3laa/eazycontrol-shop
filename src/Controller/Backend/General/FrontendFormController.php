<?php

namespace App\Controller\Backend\General;

use App\Entity\FrontendForm;
use App\Form\Entity\General\FrontendFormType;
use App\Repository\FrontendFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/frontend-form", name="frontend-form_")
 */
class FrontendFormController extends AbstractController
{
    private FrontendFormRepository $frontendFormRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param FrontendFormRepository $frontendFormRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FrontendFormRepository $frontendFormRepository, EntityManagerInterface $entityManager)
    {
        $this->frontendFormRepository = $frontendFormRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $forms = $this->frontendFormRepository->findAll();
        return $this->render('@backend/general/frontend-form.html.twig', [
            'forms' => $forms
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $frontendForm = new FrontendForm();
        $form = $this->createForm(FrontendFormType::class, $frontendForm);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($frontendForm);
            $this->entityManager->flush();
            $this->addFlash('success', 'FrontendForm has been successfully created.');
            return $this->redirectToRoute('backend_frontend-form_index');
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Add New FrontendForm ',
            'entity'=>$frontendForm,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param FrontendForm $frontendForm
     * @return RedirectResponse|Response
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, FrontendForm $frontendForm) {
        $form = $this->createForm(FrontendFormType::class, $frontendForm);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'FrontendForm has been successfully updated.');
            return $this->redirectToRoute('backend_frontend-form_index');
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Edit FrontendForm ',
            'entity'=>$frontendForm,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param FrontendForm $frontendForm
     * @return RedirectResponse
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(FrontendForm $frontendForm): RedirectResponse
    {
        $this->entityManager->remove($frontendForm);
        $this->entityManager->flush();
        $this->addFlash('success', 'FrontendForm has been successfully deleted.');
        return $this->redirectToRoute('backend_frontend-form_index');
    }
}
