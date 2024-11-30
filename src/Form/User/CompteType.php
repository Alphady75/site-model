<?php

namespace App\Form\User;

use App\Entity\User;
use App\Service\CountryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CompteType extends AbstractType
{
    public function __construct(private CountryService $countryService)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Prénom..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Nom..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ["placeholder" => "E-mail..."],
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Téléphone..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('pays', ChoiceType::class, [
                'label' => false,
                'choices' => $this->countryService->getCountryFlagsWithPostalCodes(),
                'choice_label' => function ($choice, $key, $value) {
                    return $value; // Affiche le nom, le drapeau et le code
                },
                'choice_value' => function ($value) {
                    return $value; // Le code pays sera la valeur
                },
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Mot de passe',],
                    'constraints' => [
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => "Confirmer le mot de passe", 'class' => 'focus'],
                    'label' => 'Confirmer le mot de passe',
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
