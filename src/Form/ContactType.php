<?php

namespace App\Form;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $local = $options['local'];

        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre nom',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "E-mail",
                'attr' => [
                    'placeholder' => 'E-mail',
                ],
                'constraints' => [
                    new Email()
                ]
            ])
            ->add('sujet', EntityType::class, [
                'label' => 'raison',
                'placeholder' => 'choisir',
                'class' => Service::class,
                'query_builder' => function (ServiceRepository $eleve): QueryBuilder {
                    return $eleve->createQueryBuilder('s')
                        ->andWhere('s.online = 1')
                        ->orderBy('s.position', 'ASC');
                },
                'choice_label' => $local == 'en' ? 'nameEn' : 'name',
                'attr' => [
                    'placeholder' => 'raison',
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Ecrivez votre message...',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'local' => null
        ]);
    }
}
