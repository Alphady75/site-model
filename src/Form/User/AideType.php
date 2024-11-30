<?php

namespace App\Form\User;

use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sujet', ChoiceType::class, [
                'label' => "Votre question porte sur",
                'placeholder' => "Choix...",
                'choices' => [
                    "Une de vos démarches" => "Une de vos démarches",
                    "Un renseignement juridique" => "Un renseignement juridique",
                    "Une commande" => "Une commande",
                    "FAQ" => "FAQ",
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('demarche', EntityType::class, [
                'label' => "Sur quelle démarche porte votre question ?",
                'placeholder' => "Choix...",
                'class' => Statut::class,
                'attr' => ["placeholder" => "Prénom..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => "Veuillez rédiger votre message :",
                'attr' => ["placeholder" => "Veuillez rédiger votre message :...", 'class' => 'focus'],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
