<?php

namespace App\Controller;

use App\Entity\Bailleur;
use App\Form\BailleurType;
use App\Repository\BailleurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bailleur')]
class BailleurController extends AbstractController
{
    #[Route('/', name: 'bailleur_index', methods: ['GET'])]
    public function index(BailleurRepository $bailleurRepository): Response
    {
        return $this->render('bailleur/index.html.twig', [
            'bailleurs' => $bailleurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'bailleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bailleur = new Bailleur();
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bailleur);
            $entityManager->flush();

            return $this->redirectToRoute('bailleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bailleur/new.html.twig', [
            'bailleur' => $bailleur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bailleur_show', methods: ['GET'])]
    public function show(Bailleur $bailleur): Response
    {
        return $this->render('bailleur/show.html.twig', [
            'bailleur' => $bailleur,
        ]);
    }

    #[Route('/{id}/edit', name: 'bailleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bailleur $bailleur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('bailleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bailleur/edit.html.twig', [
            'bailleur' => $bailleur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bailleur_delete', methods: ['POST'])]
    public function delete(Request $request, Bailleur $bailleur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bailleur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bailleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bailleur_index', [], Response::HTTP_SEE_OTHER);
    }
}
