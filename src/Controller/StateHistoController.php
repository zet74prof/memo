<?php

namespace App\Controller;

use App\Entity\StateHisto;
use App\Form\StateHistoType;
use App\Repository\StateHistoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statehisto')]
class StateHistoController extends AbstractController
{
    #[Route('/', name: 'state_histo_index', methods: ['GET'])]
    public function index(StateHistoRepository $stateHistoRepository): Response
    {
        return $this->render('state_histo/index.html.twig', [
            'state_histos' => $stateHistoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'state_histo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stateHisto = new StateHisto();
        $form = $this->createForm(StateHistoType::class, $stateHisto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stateHisto);
            $entityManager->flush();

            return $this->redirectToRoute('state_histo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('state_histo/new.html.twig', [
            'state_histo' => $stateHisto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'state_histo_show', methods: ['GET'])]
    public function show(StateHisto $stateHisto): Response
    {
        return $this->render('state_histo/show.html.twig', [
            'state_histo' => $stateHisto,
        ]);
    }

    #[Route('/{id}/edit', name: 'state_histo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StateHisto $stateHisto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StateHistoType::class, $stateHisto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('state_histo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('state_histo/edit.html.twig', [
            'state_histo' => $stateHisto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'state_histo_delete', methods: ['POST'])]
    public function delete(Request $request, StateHisto $stateHisto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stateHisto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stateHisto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('state_histo_index', [], Response::HTTP_SEE_OTHER);
    }
}
