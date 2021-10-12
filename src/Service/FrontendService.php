<?php

namespace App\Service;

use App\Entity\EazyControl;
use App\Entity\Page;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class FrontendService extends AbstractController
{
    private EazyControl $eazyControl;

    /**
     * @var Collection|Page[]
     */
    private $pagesBreadcrumb = [];

    /**
     * @var Page|null
     */
    private ?Page $activePage;

    public function onKernelControllerArguments(ControllerArgumentsEvent $event) {
        $this->eazyControl = $this->getDoctrine()->getRepository(EazyControl::class)->findOneBy([]);
        $this->setActivePage($event->getRequest());
        $this->setPagesBreadcrumb($this->activePage);
    }

    /**
     * @return EazyControl
     */
    public function getEazyControl(): EazyControl
    {
        return $this->eazyControl;
    }

    public function setActivePage(Request $request) {
        if ($request->attributes->get('page') !== null) {
            $this->activePage = $request->attributes->get('page');
        }

       /* else if ($request->attributes->get('product') !== null) {
            $this->activePage = $request->attributes->get('product')->getPage();
        }

        else if ($request->attributes->get('article') !== null) {
            $this->activePage = $request->attributes->get('article')->getPage();
        }*/

        else {
            $this->activePage = $this->eazyControl->getRoot();
        }
    }

    public function setPagesBreadcrumb(?Page $page) {
        if ($page !== null && $page->getPage() != null) {
            $this->pagesBreadcrumb[count($this->pagesBreadcrumb)] = $page;
            $this->setPagesBreadcrumb($page->getPage());
        }
    }

    public function getPagesBreadcrumb()
    {
        return $this->pagesBreadcrumb;
    }
}
