<?php

namespace App\Form\Admin;

use App\Entity\Statut;
use App\Entity\Tarification;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TarificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'attr' => ["placeholder" => "Titre..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('cout', NumberType::class, [
                'label' => 'Tarif',
                'attr' => ["placeholder" => "Tarif..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('typeCout', ChoiceType::class, [
                'label' => 'Type de tarif',
                "placeholder" => "Choix...",
                'choices' => [
                    'HT' => 'HT',
                    'TTC' => 'TTC',
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ["placeholder" => "Description..."],
                'required' => false
            ])
            ->add('statut', EntityType::class, [
                "placeholder" => "Choix...",
                'label' => 'Forme juridique',
                'class' => Statut::class,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('recommander', CheckboxType::class, [
                'label' => 'Recommander',
                'help' => 'Recommander cette formule aux utilisateur',
                'required' => false
            ])
            ->add('formules', CollectionType::class, [
                'entry_type' => FormuleType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'help' => "Cette formule sera visible ou invisible sur le site si vous ne cochez pas",
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarification::class,
        ]);
    }
}
