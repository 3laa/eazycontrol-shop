<?php


namespace App\Form\CustomTypes\ViewOptions;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WidthType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['choices'=> [
            '4/12'=>'col-md-4',
            '3/12'=>'col-lg-3 col-md-6',
            '6/12'=>'col-md-6',
            '2/12'=>'col-lg-2 col-md-4 col-sm-6',
            '12/12'=>'col-12',
            '9/12'=>'col-md-9',
            '10/12'=>'col-md-10',
            '11/12'=>'col-md-11',
            '8/12'=>'col-md-8',
            '7/12'=>'col-md-7',
            '5/12'=>'col-md-5',
            '1/12'=>'col-md-1',
            'Auto'=>'col',
        ]]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}