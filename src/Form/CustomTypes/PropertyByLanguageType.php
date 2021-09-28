<?php

namespace App\Form\CustomTypes;

use App\Service\BackendService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyByLanguageType extends AbstractType
{
    private BackendService $backendService;

    /**
     * @param BackendService $backendService
     */
    public function __construct(BackendService $backendService)
    {
        $this->backendService = $backendService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeOption = $options['type'];
        $builder->add('default', $typeOption, ['required' => false]);
        $extraLanguage = $this->backendService->getEazyControl()->getExtraLanguage();
        if($extraLanguage) {
            foreach($extraLanguage as $language) {
                $builder->add($language, $typeOption, ['required' => false, 'label' => $options['extra-label']]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'type' => TextType::class,
            'extra-label' => ''
        ]);
    }
}