<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('telephone')
            ->add('periodeDemarage')
            ->add('marque')
            ->add('statutAe')
            ->add('domiciliation')
            ->add('banque')
            ->add('comptastart')
            ->add('nomSociete')
            ->add('professionDeclarant')
            ->add('societeExistante')
            ->add('typeActivite')
            ->add('validate')
            ->add('created')
            ->add('updated')
            ->add('user')
            ->add('service')
            ->add('tarification')
            ->add('activite')
            ->add('partenaire')
            ->add('statut')
            ->add('commande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
