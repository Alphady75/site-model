<?php

namespace App\Form\Dto;

use App\Entity\Dto\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Je cherche ?",
                    'class' => "bg-white",
                ],
                'required' => false,
            ])
            ->add('limit', ChoiceType::class, [
                'placeholder' => false,
                'label' => false,
                'choices' => [
                    'Affichage de 25' => 25,
                    'Affichage de 30' => 30,
                    'Affichage de 40' => 40,
                    'Affichage de 50' => 50,
                    'Affichage de 60' => 60,
                ],
                'required' => false,
            ])
            ->add('compte', ChoiceType::class, [
                'placeholder' => "Tous les comptes",
                'label' => false,
                'choices' => [
                    'ADMINISTRATEUR' => 'ADMIN',
                    'actionnaireL (CLIENT)' => 'CLIENT',
                ],
                'required' => false,
            ])
            ->add('isVerified', ChoiceType::class, [
                'placeholder' => "Statut compte",
                'label' => false,
                'choices' => [
                    'Email non vérifiée' => 0,
                    'Email vérifiée' => 1,
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
