<?php

namespace App\Form\Admin;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => "Titre..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('siteUrl', TextType::class, [
                'label' => 'Site web',
                'attr' => ['placeholder' => "Site web..."],
                'required' => false
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'thumb',
                'attr'   =>  ['class' => 'picture'],
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'help' => "Ce partenaire sera visible ou invisible sur le site si vous ne cochez pas",
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
