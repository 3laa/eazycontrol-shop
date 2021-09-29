<?php

namespace App\Controller\Backend\Website;

use App\Entity\Category;
use App\Entity\Page;
use App\Entity\Section;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/website/section", name="website_section_")
 */
class SectionController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SectionRepository $sectionRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param SectionRepository $sectionRepository
     */
    public function __construct(EntityManagerInterface $entityManager, SectionRepository $sectionRepository)
    {
        $this->entityManager = $entityManager;
        $this->sectionRepository = $sectionRepository;
    }


    /**
     * @param Request $request
     * @param Page $page
     * @param Category $category
     * @param int $sort
     * @return Response
     * @Route("/new/{page}/{category}/{sort}", name="new")
     */
    public function new(Request $request, Page $page, Category $category, int $sort = 0): Response
    {
        $section = new Section();
        $section->setPage($page);
        $section->setCategory($category);
        $section->setSort($sort);
        $form = $this->createForm($category->getType(), $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($section);
            $this->entityManager->flush();
            return $this->redirectToRoute('backend_website_section_edit', ['id' => $section->getId()]);
        }

        return $this->render('@backend/website/section/form.html.twig', [
            'page' => $page,
            'category' => $category,
            'section' => $section,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Section $section
     * @return Response
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Section $section): Response
    {
        $form = $this->createForm($section->getCategory()->getType(), $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return $this->render('@backend/website/section/form.html.twig', [
            'page' => $section->getPage(),
            'category' => $section->getCategory(),
            'section' => $section,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Section $section
     * @return RedirectResponse
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Section $section): RedirectResponse
    {
        $pageId = $section->getPage()->getId();
        $this->entityManager->remove($section);
        $this->entityManager->flush();
        return $this->redirectToRoute('backend_page_index', ['id' => $pageId]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/sort", name="sort")
     */
    public function sort(Request $request): JsonResponse
    {
        $sectionsSortArray = $request->get('item');
        if (is_array($sectionsSortArray))
        {
            foreach ($sectionsSortArray as $sectionToSort) {
                $section = $this->sectionRepository->findOneBy(['id' => intval($sectionToSort['id'])]);
                $section->setSort(intval($sectionToSort['sort']));
            }
            $this->entityManager->flush();
        }
        return $this->json(['response' => true], $status = 200, $headers = [], $context = []);
    }

    /**
     * @param Section $section
     * @return JsonResponse
     * @Route("/active/{id}", name="active")
     */
    public function active(Section $section): JsonResponse
    {
        $section->setIsActive(['default' => !$section->getIsActive()['default']]);
        $this->entityManager->flush();
        return $this->json(true);
    }
}