<?php

namespace App\Form\Entity\Website\Section;

use App\Entity\Section;
use App\Form\CustomTypes\PropertyByLanguageType;
use App\Form\Entity\Website\Content\FactsContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactsSectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isActive', PropertyByLanguageType::class, [
                'type' => CheckboxType::class
            ])
            ->add('title', PropertyByLanguageType::class)
            ->add('contents', CollectionType::class,
                [
                    'entry_type' => FactsContentType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'attr' => [
                        'data-type' => '-Single'
                    ]
                ]);
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class
        ]);
    }
}
