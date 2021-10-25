<?php

namespace App\Form\Entity\Website\Section;

use App\Entity\Section;
use App\Form\CustomTypes\LinkType;
use App\Form\CustomTypes\MediaType;
use App\Form\CustomTypes\PropertyByLanguageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboutSectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isActive', PropertyByLanguageType::class, [
                'type' => CheckboxType::class
            ])
            ->add('title', PropertyByLanguageType::class)
            ->add('subtitle', PropertyByLanguageType::class)
            ->add('text', PropertyByLanguageType::class, ['type'=>TextareaType::class])
            ->add('link', PropertyByLanguageType::class, ['type'=>LinkType::class])
            ->add('media', MediaType::class, ['type'=>['image', 'youtube']])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class
        ]);
    }
}
