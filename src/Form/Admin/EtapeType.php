<?php

namespace App\Form\Admin;

use App\Entity\Etape;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, [
                'label' => false,
                'placeholder' => "Choix...",
                'choices' => [
                    'En attente' => 'En attente',
                    'En cours' => 'En cours',
                    'En cours de validation' => 'Valider',
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('documentJuridiques', CollectionType::class, [
                'entry_type' => DocumentType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description, observation, conseils',
                'attr' => ['placeholder' => "Description, observation, conseils...", 'class' => "mce"],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
    }
}
