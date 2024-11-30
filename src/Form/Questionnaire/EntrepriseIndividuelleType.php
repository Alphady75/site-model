<?php

namespace App\Form\Questionnaire;

use App\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntrepriseIndividuelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civilite', ChoiceType::class, [
                "placeholder" => "Civilité",
                'label' => "Civilité",
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madamme' => 'Madamme',
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('fondateur', TextType::class, [
                'label' => "Nom et prénom du promoteur",
                'attr' => ['placeholder' => "Nom et prénom du promoteur"],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('profession', TextType::class, [
                'label' => "Profession du promoteur",
                'attr' => ['placeholder' => "Profession du promoteur"],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nomCommercial', TextType::class, [
                'label' => "NOM COMMERCIAL",
                'attr' => ['placeholder' => 'NOM COMMERCIAL...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('objetsocial', TextareaType::class, [
                'label' => "OBJET SOCIAL (activités)",
                'attr' => ['placeholder' => 'Objet sociale...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('sitmat', ChoiceType::class, [
                "placeholder" => "Choix...",
                'label' => "SITUATION MATRIMONIALE",
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Marié(e)' => 'Marié(e)',
                    'Divorcé(e)' => 'Divorcé(e)',
                    'Veuf(ve)' => 'Veuf(ve)',
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('prestelephone', TextType::class, [
                'label' => "N° Téléphone",
                'attr' => ['placeholder' => 'N° Téléphone'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}
