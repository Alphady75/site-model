<?php

namespace App\Form\Admin;

use App\Entity\Apropos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AproposType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('responsableName', TextType::class, [
                'label'   =>  "Nom du responsable (Fondateur, Directeur)",
                'attr'   =>  ['placeholder' => "Nom du responsable (Fondateur, Directeur)..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('mots', TextareaType::class, [
                'label'   =>  "Mot du responsable (Fondateur, Directeur)",
                'attr'   =>  ['placeholder' => "Mot du responsable (Fondateur, Directeur)"],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('name', TextType::class, [
                'label'   =>  "Nom de l'organisation",
                'attr'   =>  ['placeholder' => "Nom de l'organisation..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'attr'   =>  ['placeholder' => "Adresse e-mail..."],
                'constraints' => [
                    new Email()
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr'   =>  ['placeholder' => "Numéro de téléphone..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('donsOfferts', NumberType::class, [
                'attr'   =>  ['placeholder' => "Nombre de dons offerts..."],
                'required' => false
            ])
            ->add('donsRecus', NumberType::class, [
                'attr'   =>  ['placeholder' => "Nombre de dons reçu..."],
                'required' => false
            ])
            ->add('partenariats', NumberType::class, [
                'attr'   =>  ['placeholder' => "Nombre de partenariats..."],
                'required' => false
            ])
            ->add('projets', NumberType::class, [
                'attr'   =>  ['placeholder' => "Nombre de projets..."],
                'required' => false
            ])
            ->add('whatsapp', TextType::class, [
                'attr'   =>  ['placeholder' => "Numéro whatsapp..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('bureau', TextType::class, [
                'attr'   =>  ['placeholder' => "Adresse..."],
                'label' => 'Bureau',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('logoFile', VichImageType::class, [
                'label' => 'logo',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => 'picture'],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo du président',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => 'picture2'],
            ])
            ->add('photoFile', VichImageType::class, [
                'label' => "Photo de l'équipe",
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => 'picture3'],
            ])
            ->add('anneeExperience', TextType::class, [
                'label' => "Nombre d'années d'expérience",
                'attr'   =>  ['placeholder' => "Nombre d'années d'expérience..."],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('boitePostal', NumberType::class, [
                'label' => "Boite postal",
                'attr'   =>  ['placeholder' => "Boite de postal..."],
                'required' => false
            ])
            ->add('objectif', TextareaType::class, [
                'label' => "Objectif principal",
                'attr'   =>  ['placeholder' => "Objectif principal..."],
                'required' => false
            ])
            ->add('presentation', TextareaType::class, [
                'label'   => "Courte présentation de la structure",
                'attr'   =>  ['placeholder' => "Courte présentation de la structure..."],
                'label' => "Présentation",
                'required' => false
            ])
            ->add('apropos', TextareaType::class, [
                "label" => "A propos",
                "attr" => [
                    'class' => 'mce',
                    'placeholder' => "Boite de postal..."
                ],
                'required' => false
            ])
            ->add('communautes', CollectionType::class, [
                'entry_type' => CommunauteType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('contenus', CollectionType::class, [
                'entry_type' => ContenuType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apropos::class,
        ]);
    }
}
