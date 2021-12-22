<?php

namespace App\Controller;

use App\Entity\Prescripteur;
use App\Form\PrescripteurType;
use App\Repository\PrescripteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/prescripteur')]
class PrescripteurController extends AbstractController
{
    #[Route('/', name: 'prescripteur_index', methods: ['GET'])]
    public function index(PrescripteurRepository $prescripteurRepository): Response
    {
        return $this->render('prescripteur/index.html.twig', [
            'prescripteurs' => $prescripteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'prescripteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prescripteur = new Prescripteur();
        $form = $this->createForm(PrescripteurType::class, $prescripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prescripteur);
            $entityManager->flush();

            return $this->redirectToRoute('prescripteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prescripteur/new.html.twig', [
            'prescripteur' => $prescripteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'prescripteur_show', methods: ['GET'])]
    public function show(Prescripteur $prescripteur): Response
    {
        return $this->render('prescripteur/show.html.twig', [
            'prescripteur' => $prescripteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'prescripteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prescripteur $prescripteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrescripteurType::class, $prescripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('prescripteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prescripteur/edit.html.twig', [
            'prescripteur' => $prescripteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'prescripteur_delete', methods: ['POST'])]
    public function delete(Request $request, Prescripteur $prescripteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prescripteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prescripteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prescripteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
