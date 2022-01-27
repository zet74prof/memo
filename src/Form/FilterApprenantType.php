<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Territoire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterApprenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('territoire', EntityType::class, [
                'class' => Territoire::class,
                'choice_label' => 'name',
                'placeholder' => 'Tous',
                'required' => false,
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'siteName',
                'placeholder' => 'Tous',
                'required' => false,
            ])
            ->add('dateDeb', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'data' => new \DateTime('now'),
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'data' => new \DateTime('now'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
