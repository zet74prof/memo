<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\SiteHisto;
use App\Entity\StateHisto;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApprenantRegistrationController extends AbstractController
{
    #[Route('/apprenant/register', name: 'apprenant_register')]

    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $apprenant = new Apprenant();
        $form = $this->createForm(UserType::class, $apprenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $apprenant->setPassword(
                $passwordHasher->hashPassword(
                    $apprenant,
                    $form->get('plainPassword')->getData()
                )
            );
            //on récupère le champ site (un objet de la classe Site) pour instancier un objet SiteHisto
            //et on vient persister cet objet SiteHisto ce qui permet de conserver l'historique des modifs
            $site = $form->get('site')->getData();
            $siteHisto = new SiteHisto();
            $siteHisto->setUser($apprenant);
            $siteHisto->setSite($site);
            $siteHisto->setDate(new \DateTime('now'));
            //on créé un objet StateHisto pour stocker le premier état 'actif' dans l'historique de statut
            $state = new StateHisto(new \DateTime('now'),true,'Création');
            $state->setUser($apprenant);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apprenant);
            $entityManager->persist($state);
            $entityManager->persist($siteHisto);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
