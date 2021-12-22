<?php

namespace App\Controller;

use App\Entity\NiveauFormation;
use App\Form\NiveauFormationType;
use App\Repository\NiveauFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/niveauformation')]
class NiveauFormationController extends AbstractController
{
    #[Route('/', name: 'niveau_formation_index', methods: ['GET'])]
    public function index(NiveauFormationRepository $niveauFormationRepository): Response
    {
        return $this->render('niveau_formation/index.html.twig', [
            'niveau_formations' => $niveauFormationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'niveau_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niveauFormation = new NiveauFormation();
        $form = $this->createForm(NiveauFormationType::class, $niveauFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveauFormation);
            $entityManager->flush();

            return $this->redirectToRoute('niveau_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('niveau_formation/new.html.twig', [
            'niveau_formation' => $niveauFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'niveau_formation_show', methods: ['GET'])]
    public function show(NiveauFormation $niveauFormation): Response
    {
        return $this->render('niveau_formation/show.html.twig', [
            'niveau_formation' => $niveauFormation,
        ]);
    }

    #[Route('/{id}/edit', name: 'niveau_formation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NiveauFormation $niveauFormation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiveauFormationType::class, $niveauFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('niveau_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('niveau_formation/edit.html.twig', [
            'niveau_formation' => $niveauFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'niveau_formation_delete', methods: ['POST'])]
    public function delete(Request $request, NiveauFormation $niveauFormation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niveauFormation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niveauFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('niveau_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
