<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom et Prénoms',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]   
            ])

            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Votre Email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]   
            ])
            
            ->add('objet', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Objet du Message',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]   
            ])
            
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Votre Message',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false   
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer le message',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
