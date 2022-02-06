<?php

namespace App\Controller;

use App\Entity\AddressHisto;
use App\Entity\Apprenant;
use App\Entity\BailleurHisto;
use App\Entity\NivFormHisto;
use App\Entity\PrescripteurHisto;
use App\Entity\QPVHisto;
use App\Entity\RessourceHisto;
use App\Entity\SiteHisto;
use App\Entity\StateHisto;
use App\Entity\StatusHisto;
use App\Form\ApprenantType;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/apprenant')]
class ApprenantController extends AbstractController
{
    #[Route('/', name: 'apprenant_index', methods: ['GET'])]
    public function index(ApprenantRepository $apprenantRepository): Response
    {
        return $this->render('apprenant/index.html.twig', [
            'apprenants' => $apprenantRepository->findAllCurrentActive(),
        ]);
    }

    #[Route('/inactifs', name: 'apprenant_inactive', methods: ['GET'])]
    public function inactive(ApprenantRepository $apprenantRepository): Response
    {
        return $this->render('apprenant/index.html.twig', [
            'apprenants' => $apprenantRepository->findAllCurrentInactive(),
        ]);
    }

    #[Route('/enpause', name: 'apprenant_inpause', methods: ['GET'])]
    public function inPause(ApprenantRepository $apprenantRepository): Response
    {
        return $this->render('apprenant/index.html.twig', [
            'apprenants' => $apprenantRepository->findAllCurrentInPause(),
        ]);
    }

    #[Route('/validation', name: 'apprenant_invalidation', methods: ['GET'])]
    public function inValidation(ApprenantRepository $apprenantRepository): Response
    {
        return $this->render('apprenant/index.html.twig', [
            'apprenants' => $apprenantRepository->findAllCurrentInValidation(),
        ]);
    }

    #[Route('/new', name: 'apprenant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $apprenant = new Apprenant();
        $apprenant->setRoles(['ROLE_APPRENANT']);
        $form = $this->createForm(ApprenantType::class, $apprenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $apprenant->setPassword(
                $passwordHasher->hashPassword(
                    $apprenant,
                    'motsetmerveilles@59%ApprenantPwd'
                )
            );

            $apprenant->setUsername($form->get('firstname')->getData() . '.' . $form->get('surname')->getData());
            $apprenant->CleanUserName();

            $siteHisto = $apprenant->setSitesWithHisto($form->get('site')->getData());
            //on créé un objet StateHisto pour stocker le premier état 'actif' dans l'historique d'état
            $state = new StateHisto(new \DateTime('now'),1,'Création');
            $state->setUser($apprenant);
            $address = new AddressHisto(new \DateTime('now'), $form->get('address')->getData(), $form->get('postalCode')->getData(), $form->get('city')->getData());
            $address->setUser($apprenant);
            $qpv = new QPVHisto(new \DateTime('now'),$form->get('qpv')->getData());
            $qpv->setUser($apprenant);
            $bailleur = new BailleurHisto(new \DateTime('now'), $form->get('bailleur')->getData());
            $bailleur->setUser($apprenant);
            $status = new StatusHisto(new \DateTime('now'),$form->get('status')->getData());
            $status->setExtraInfo($form->get('status_extrainfo')->getData());
            $status->setUser($apprenant);
            $ressource = new RessourceHisto(new \DateTime('now'),$form->get('ressource')->getData());
            $ressource->setApprenant($apprenant);
            $prescripteur = new PrescripteurHisto(new \DateTime('now'),$form->get('prescripteur')->getData());
            $prescripteur->setApprenant($apprenant);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($apprenant);
            $entityManager->persist($state);
            $entityManager->persist($address);
            $entityManager->persist($qpv);
            $entityManager->persist($bailleur);
            $entityManager->persist($status);
            $entityManager->persist($ressource);
            $entityManager->persist($prescripteur);
            $entityManager->persist($siteHisto);
            $entityManager->flush();

            return $this->redirectToRoute('apprenant_index');
        }

        return $this->renderForm('apprenant/new.html.twig', [
            'apprenant' => $apprenant,
            'form' => $form,
            'create' => true,
        ]);
    }

    #[Route('/{id}', name: 'apprenant_show', methods: ['GET'])]
    public function show(Apprenant $apprenant): Response
    {
        return $this->render('apprenant/show.html.twig', [
            'apprenant' => $apprenant,
        ]);
    }

    #[Route('/{id}/edit', name: 'apprenant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apprenant $apprenant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApprenantType::class, $apprenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteHisto = $apprenant->setSitesWithHisto($form->get('site')->getData());
            $state = $apprenant->setStateWithHisto($form->get('state')->getData(), $form->get('state_reason')->getData());
            $address = $apprenant->setAddressWithHisto($form->get('address')->getData(), $form->get('postalCode')->getData(), $form->get('city')->getData());
            $qpv = $apprenant->setQPVWithHisto($form->get('qpv')->getData());
            $bailleur = $apprenant->setBailleurWithHisto($form->get('bailleur')->getData());
            $status = $apprenant->setStatusWithHisto($form->get('status')->getData());
            $status->setExtraInfo($form->get('status_extrainfo')->getData());
            $ressource = $apprenant->setRessourceWithHisto($form->get('ressource')->getData());
            $prescripteur = $apprenant->setPrescripteurWithHisto($form->get('prescripteur')->getData());
            $entityManager->persist($apprenant);
            if ($state != null)
            {
                $entityManager->persist($state);
            }
            if ($address != null)
            {
                $entityManager->persist($address);
            }
            if($qpv != null)
            {
                $entityManager->persist($qpv);
            }
            if ($bailleur != null)
            {
                $entityManager->persist($bailleur);
            }
            if ($status != null)
            {
                $entityManager->persist($status);
            }
            if ($ressource != null)
            {
                $entityManager->persist($ressource);
            }
            if ($prescripteur != null)
            {
                $entityManager->persist($prescripteur);
            }
            if ($siteHisto != null)
            {
                $entityManager->persist($siteHisto);
            }
            $entityManager->flush();

            return $this->redirectToRoute('apprenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apprenant/edit.html.twig', [
            'apprenant' => $apprenant,
            'form' => $form,
            'create' => false,
        ]);
    }

    #[Route('/{id}', name: 'apprenant_delete', methods: ['POST'])]
    public function delete(Request $request, Apprenant $apprenant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apprenant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($apprenant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('apprenant_index', [], Response::HTTP_SEE_OTHER);
    }
}
