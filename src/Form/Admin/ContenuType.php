<?php

namespace App\Form\Admin;

use App\Entity\Contenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'help' => 'Ex: Mission',
                'attr' => ['placeholder' => "Titre..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de contenu',
                'placeholder' => 'Choix...',
                'choices' => [
                    'Mission' => 'mission',
                    'Vision' => 'vision',
                    'Valeur' => 'valeur',
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icone',
                'help' => 'Ex: box (en minuscule)',
                'attr' => ['placeholder' => "Icone..."],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['placeholder' => "Lien..."],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contenu::class,
        ]);
    }
}
