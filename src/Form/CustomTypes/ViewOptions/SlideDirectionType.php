<?php


namespace App\Form\CustomTypes\ViewOptions;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlideDirectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['choices'=> [
            'Center'=>'--text-align-center justify-content-md-center',
            'Left'=>'--text-align-left justify-content-md-start',
            'Right'=>'--text-align-right justify-content-md-end',
        ]]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}