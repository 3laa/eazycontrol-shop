<?php

namespace App\Form\Entity\Website\Section\FrontendForm;

use App\Entity\Section;
use App\Form\CustomTypes\PropertyByLanguageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontendFormSectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isActive', PropertyByLanguageType::class, [
                'type' => CheckboxType::class
            ])
            ->add('title', PropertyByLanguageType::class)
            ->add('subtitle', PropertyByLanguageType::class)
            ->add('text', PropertyByLanguageType::class, ['type' => CKEditorType::class])
            ->add('frontendForm')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class
        ]);
    }
}
