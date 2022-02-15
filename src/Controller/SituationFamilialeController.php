<?php

namespace App\Controller;

use App\Entity\SituationFamiliale;
use App\Form\SituationFamilialeType;
use App\Repository\SituationFamilialeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/situationfamiliale')]
class SituationFamilialeController extends AbstractController
{
    #[Route('/', name: 'situation_familiale_index', methods: ['GET'])]
    public function index(SituationFamilialeRepository $situationFamilialeRepository): Response
    {
        return $this->render('situation_familiale/index.html.twig', [
            'situation_familiales' => $situationFamilialeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'situation_familiale_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $situationFamiliale = new SituationFamiliale();
        $form = $this->createForm(SituationFamilialeType::class, $situationFamiliale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($situationFamiliale);
            $entityManager->flush();

            return $this->redirectToRoute('situation_familiale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('situation_familiale/new.html.twig', [
            'situation_familiale' => $situationFamiliale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'situation_familiale_show', methods: ['GET'])]
    public function show(SituationFamiliale $situationFamiliale): Response
    {
        return $this->render('situation_familiale/show.html.twig', [
            'situation_familiale' => $situationFamiliale,
        ]);
    }

    #[Route('/{id}/edit', name: 'situation_familiale_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SituationFamiliale $situationFamiliale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SituationFamilialeType::class, $situationFamiliale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('situation_familiale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('situation_familiale/edit.html.twig', [
            'situation_familiale' => $situationFamiliale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'situation_familiale_delete', methods: ['POST'])]
    public function delete(Request $request, SituationFamiliale $situationFamiliale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$situationFamiliale->getId(), $request->request->get('_token'))) {
            $entityManager->remove($situationFamiliale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('situation_familiale_index', [], Response::HTTP_SEE_OTHER);
    }
}
