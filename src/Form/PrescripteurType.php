<?php

namespace App\Form;

use App\Entity\Prescripteur;
use App\Entity\Territoire;
use App\Entity\TypePrescripteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescripteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => TypePrescripteur::class,
                'label' => 'Type de prescripteur',
                'choice_label' => 'name'
            ])
            ->add('prescripteurName',  TextType::class, [
                'label' => 'Nom du prescripteur'])
            ->add('respName',  TextType::class, [
                'label' => 'Nom du responsable'])
            ->add('address',  TextType::class, [
                'label' => 'adresse'])
            ->add('postalCode',  TextType::class, [
                'label' => 'code postal'])
            ->add('city',  TextType::class, [
                'label' => 'ville'])
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('tel', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
            ])
            ->add('territoire', EntityType::class, [
                'class' => Territoire::class,
                'choice_label' => 'name',
                'label' => 'Territoire'
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescripteur::class,
        ]);
    }
}
