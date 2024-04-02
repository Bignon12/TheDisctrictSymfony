<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


        ->add('email', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'adresse mail...'
            ],
            'label' => 'Email',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('Password', PasswordType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Mot de passe...'
            ],
            'label' => 'Mot de Passe',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('nom', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('prenom', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Prénoms',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('telephone', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Numéro de Téléphone',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('adresse', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Adresse',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])
        
        ->add('cp', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Code Postal',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('ville', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Ville',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]   
        ])

        ->add('save', SubmitType::class, [
            'label' => 'Envoyer le message',
            'attr' => [
                'class' => 'class="btn btn-success mt-4'
            ]
        ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
