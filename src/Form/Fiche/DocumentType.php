<?php

namespace App\Form\Fiche;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\Dropzone\Form\DropzoneType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => "Type de document",
                'choices' => [
                    'PROCURATION' => 'PROCURATION',
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('fichierFile', DropzoneType::class, [
                'label' => 'Joindre un fichier',
                'attr' => [
                    'placeholder' => "Glissez déposez ou cliquez pour sélectionner l'image"
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
