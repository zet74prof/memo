<?php

namespace App\Controller;

use App\Entity\EtablissementScolaire;
use App\Form\EtablissementScolaireType;
use App\Repository\EtablissementScolaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etablissement/scolaire')]
class EtablissementScolaireController extends AbstractController
{
    #[Route('/', name: 'etablissement_scolaire_index', methods: ['GET'])]
    public function index(EtablissementScolaireRepository $etablissementScolaireRepository): Response
    {
        return $this->render('etablissement_scolaire/index.html.twig', [
            'etablissement_scolaires' => $etablissementScolaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'etablissement_scolaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etablissementScolaire = new EtablissementScolaire();
        $form = $this->createForm(EtablissementScolaireType::class, $etablissementScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etablissementScolaire);
            $entityManager->flush();

            return $this->redirectToRoute('etablissement_scolaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etablissement_scolaire/new.html.twig', [
            'etablissement_scolaire' => $etablissementScolaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'etablissement_scolaire_show', methods: ['GET'])]
    public function show(EtablissementScolaire $etablissementScolaire): Response
    {
        return $this->render('etablissement_scolaire/show.html.twig', [
            'etablissement_scolaire' => $etablissementScolaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'etablissement_scolaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtablissementScolaire $etablissementScolaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtablissementScolaireType::class, $etablissementScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('etablissement_scolaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etablissement_scolaire/edit.html.twig', [
            'etablissement_scolaire' => $etablissementScolaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'etablissement_scolaire_delete', methods: ['POST'])]
    public function delete(Request $request, EtablissementScolaire $etablissementScolaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissementScolaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissementScolaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etablissement_scolaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
