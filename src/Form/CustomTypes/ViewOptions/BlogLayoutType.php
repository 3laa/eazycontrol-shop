<?php


namespace App\Form\CustomTypes\ViewOptions;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogLayoutType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['choices'=> [
            'Featured Articles'=> 'featured',
            'Grid'=> 'grid',
            '2 Columns Vertical'=> 'two-vertical',
            'Horizontal'=> 'horizontal',
            '1 Primary 3 Secondary Vertical'=> 'primary-vertical',
            '1 Primary 3 Secondary-horizontal'=> 'primary-horizontal',
            'Sidebar Image'=> 'sidebar-image',
            'Sidebar Text'=> 'sidebar-text',
        ]]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}