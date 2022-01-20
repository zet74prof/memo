<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\NivFormHisto;
use App\Entity\SiteHisto;
use App\Entity\StateHisto;
use App\Entity\StatusHisto;
use App\Form\ApprenantType;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            'apprenants' => $apprenantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'apprenant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher): Response
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
                    //récupère la saisi utilisateur
                    $form->get('plainPassword')->getData()
                )
            );

            $siteHisto = $apprenant->setSitesWithHisto($form->get('site')->getData());
            //on créé un objet StateHisto pour stocker le premier état 'actif' dans l'historique de statut
            $state = new StateHisto(new \DateTime('now'),1,'Création');
            $state->setUser($apprenant);
            $status = new StatusHisto(new \DateTime('now'),$form->get('status')->getData());
            $status->setUser($apprenant);
            $niveauFormation = $form->get('niveauFormation')->getData();
            $nivFormHisto = new NivFormHisto();
            $nivFormHisto->setDate(new \DateTime('now'));
            $nivFormHisto->setApprenant($apprenant);
            $nivFormHisto->setNiveauFormation($niveauFormation);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apprenant);
            $entityManager->persist($state);
            $entityManager->persist($status);
            $entityManager->persist($siteHisto);
            $entityManager->persist($nivFormHisto);
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
            $status = $apprenant->setStatusWithHisto($form->get('status')->getData());

            $niveauFormation = $form->get('niveauFormation')->getData();
            $nivFormHisto = new NivFormHisto();
            $nivFormHisto->setDate(new \DateTime('now'));
            $nivFormHisto->setApprenant($apprenant);
            $nivFormHisto->setNiveauFormation($niveauFormation);

            $entityManager->persist($apprenant);
            if ($state != null)
            {
                $entityManager->persist($state);
            }
            if ($status != null)
            {
                $entityManager->persist($status);
            }
            if ($siteHisto != null)
            {
                $entityManager->persist($siteHisto);
            }
            $entityManager->persist($nivFormHisto);
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
