<?php

namespace App\Controller;

use App\Entity\Benevole;
use App\Entity\NivFormHisto;
use App\Entity\SiteHisto;
use App\Entity\StateHisto;
use App\Form\BenevoleType;
use App\Repository\BenevoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/benevole')]
class BenevoleController extends AbstractController
{
    #[Route('/', name: 'benevole_index', methods: ['GET'])]
    public function index(BenevoleRepository $benevoleRepository): Response
    {
        return $this->render('benevole/index.html.twig', [
            'benevoles' => $benevoleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'benevole_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $benevole = new Benevole();
        $benevole->setRoles(['ROLE_BENEVOLE']);
        $form = $this->createForm(BenevoleType::class, $benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $benevole->setPassword(
                $passwordHasher->hashPassword(
                    $benevole,
                    //récupère la saisi utilisateur
                    $form->get('plainPassword')->getData()
                )
            );
            $siteHisto = new SiteHisto();
            $siteHisto->setUser($benevole);
            //on récupère la liste des sites (un tableau d'objets de la classe Site) pour l'ajouter à l'objet SiteHisto
            //et on vient persister cet objet SiteHisto ce qui permet de conserver l'historique des modifs
            $sites = $form->get('site')->getData();
            foreach ($sites as $site)
            {
                $siteHisto->addSite($site);
            }
            $siteHisto->setDate(new \DateTime('now'));
            //on créé un objet StateHisto pour stocker le premier état 'actif' dans l'historique de statut
            $state = new StateHisto(new \DateTime('now'),true,'Création');
            $state->setUser($benevole);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($benevole);
            $entityManager->persist($state);
            $entityManager->persist($siteHisto);

            $entityManager->flush();

            return $this->redirectToRoute('benevole_index',);
        }

        return $this->renderForm('benevole/new.html.twig', [
            'benevole' => $benevole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'benevole_show', methods: ['GET'])]
    public function show(Benevole $benevole): Response
    {
        return $this->render('benevole/show.html.twig', [
            'benevole' => $benevole,
        ]);
    }

    #[Route('/{id}/edit', name: 'benevole_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Benevole $benevole, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BenevoleType::class, $benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('benevole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('benevole/edit.html.twig', [
            'benevole' => $benevole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'benevole_delete', methods: ['POST'])]
    public function delete(Request $request, Benevole $benevole, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$benevole->getId(), $request->request->get('_token'))) {
            $entityManager->remove($benevole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('benevole_index', [], Response::HTTP_SEE_OTHER);
    }
}
