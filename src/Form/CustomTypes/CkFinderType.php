<?php

namespace App\Form\CustomTypes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CkFinderType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'required' => false
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}