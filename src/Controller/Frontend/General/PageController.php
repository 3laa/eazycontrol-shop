<?php

namespace App\Controller\Frontend\General;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="page_")
 */
class PageController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render("@frontend/index.html.twig");
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     * @Route ("/{page}", name="id", requirements={"page"="\d+"})
     */
    public function id(Request $request, Page $page): Response
    {
        return $this->render("@frontend/index.html.twig");
    }

    /**
     * @param Request $request
     * @param Page $page
     * @param string $slug
     * @return Response
     * @Route ("/{page}/{slug}", name="slug", requirements={"page"="\d+"})
     */
    public function slug(Request $request, Page $page, string $slug=''): Response
    {
        return $this->render("@frontend/index.html.twig");
    }
}
