<?php

namespace App\Form\Admin;

use App\Entity\DocumentJuridique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\Dropzone\Form\DropzoneType;

class DocumentType extends AbstractType
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
            ->add('documentFile', DropzoneType::class, [
                'attr' => ["placeholder" => "Sélectionnez un document..."],
                'label' => false,
                'required'  =>  false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentJuridique::class,
        ]);
    }
}
