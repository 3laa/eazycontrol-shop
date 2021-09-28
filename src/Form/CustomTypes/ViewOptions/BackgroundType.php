<?php


namespace App\Form\CustomTypes\ViewOptions;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackgroundType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['choices'=> [
            'White'=>'--background-white',
            'Gray 1'=>'--background-1',
            'Gray 2'=>'--background-2',
            'Gray 3'=>'--background-3',
            'Gray 4'=>'--background-4',
            'Gray 5'=>'--background-5',
            'Gray 6'=>'--background-6',
        ]]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}