<?php

namespace App\Form\Entity\Website\Section;

use App\Entity\Section;
use App\Form\CustomTypes\MediaType;
use App\Form\CustomTypes\PropertyByLanguageType;
use App\Form\CustomTypes\ViewOptionsType;
use App\Form\Entity\Website\Content\GalleryMediaContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryMediaSectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isActive', PropertyByLanguageType::class, [
                'type' => CheckboxType::class
            ])
            ->add('title', PropertyByLanguageType::class)
            ->add('subtitle', PropertyByLanguageType::class)
            ->add('contents', CollectionType::class,
                [
                    'entry_type' => GalleryMediaContentType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'attr' => [
                        'data-type' => '-MultiFiles'
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
