<?php

namespace App\Form\Admin;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ServiceType extends AbstractType
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
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => 'picture'],
            ])
            ->add('resume', TextType::class, [
                'label' => "Description courte",
                'attr' => ["placeholder" => "Description courte..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                "attr" => [
                    'class' => 'mce',
                    "placeholder" => "Description..."
                ],
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'help' => "Ce service sera visible ou invisible sur le site si vous ne cochez pas",
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
