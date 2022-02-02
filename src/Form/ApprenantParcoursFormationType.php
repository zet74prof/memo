<?php

namespace App\Form;

use App\Entity\Apprenant;
use App\Entity\Bailleur;
use App\Entity\NiveauFormation;
use App\Entity\Prescripteur;
use App\Entity\QPV;
use App\Entity\Ressource;
use App\Entity\Site;
use App\Entity\Status;
use App\Entity\TypeFormation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ApprenantParcoursFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //we get the current sites of the Appenant to compare to the list of sites and check the ones he belong to
        $apprenant = $options['data'];
        //test if user exists already or not (creation)
        if($apprenant->getStateHisto()->last())
        {
            $currentState = $apprenant->getStateHisto()->last()->getState();
        }
        else
        {
            $currentState = 1;
        }
        if($apprenant->getStatusHistos()->last())
        {
            $currentStatus = $apprenant->getStatusHistos()->last()->getStatus();
        }
        else
        {
            $currentStatus = null;
        }
        if($apprenant->getQPVHistos()->last())
        {
            $currentQPV = $apprenant->getQPVHistos()->last()->getQpv();
        }
        else
        {
            $currentQPV = null;
        }
        if ($apprenant->getSiteHisto()->last())
        {
            $currentSites = $apprenant->getSiteHisto()->last()->getSites();
        }
        else
        {
            $currentSites = [];
        }
        if($apprenant->getNiveauFormationHistos()->last())
        {
            $currentNiveauFormation = $apprenant->getNiveauFormationHistos()->last()->getNiveauFormation();
        }
        else
        {
            $currentNiveauFormation = null;
        }

        $builder
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'Validation' => 1,
                    'Actif' => 2,
                    'Inactif' => 3,
                    'Pause' => 4
                ],
                'label' => 'Etat',
                'mapped' => false,
                'data' => $currentState,
            ])
            ->add('state_reason', TextType::class, [
                'label' => 'Indiquer la raison du changement d\'état',
                'required' => false,
                'mapped' => false,
            ])
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Madame' => 'F',
                    'Monsieur' => 'M',
                ],
                'label' => 'Genre'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('maidenName', TextType::class, [
                'label' => 'Nom de jeune fille'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
            ])
            ->add('birthCity', TextType::class, [
                'label' => 'Ville de naissance'
            ])
            ->add('countryOfOrigin', CountryType::class, [
                'label' => 'Pays d\'origine'
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité'
            ])
            ->add('motherTongue', TextType::class, [
                'label' => 'Langue maternelle'
            ])
            ->add('dateOfArrivalFR', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'arrivée en France'
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
            ->add('otherContact', TextareaType::class, [
                'label' => 'Autre contact'
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
            ->add('qpv', EntityType::class, [
                'class' => QPV::class,
                'choice_label' => 'qpvName',
                'label' => 'QPV',
                'mapped' => false, //mapped set to false because QPV is not an attribute of Apprenant class
                'data' => $currentQPV,
            ])
            ->add('bailleur', EntityType::class, [
                'class' => Bailleur::class,
                'label' => 'Bailleur',
                'choice_label' => 'name'
            ])
            ->add('socialSecurityNumber', TextType::class, [
                'label' => 'N° de sécurité sociale'
            ])
            ->add('situationFamiliale', ChoiceType::class, [
                'choices' => [
                    'Personne seule sans enfant' => 1,
                    'Personne seule avec enfant(s)' => 2,
                    'Couple sans enfant' => 3,
                    'Couple avec enfant(s)' => 4
                ],
                'label' => 'Situation familiale',
            ])
            ->add('nbEnfant', IntegerType::class, [
                'empty_data' => 0,
                'label' => 'Nombre d\'enfants'
            ])
            ->add('enfantACharge', IntegerType::class, [
                'empty_data' => 0,
                'label' => 'Nombre d\'enfants à charge'
            ])
            ->add('emergencyContact', TextareaType::class, [
                'label' => 'Personne à contacter en cas d\'urgence'
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'statusName',
                'label' => 'Statut',
                'mapped' => false, //mapped set to false because status is not an attribute of Apprenant class
                'data' => $currentStatus,
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'siteName',
                'expanded' => true,
                'multiple' => true,
                'mapped' => false, //mapped set to false because site is not an attribute of User class
                //while displaying all sites as checkboxes, we check the checkboxes of the current sites
                'choice_attr' => function ($site, $key, $index) use ($currentSites) {
                    $selected = false;
                    foreach ($currentSites as $cs)
                    {
                        if ($site == $cs) {
                            $selected = true;
                        }
                    }
                    return ['checked' => $selected];
                }
            ])
            ->add('ressource', EntityType::class, [
                'class' => Ressource::class,
                'choice_label' => 'ressourceName',
                'label' => 'Ressources',
            ])
            ->add('typeFormation', EntityType::class, [
                'class' => TypeFormation::class,
                'choice_label' => 'formationName',
                'label' => 'Type de formation',
            ])
            ->add('prescripteur', EntityType::class, [
                'class' => Prescripteur::class,
                'choice_label' => 'prescripteurName',
                'label' => 'Prescripteur',
            ])
            ->add('niveauFormation', EntityType::class, [
                'class' => NiveauFormation::class,
                'choice_label' => 'nivFormName',
                'label' => 'Niveau de formation',
                'mapped' => false, //mapped set to false because niveauFormation is not an attribute of Apprenant class
                'data' => $currentNiveauFormation,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apprenant::class,
        ]);
    }
}
