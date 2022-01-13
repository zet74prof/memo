<?php

namespace App\Controller;

use App\Entity\TypeEnseignement;
use App\Form\TypeEnseignementType;
use App\Repository\TypeEnseignementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeenseignement')]
class TypeEnseignementController extends AbstractController
{
    #[Route('/', name: 'type_enseignement_index', methods: ['GET'])]
    public function index(TypeEnseignementRepository $typeEnseignementRepository): Response
    {
        return $this->render('type_enseignement/index.html.twig', [
            'type_enseignements' => $typeEnseignementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_enseignement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeEnseignement = new TypeEnseignement();
        $form = $this->createForm(TypeEnseignementType::class, $typeEnseignement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeEnseignement);
            $entityManager->flush();

            return $this->redirectToRoute('type_enseignement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_enseignement/new.html.twig', [
            'type_enseignement' => $typeEnseignement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_enseignement_show', methods: ['GET'])]
    public function show(TypeEnseignement $typeEnseignement): Response
    {
        return $this->render('type_enseignement/show.html.twig', [
            'type_enseignement' => $typeEnseignement,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_enseignement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeEnseignement $typeEnseignement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeEnseignementType::class, $typeEnseignement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_enseignement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_enseignement/edit.html.twig', [
            'type_enseignement' => $typeEnseignement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_enseignement_delete', methods: ['POST'])]
    public function delete(Request $request, TypeEnseignement $typeEnseignement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEnseignement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeEnseignement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_enseignement_index', [], Response::HTTP_SEE_OTHER);
    }
}
