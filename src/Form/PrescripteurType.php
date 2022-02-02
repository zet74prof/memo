<?php

namespace App\Form;

use App\Entity\Prescripteur;
use App\Entity\Territoire;
use App\Entity\TypePrescripteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescripteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prescripteurName')
            ->add('type', EntityType::class, [
                'class' => TypePrescripteur::class,
                'label' => 'Type de prescripteur',
                'choice_label' => 'name'
            ])
            ->add('territoire', EntityType::class, [
                'class' => Territoire::class,
                'choice_label' => 'name',
                'label' => 'Territoire'
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
