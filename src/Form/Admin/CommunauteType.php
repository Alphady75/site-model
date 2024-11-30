<?php

namespace App\Form\Admin;

use App\Entity\Communaute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommunauteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'help' => 'Ex: Facebook',
                'attr' => ['placeholder' => "Titre..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icone',
                'help' => 'Ex: facebook (en minuscule)',
                'attr' => ['placeholder' => "Icone..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('lien', TextType::class, [
                'attr' => ['placeholder' => "Lien..."],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Communaute::class,
        ]);
    }
}
