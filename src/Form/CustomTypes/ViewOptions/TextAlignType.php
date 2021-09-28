<?php


namespace App\Form\CustomTypes\ViewOptions;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextAlignType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['choices'=> [
            'Left'=>'--text-align-left',
            'Center'=>'--text-align-center',
            'Right'=>'--text-align-right',
        ]]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}