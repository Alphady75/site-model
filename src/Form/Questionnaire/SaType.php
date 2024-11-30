<?php

namespace App\Form\Questionnaire;

use App\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fondateur', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => '...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('fondateur2', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => '...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('denomination', TextType::class, [
                'label' => "DENOMINATION",
                'attr' => ['placeholder' => 'Dénomination...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('duree', TextType::class, [
                'label' => "DUREE (99 maximum)",
                'attr' => ['placeholder' => 'DUREE (99 maximum)...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('siegesociale', TextType::class, [
                'label' => "SIEGE SOCIALE",
                'attr' => ['placeholder' => 'SIEGE SOCIALE...'],
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
            ->add('capitalsocial', TextType::class, [
                'label' => "CAPITAL SOCIAL",
                'attr' => ['placeholder' => 'CAPITAL SOCIAL...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('numeraires', TextType::class, [
                'label' => "Numéraires ",
                'attr' => ['placeholder' => 'Numéraires ...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nature', TextType::class, [
                'label' => "Nature ",
                'attr' => ['placeholder' => 'Nature ...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('industrie', TextType::class, [
                'label' => "Industrie",
                'attr' => ['placeholder' => 'Industrie...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('part', TextType::class, [
                'label' => "Divisé en",
                'attr' => ['placeholder' => 'Divisé en...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('partintervale', ChoiceType::class, [
                'label' => "Intervale",
                'required' => false,
                'placeholder' => false,
                'expanded' => true,
                'choices' => [
                    5000 => 5000,
                    10000 => 10000
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('actionnaire', TextType::class, [
                'label' => "Nom(s) et prénom(s)",
                'attr' => ['placeholder' => 'actionnaire 1...'],
                'required' => false
            ])
            ->add('actionnairepart', NumberType::class, [
                'label' => "%",
                'attr' => ['placeholder' => 'Pourcentage...'],
                'required' => false
            ])
            ->add('actionnaire2', TextType::class, [
                'label' => "Nom(s) et prénom(s)",
                'attr' => ['placeholder' => 'actionnaire 1...'],
                'required' => false
            ])
            ->add('actionnaire2part', NumberType::class, [
                'label' => "%",
                'attr' => ['placeholder' => 'Pourcentage...'],
                'required' => false
            ])
            ->add('modeAdmin', ChoiceType::class, [
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    "Conseil d’administration (entre 3 et 12 membres) avec PDG ou PCA et DG" => "Conseil d’administration (entre 3 et 12 membres) avec PDG ou PCA et DG",
                    "Administrateur général" => "Administrateur général"
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('etatCivilNom', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('commissaireTitulaire', TextType::class, [
                'label' => "Commissaire aux comptes titulaire",
                'attr' => ['placeholder' => 'Commissaire aux comptes titulaire...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('commissaireSuppleant', TextType::class, [
                'label' => "Commissaire aux comptes suppléant",
                'attr' => ['placeholder' => 'Commissaire aux comptes suppléant...'],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}
