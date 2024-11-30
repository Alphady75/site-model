<?php

namespace App\Form\Fiche;

use App\Entity\Fiche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class FichePersonnelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civilite', ChoiceType::class, [
                'label' => "Civilité",
                "placeholder" => "Choix...",
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madamme' => 'Madamme'
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'attr' => ['placeholder' => 'Nom...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => "Prénoms (Dans l'ordre de l'Etat civil)",
                'attr' => ['placeholder' => "Prénoms (dans l'ordre de l'Etat civil)..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => "Date de naissance",
                'widget' => "single_text",
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('dateLettre', TextType::class, [
                'label' => "Date de naissance en lettre",
                'attr' => ['placeholder' => 'Date de naissance en lettre...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('lieuNaissance', TextType::class, [
                'label' => "Lieu de naissance",
                'attr' => ['placeholder' => 'Lieu de naissance...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nationalite', TextType::class, [
                'label' => "Nationalité",
                'attr' => ['placeholder' => 'Nationalité...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('profession', TextType::class, [
                'label' => "Profession",
                'attr' => ['placeholder' => 'Profession...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => "Adresse",
                'attr' => ['placeholder' => 'Adresse...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
                'attr' => ['placeholder' => 'Email...'],
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => "Téléphone",
                'attr' => ['placeholder' => 'Téléphone...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('typePiece', ChoiceType::class, [
                'label' => "Type",
                "placeholder" => "Choix...",
                'choices' => [
                    'CNI' => 'CNI',
                    'Passeport' => 'Passeport'
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('numPiece', TextType::class, [
                'label' => "Numéro",
                'attr' => ['placeholder' => "Numéro de la pièce d'identité"],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('pieceDelivre', DateType::class, [
                'label' => "Délivré le",
                'widget' => "single_text",
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('sitMat', ChoiceType::class, [
                'label' => "Statut Matrimonial",
                "placeholder" => "Choix...",
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
            ->add('regimeMat', TextType::class, [
                'label' => "Régime Matrimonial",
                'attr' => ['placeholder' => 'Ex: Séparation des Biens...'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fiche::class,
        ]);
    }
}
