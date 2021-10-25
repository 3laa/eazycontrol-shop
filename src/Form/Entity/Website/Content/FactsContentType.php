<?php

namespace App\Form\Entity\Website\Content;

use App\Entity\Content;
use App\Form\CustomTypes\PropertyByLanguageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactsContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isActive', PropertyByLanguageType::class, ['type' => CheckboxType::class])
            ->add('title', PropertyByLanguageType::class)
            ->add('subtitle', PropertyByLanguageType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class
        ]);
    }
}
