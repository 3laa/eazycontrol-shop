<?php

namespace App\Form\Entity\General;

use App\Entity\EazyControl;
use App\Form\CustomTypes\PropertyByLanguageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EazyControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title', PropertyByLanguageType::class)
            ->add('extraLanguage', LanguageType::class, ['multiple'=>true, 'required'=>false])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EazyControl::class
        ]);
    }
}