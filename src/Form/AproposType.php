<?php

namespace App\Form;

use App\Entity\Apropos;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email()
                ]
            ])
            ->add('telephone', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('whatsapp', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('bureau', TextType::class, [
                'label' => 'Bureau',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo du président',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => ''],
            ])
            ->add('photoFile', VichImageType::class, [
                'label' => "Photo de l'équipe",
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'midle',
                'attr'   =>  ['class' => ''],
            ])
            ->add('presentation', TextareaType::class, [
                "label" => false,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('anneeExperience', NumberType::class, [
                'label' => "Nombre d'années d'expérience",
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('communautes', CollectionType::class, [
                'entry_type' => CommunauteType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'Visible sur le site',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apropos::class,
        ]);
    }
}
