<?php

namespace App\Controller;

use App\Entity\TypeFormation;
use App\Form\TypeFormationType;
use App\Repository\TypeFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeformation')]
class TypeFormationController extends AbstractController
{
    #[Route('/', name: 'type_formation_index', methods: ['GET'])]
    public function index(TypeFormationRepository $typeFormationRepository): Response
    {
        return $this->render('type_formation/index.html.twig', [
            'type_formations' => $typeFormationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeFormation = new TypeFormation();
        $form = $this->createForm(TypeFormationType::class, $typeFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeFormation);
            $entityManager->flush();

            return $this->redirectToRoute('type_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_formation/new.html.twig', [
            'type_formation' => $typeFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_formation_show', methods: ['GET'])]
    public function show(TypeFormation $typeFormation): Response
    {
        return $this->render('type_formation/show.html.twig', [
            'type_formation' => $typeFormation,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_formation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeFormation $typeFormation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeFormationType::class, $typeFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_formation/edit.html.twig', [
            'type_formation' => $typeFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_formation_delete', methods: ['POST'])]
    public function delete(Request $request, TypeFormation $typeFormation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFormation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
