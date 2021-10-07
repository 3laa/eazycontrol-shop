<?php

namespace App\Controller\Backend\General;

use App\Entity\Category;
use App\Form\Entity\General\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface$entityManager;

    /**
     * @param CategoryRepository $categoryRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('@backend/general/category.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'Category has been successfully created.');
            return $this->redirectToRoute('backend_category_index');
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Add New Category ',
            'entity'=>$category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse|Response
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Category $category) {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Category has been successfully updated.');
            return $this->redirectToRoute('backend_category_index');
        }

        return $this->render('@backend/CRUD/form.html.twig', [
            'breadcrumb'=>'Edit Category ',
            'entity'=>$category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Category $category): RedirectResponse
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
        $this->addFlash('success', 'Category has been successfully deleted.');
        return $this->redirectToRoute('backend_category_index');
    }
}
