<?php


namespace App\Form\CustomTypes;


use App\Service\BackendService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ShortcutType extends AbstractType
{
    private BackendService $backend;

    /**
     * PageType constructor.
     * @param BackendService $backend
     */
    public function __construct(BackendService $backend)
    {
        $this->backend = $backend;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('website', ChoiceType::class, [
                'choices' => $this->backend->getTree($this->backend->getEazyControl()->getWebsite()),'required' => false
            ])
            ->add('shop', ChoiceType::class, [
                'choices' => $this->backend->getTree($this->backend->getEazyControl()->getShop()),'required' => false
            ])
            ->add('blog', ChoiceType::class, [
                'choices' => $this->backend->getTree($this->backend->getEazyControl()->getBlog()),'required' => false
            ])
        ;
    }
}
