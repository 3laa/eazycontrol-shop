<?php

namespace App\Form\Entity\General;

use App\Entity\Page;
use App\Form\CustomTypes\LinkType;
use App\Form\CustomTypes\PropertyByLanguageType;
use App\Form\CustomTypes\ShortcutType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isActive', PropertyByLanguageType::class, ['type'=>CheckboxType::class])
            ->add('title', PropertyByLanguageType::class)
            ->add('shortcut', ShortcutType::class)
            ->add('link', PropertyByLanguageType::class, ['type'=>LinkType::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
