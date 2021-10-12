<?php

namespace App\Controller\Frontend\General;

use App\Entity\Page;
use App\Service\FrontendService;
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
     * @param FrontendService $frontend
     * @return Response
     * @Route("/", name="index")
     */
    public function index(FrontendService $frontend): Response
    {
        $page = $frontend->getEazyControl()->getRoot();
        return $this->render("@frontend/". $page->getType() ."/index.html.twig", ['page'=>$page]);
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
