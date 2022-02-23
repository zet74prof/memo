<?php

namespace App\Form;

use App\Entity\Apprenant;
use App\Entity\Bailleur;
use App\Entity\NiveauFormation;
use App\Entity\Prescripteur;
use App\Entity\QPV;
use App\Entity\Ressource;
use App\Entity\Site;
use App\Entity\SituationFamiliale;
use App\Entity\Status;
use App\Entity\TypeFormation;
use App\Entity\TypeHebergement;
use Doctrine\ORM\EntityRepository;
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

class ApprenantType extends AbstractType
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
        if($apprenant->getAddressHistos()->last())
        {
            $currentAddress = $apprenant->getAddressHistos()->last()->getAddress();
            $currentPostalCode = $apprenant->getAddressHistos()->last()->getPostalCode();
            $currentCity = $apprenant->getAddressHistos()->last()->getCity();
        }
        else
        {
            $currentAddress = null;
            $currentPostalCode = null;
            $currentCity = null;
        }
        if($apprenant->getQPVHistos()->last())
        {
            $currentQPV = $apprenant->getQPVHistos()->last()->getQpv();
        }
        else
        {
            $currentQPV = null;
        }
        if($apprenant->getBailleurHistos()->last())
        {
            $currentBailleur = $apprenant->getBailleurHistos()->last()->getBailleur();
        }
        else
        {
            $currentBailleur = null;
        }
        if($apprenant->getStatusHistos()->last())
        {
            $currentStatus = $apprenant->getStatusHistos()->last()->getStatus();
        }
        else
        {
            $currentStatus = null;
        }
        if($apprenant->getRessourceHistos()->last())
        {
            $currentRessource = $apprenant->getRessourceHistos()->last()->getRessource();
        }
        else
        {
            $currentRessource = null;
        }
        if($apprenant->getPrescripteurHistos()->last())
        {
            $currentPrescripteur = $apprenant->getPrescripteurHistos()->last()->getPrescripteur();
        }
        else
        {
            $currentPrescripteur = null;
        }
        if ($apprenant->getSiteHisto()->last())
        {
            $currentSites = $apprenant->getSiteHisto()->last()->getSites();
        }
        else
        {
            $currentSites = [];
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
                'label' => 'Nom de jeune fille',
                'required' => false,
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
                'label' => 'Pays d\'origine',
                'data' => 'FR',
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité'
            ])
            ->add('motherTongue', TextType::class, [
                'label' => 'Langue maternelle'
            ])
            ->add('dateOfArrivalFR', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'arrivée en France',
                'required' => false,
            ])
            ->add('tel1', TelType::class, [
                'required' => false,
                'label' => 'Téléphone principal',
            ])
            ->add('tel2', TelType::class, [
                'required' => false,
                'label' => 'Téléphone secondaire',
            ])
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('otherContact', TextareaType::class, [
                'label' => 'Autre contact',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'address_auto_filled'],
                'mapped' => false,
                'data' => $currentAddress,
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['class' => 'postalCode_auto_filled'],
                'mapped' => false,
                'data' => $currentPostalCode,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'city_auto_filled'],
                'mapped' => false,
                'data' => $currentCity,
            ])
            ->add('typeHebergement', EntityType::class, [
                'label' => 'Si hébergé',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'choice_label' => 'name',
                'class' => TypeHebergement::class,
                'required' => false,
            ])
            ->add('qpv', EntityType::class, [
                'class' => QPV::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('q')
                        ->where('q.active = TRUE')
                        ->orderBy('q.qpvName', 'ASC');
                },
                'choice_label' => 'qpvName',
                'label' => 'QPV',
                'mapped' => false, //mapped set to false because QPV is not an attribute of Apprenant class
                'data' => $currentQPV,
            ])
            ->add('bailleur', EntityType::class, [
                'class' => Bailleur::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->where('b.active = TRUE')
                        ->orderBy('b.name', 'ASC');
                },
                'label' => 'Bailleur',
                'choice_label' => 'name',
                'mapped' => false, //mapped set to false because Bailleur is not an attribute of Apprenant class
                'data' => $currentBailleur,
            ])
            ->add('socialSecurityNumber', TextType::class, [
                'label' => 'N° de sécurité sociale',
                'required' => false,
            ])
            ->add('situationFamiliale', EntityType::class, [
                'class' => SituationFamiliale::class,
                'choice_label' => 'name',
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
                'label' => 'Personne à contacter en cas d\'urgence',
                'required' => false,
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.active = TRUE');
                },
                'choice_label' => 'statusName',
                'label' => 'Type d\'activité',
                'mapped' => false, //mapped set to false because status is not an attribute of Apprenant class
                'data' => $currentStatus,
            ])
            ->add('status_extrainfo', TextareaType::class, [
                'label' => 'Détails du type d\'activité',
                'required' => false,
                'mapped' => false,
                'attr' => ['placeholder' => 'Nom de l\'employeur, poste occupé, date d\'inscription à Pôle Emploi, Identifiants Pôle Emploi, etc...'],
            ])
            ->add('ressource', EntityType::class, [
                'class' => Ressource::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.active = TRUE');
                },
                'choice_label' => 'ressourceName',
                'label' => 'Ressources',
                'mapped' => false, //mapped set to false because ressource is not an attribute of Apprenant class
                'data' => $currentRessource,
            ])
            ->add('prescripteur', EntityType::class, [
                'class' => Prescripteur::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.active = TRUE')
                        ->orderBy('p.prescripteurName', 'ASC');
                },
                'choice_label' => 'prescripteurName',
                'label' => 'Prescripteur',
                'placeholder' => '',
                'mapped' => false, //mapped set to false because prescripteur is not an attribute of Apprenant class
                'data' => $currentPrescripteur,
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.active = TRUE')
                        ->orderBy('s.siteName', 'ASC');
                },
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
            ->add('welcomeBy', TextType::class, [
                'label' => 'Accueil fait par'
            ])
            ->add('comment', TextType::class, [
                'required' => false,
                'label' => 'Commentaires additionnels',
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
