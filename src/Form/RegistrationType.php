<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'input',
                    'minlenght' => '2',
                    'maxlenght' => '50'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'input',
                    'minlenght' => '2',
                    'maxlenght' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input',
                    'minlenght' => '2',
                    'maxlenght' => '180'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])
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
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class' => 'btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
