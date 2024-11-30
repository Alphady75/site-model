<?php

namespace App\Form\Demande;

use App\Entity\Demande;
use App\Service\CountryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateType extends AbstractType
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
            ->add('pays', ChoiceType::class, [
                'label' => false,
                'choices' => $this->countryService->getCountryFlagsWithPostalCodes(),
                'data' => "🇸🇳 +221",
                'choice_label' => function ($choice, $key, $value) {
                    return $value; // Affiche le nom, le drapeau et le code
                },
                'choice_attr' => function ($choice, $key, $value) {
                    return ['data-code' => $value];
                },
                'choice_value' => function ($value) {
                    return $value; // Le code pays sera la valeur
                },
            ])
            ->add('telephone', TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Téléphone..."],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
