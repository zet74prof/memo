<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Config\Monolog\HandlerConfig\EmailPrototypeConfig;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Gestionnaire' => 'ROLE_GESTIONNAIRE',
                    'Bénévole' => 'ROLE_BENEVOLE',
                    'Apprenant' => 'ROLE_APPRENANT',
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Roles',
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nom de famille',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Madame' => 'F',
                    'Monsieur' => 'M',
                ],
                'label' => 'Genre'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
            ])
            ->add('tel1', TelType::class, [
                'required' => false,
                'label' => 'Téléphone principal',
            ])
            ->add('tel2', TelType::class, [
                'required' => false,
                'label' => 'Téléphone secondaire',
            ])
            ->add('comment', TextType::class, [
                'required' => false,
                'label' => 'Commentaires additionnels',
            ])
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe',
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'siteName',
                'expanded' => true,
                'multiple' => true,
                'mapped' => false, //mapped set to false because site is not an attribute of User class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
