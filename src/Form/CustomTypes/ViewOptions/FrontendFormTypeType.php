<?php


namespace App\Form\CustomTypes\ViewOptions;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontendFormTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['choices'=> [
            'Contact Form'=> 'FrontendFormContactType',
            'ContactProfi From'=> 'FrontendFormContactProfiType'
        ]]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}