<?php

namespace App\Service;

use App\Entity\EasyControl;
use App\Entity\EazyControl;
use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class BackendService extends AbstractController
{
    private EazyControl $eazyControl;

    public function onKernelControllerArguments(ControllerArgumentsEvent $event) {
        $this->eazyControl = $this->getDoctrine()->getRepository(EazyControl::class)->findOneBy([]);
    }

    /**
     * @return EazyControl
     */
    public function getEazyControl(): EazyControl
    {
        return $this->eazyControl;
    }

    public function getTree(?Page $page, array &$array=['Please Select One'=>null]): array
    {
        if($page !== null) {

            if($page->getPage() !== null) {
                $array[$page->getTitle()['default']] = $page->getId();
            }

            if(count($page->getPages()) !== null) {
                foreach ($page->getPages() as $subpage) {
                    if($page->getPage() !== null) {
                        $array[$page->getTitle()['default'].' :: Subpages'][$subpage->getTitle()['default']] = $subpage->getId();
                        $this->getTree($subpage, $array[$page->getTitle()['default'].' :: Subpages']);
                    } else {
                        $array[$subpage->getTitle()['default']] = $subpage->getId();
                        $this->getTree($subpage, $array);
                    }
                }
            }
        }
        return $array;
    }
}
