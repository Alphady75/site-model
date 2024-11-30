<?php

namespace App\Form\Fiche;

use App\Entity\Fiche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\Dropzone\Form\DropzoneType;

class EditPieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('rectoFile', DropzoneType::class, [
                'label' => 'Recto',
                'attr' => [
                    'placeholder' => "Glissez déposez ou cliquez pour sélectionner l'image"
                ],
                'required'  =>  false,
            ])
            ->add('versoFile', DropzoneType::class, [
                'label' => 'Verso (Pour les CNI uniquement)',
                'attr' => [
                    'placeholder' => "Glissez déposez ou cliquez pour sélectionner l'image"
                ],
                'required'  =>  false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fiche::class,
        ]);
    }
}
