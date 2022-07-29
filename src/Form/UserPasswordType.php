<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,

                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'input',
                    ],
                    'label_attr' => [
                        'class' => 'label'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'class' => 'input mb-2',
                    ],
                    'label_attr' => [
                        'class' => 'label'
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('newPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'input mb-4',
                ],
                'label' => 'Nouveau mot de passe',
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Modifier",
                'attr' => [
                    'class' => 'btn'
                ]
            ])
        ;
    }
}