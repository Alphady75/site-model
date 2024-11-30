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

class GieType extends AbstractType
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
            ->add('fondateur3', TextType::class, [
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
            ->add('president', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom et prénom du Président...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('prestelephone', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'N° Téléphone du Président...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('sectadmin', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom et prénom du Secrétaire Administratif...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('sectadmintelephone', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'N° Téléphone du Secrétaire Administratif...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('tresorier', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom et prénom du Trésorier Général...'],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('tresoriertelephone', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'N° Téléphone du Trésorier Général...'],
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
