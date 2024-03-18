<?php

namespace App\Form;

use App\Entity\Architecture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArchitectureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'video' => 'vidéo',
                    'image' => 'image'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => ''],
            ])
            ->add('videoId', TextType::class, [
                'label' => "Identifiant de la vidéo youtube",
                'required'  =>  false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Architecture::class,
        ]);
    }
}
