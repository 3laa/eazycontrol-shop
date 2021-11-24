<?php

namespace App\Controller\Backend\General;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/command", name="command_")
 */
class CommandController extends AbstractController
{

    private KernelInterface $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Route("/", name="index")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json($this->command(array('command' => 'cache:pool:clear', 'pools'=>['cache.global_clearer', 'cache.app'])));
    }

    private function command(array $command): array
    {
        $env = $this->kernel->getEnvironment();
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput($command);
        $output = new BufferedOutput();
        try {
            $application->run($input, $output);
            return ['status'=>true, 'result'=>$output->fetch()];
        } catch (\Exception $e) {
            return ['status'=>false, 'result'=>$e->getMessage()];
        }
    }

}
