<?php

namespace App\Form\CustomTypes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {

        if(in_array('icon', $options['type'])) {
            $builder->add('icon', TextType::class, ['required'=>false]);
        }

        if(in_array('image', $options['type'])) {
            $builder->add('image', CkFinderType::class);
        }

        if(in_array('image2', $options['type'])) {
            $builder->add('image2', CkFinderType::class);
        }

        if(in_array('background', $options['type'])) {
            $builder->add('background', CkFinderType::class);
        }

        if(in_array('file', $options['type'])) {
            $builder->add('file', CkFinderType::class);
        }

        if(in_array('youtube', $options['type'])) {
            $builder->add('youtube', TextType::class, ['required'=>false]);
        }

        if(in_array('tags', $options['type'])) {
            $builder->add('tags', TextType::class, ['required'=>false]);
        }

        if(in_array('website', $options['type'])) {
            $builder->add('logo-light', CkFinderType::class, ['required'=>false]);
            $builder->add('logo-dark', CkFinderType::class, ['required'=>false]);
            $builder->add('favicon', CkFinderType::class, ['required'=>false]);
            $builder->add('image', CkFinderType::class, ['required'=>false]);
            $builder->add('color', ColorType::class, ['required'=>false]);
        }

        if(in_array('page', $options['type'])) {
            $builder->add('image', CkFinderType::class, ['required'=>false]);
            $builder->add('class', TextType::class, ['required'=>false]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'type' => ['image']
        ]);
    }
}
