<?php

namespace App\Form;

use App\Entity\Enfant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnfantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('surname')
            ->add('firstname')
            ->add('title')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('birthDate')
            ->add('tel1')
            ->add('tel2')
            ->add('comment')
            ->add('email')
            ->add('typeReferent')
            ->add('etablissementScolaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enfant::class,
        ]);
    }
}
