<?php

namespace App\Form\Entity\Website\Content;

use App\Entity\Content;
use App\Form\CustomTypes\LinkType;
use App\Form\CustomTypes\MediaType;
use App\Form\CustomTypes\PropertyByLanguageType;
use App\Form\CustomTypes\ViewOptionsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxMediaContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isActive', PropertyByLanguageType::class, ['type' => CheckboxType::class])
            ->add('title', PropertyByLanguageType::class)
            ->add('subtitle', PropertyByLanguageType::class)
            ->add('link', PropertyByLanguageType::class, ['type'=>LinkType::class])
            ->add('media', MediaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class
        ]);
    }
}
