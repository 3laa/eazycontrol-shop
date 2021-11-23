<?php

namespace App\Form\Entity\Website\Section\FrontendForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactUsProfiFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => new Length(['min' => 3])
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ]
            ])
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('privacy', CheckboxType::class, [
                'label' => 'By submitting your request, you consent to the processing of your specified data for the purpose of processing your request (see our privacy policy).',
                'constraints' => [
                    new IsTrue(),
                ]
            ])
            ;
    }
}
