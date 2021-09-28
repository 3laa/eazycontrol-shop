<?php

namespace App\Service;

use App\Entity\EasyControl;
use App\Entity\EazyControl;
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
}