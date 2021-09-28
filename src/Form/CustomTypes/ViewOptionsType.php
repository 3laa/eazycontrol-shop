<?php

namespace App\Form\CustomTypes;

use App\Form\CustomTypes\ViewOptions\BackgroundType;
use App\Form\CustomTypes\ViewOptions\BlogLayoutType;
use App\Form\CustomTypes\ViewOptions\ContainerLayoutType;
use App\Form\CustomTypes\ViewOptions\FrontendFormTypeType;
use App\Form\CustomTypes\ViewOptions\SlideDirectionType;
use App\Form\CustomTypes\ViewOptions\StyleType;
use App\Form\CustomTypes\ViewOptions\TextAlignType;
use App\Form\CustomTypes\ViewOptions\ThemeType;
use App\Form\CustomTypes\ViewOptions\WidthType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViewOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;

        if(in_array('slide-direction', $options['type'])) {
            $builder->add('slide-direction', SlideDirectionType::class);
        }

        if(in_array('text-align', $options['type'])) {
            $builder->add('text-align', TextAlignType::class);
        }

        if(in_array('heading-text-align', $options['type'])) {
            $builder->add('heading-text-align', TextAlignType::class);
        }

        if(in_array('content-text-align', $options['type'])) {
            $builder->add('content-text-align', TextAlignType::class);
        }

        if(in_array('opacity', $options['type'])) {
            $builder->add('opacity', RangeType::class, ['empty_data' => 50, 'attr' => ['min' => 0, 'max' => 100, 'step' => 5]]);
        }

        if(in_array('theme', $options['type'])) {
            $builder->add('theme', ThemeType::class);
        }

        if(in_array('style', $options['type'])) {
            $builder->add('style', StyleType::class);
        }

        if(in_array('height', $options['type'])) {
            $builder->add('height', RangeType::class, ['empty_data' => 75, 'attr' => ['min' => 50, 'max' => 100, 'step' => 5]]);
        }

        if(in_array('width', $options['type'])) {
            $builder->add('width', WidthType::class);
        }

        if(in_array('zoom-effect', $options['type'])) {
            $builder->add('zoom-effect', CheckboxType::class, ['required' => false]);
        }

        if(in_array('background', $options['type'])) {
            $builder->add('background', BackgroundType::class);
        }

        if(in_array('blog-layout', $options['type'])) {
            $builder->add('blog-layout', BlogLayoutType::class);
        }

        if(in_array('limit', $options['type'])) {
            $builder->add('limit', TextType::class, ['empty_data'=>'3', 'required'=>false]);
        }

        if(in_array('container', $options['type'])) {
            $builder->add('container', ContainerLayoutType::class);
        }

        if(in_array('swiper', $options['type'])) {
            $builder->add('swiper', CheckboxType::class, ['required' => false]);
        }

        if(in_array('frontend-form-type', $options['type'])) {
            $builder->add('frontend-form-type', FrontendFormTypeType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'type' => ['text-align']
        ]);
    }
}