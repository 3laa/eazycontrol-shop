<?php


namespace App\Form\CustomTypes;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', CkFinderType::class)
            ->add('text', TextType::class)
            ->add('target', ChoiceType::class, [
                'choices' => [
                    '_self' => '_self',
                    '_blank' => '_blank',
                    '_parent' => '_parent',
                    '_top' => '_top'
                ]
            ]);
    }
}