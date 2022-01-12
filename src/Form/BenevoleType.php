<?php

namespace App\Form;

use App\Entity\Benevole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BenevoleType extends AbstractType
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
            ->add('lien_type_enseignement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Benevole::class,
        ]);
    }
}
