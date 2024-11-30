<?php

namespace App\Form\Admin;

use App\Entity\Temoignage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TemoignageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('noms', TextType::class, [
                'label' => "Nom(s) et prénom(s)",
                'attr' => ["placeholder" => "Nom(s) et prénom(s)..."],
                'constraints'   =>  [
                    new NotBlank()
                ],
            ])
            ->add('fonction', TextType::class, [
                'label' => "Fonction",
                'attr' => ["placeholder" => "Fonction..."],
                'constraints'   =>  [
                    new NotBlank()
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'attr' => ["placeholder" => "Commentaire..."],
                'constraints'   =>  [
                    new NotBlank()
                ],
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'help' => "Ce témoignage sera visible ou invisible sur le site si vous ne cochez pas",
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Temoignage::class,
        ]);
    }
}
