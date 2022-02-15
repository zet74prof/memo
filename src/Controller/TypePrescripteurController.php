<?php

namespace App\Controller;

use App\Entity\TypePrescripteur;
use App\Form\TypePrescripteurType;
use App\Repository\TypePrescripteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeprescripteur')]
class TypePrescripteurController extends AbstractController
{
    #[Route('/', name: 'type_prescripteur_index', methods: ['GET'])]
    public function index(TypePrescripteurRepository $typePrescripteurRepository): Response
    {
        return $this->render('type_prescripteur/index.html.twig', [
            'type_prescripteurs' => $typePrescripteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_prescripteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typePrescripteur = new TypePrescripteur();
        $form = $this->createForm(TypePrescripteurType::class, $typePrescripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typePrescripteur);
            $entityManager->flush();

            return $this->redirectToRoute('type_prescripteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_prescripteur/new.html.twig', [
            'type_prescripteur' => $typePrescripteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_prescripteur_show', methods: ['GET'])]
    public function show(TypePrescripteur $typePrescripteur): Response
    {
        return $this->render('type_prescripteur/show.html.twig', [
            'type_prescripteur' => $typePrescripteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_prescripteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypePrescripteur $typePrescripteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypePrescripteurType::class, $typePrescripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_prescripteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_prescripteur/edit.html.twig', [
            'type_prescripteur' => $typePrescripteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_prescripteur_delete', methods: ['POST'])]
    public function delete(Request $request, TypePrescripteur $typePrescripteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePrescripteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typePrescripteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_prescripteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
