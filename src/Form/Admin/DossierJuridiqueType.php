<?php

namespace App\Form\Admin;

use App\Entity\DossierJuridique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DossierJuridiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut', ChoiceType::class, [
                'label' => false,
                'placeholder' => "Choix...",
                'choices' => [
                    'En attente' => 'En attente',
                    'En cours' => 'En cours',
                    'Valider' => 'Valider',
                    'Rejeter' => 'Rejeter',
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('terminer', CheckboxType::class, [
                'label' => "Démarche terminer",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DossierJuridique::class,
        ]);
    }
}
