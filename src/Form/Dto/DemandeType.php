<?php

namespace App\Form\Dto;

use App\Entity\Dto\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Je cherche..."],
                'required' => false
            ])
            ->add('minDate', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'help' => "Entre",
                'required' => false,
                'attr'  =>  [
                    'class' =>  ''
                ]
            ])
            ->add('maxDate', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'help' => "Et",
                'required' => false,
                'attr'  =>  [
                    'class' =>  ''
                ]
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
