<?php

namespace App\Controller\Backend\General;

use App\Entity\Page;
use App\Form\Entity\General\PageType;
use App\Repository\CategoryRepository;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/page", name="page_")
 */
class PageController extends AbstractController
{

    private PageRepository $pageRepository;
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param PageRepository $pageRepository
     * @param CategoryRepository $categoryRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(PageRepository $pageRepository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return mixed
     * @Route("/{id}", name="index")
     */
    public function index(Request $request, Page $page)
    {
        $fun = $page->getType();
        return $this->$fun($request, $page);
    }


    public function website($request, $page): Response
    {
        return $this->render('@backend/website/section/index.html.twig', [
            'page' => $page,
            'categories' => $this->categoryRepository->findAll()
        ]);
    }

    public function shop($request, $page): Response
    {
        return $this->render('@backend/shop/index.html.twig');
    }

    public function blog($request, $page): Response
    {
        return $this->render('@backend/blog/index.html.twig');
    }

    /**
     * @param Request $request
     * @param Page $page
     * @param string $type
     * @return Response
     * @Route("/new/{id}/{type}", name="new")
     */
    public function new(Request $request, Page $page, string $type): Response
    {
        $page->setIsToggle(true);
        $newPage = new Page();
        $newPage->setPage($page);
        $newPage->setType($type);
        $form = $this->createForm(PageType::class, $newPage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($newPage);
            $this->entityManager->persist($page);
            $this->entityManager->flush();
            $this->addFlash('success', 'Page has been successfully created.');
            return $this->redirectToRoute('backend_page_edit', ['id' => $newPage->getId()]);
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Add New Page To ',
            'entity'=>$page,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Page has been successfully updated.');
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Edit Page ',
            'entity'=>$page,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Page $page
     * @return RedirectResponse
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Page $page): RedirectResponse
    {
        $this->entityManager->remove($page);
        $this->entityManager->flush();
        $this->addFlash('success', 'Page has been successfully deleted.');
        return $this->redirectToRoute('backend_main_index');
    }

    /**
     * @param Page $page
     * @return JsonResponse
     * @Route("/active/{id}", name="active")
     */
    public function active(Page $page): JsonResponse
    {
        $page->setIsActive(['default' => !$page->getIsActive()['default']]);
        $this->entityManager->flush();
        return $this->json(true);
    }

    /**
     * @param Page $page
     * @return JsonResponse
     * @Route("/toggle/{id}", name="toggle")
     */
    public function toggle(Page $page): JsonResponse
    {
        $page->setIsToggle(!$page->getIsToggle());
        $this->entityManager->flush();
        return $this->json(true);
    }
}
