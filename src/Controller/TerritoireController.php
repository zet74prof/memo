<?php

namespace App\Controller;

use App\Entity\Territoire;
use App\Form\TerritoireType;
use App\Repository\TerritoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/territoire')]
class TerritoireController extends AbstractController
{
    #[Route('/', name: 'territoire_index', methods: ['GET'])]
    public function index(TerritoireRepository $territoireRepository): Response
    {
        return $this->render('territoire/index.html.twig', [
            'territoires' => $territoireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'territoire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $territoire = new Territoire();
        $form = $this->createForm(TerritoireType::class, $territoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($territoire);
            $entityManager->flush();

            return $this->redirectToRoute('territoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('territoire/new.html.twig', [
            'territoire' => $territoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'territoire_show', methods: ['GET'])]
    public function show(Territoire $territoire): Response
    {
        return $this->render('territoire/show.html.twig', [
            'territoire' => $territoire,
        ]);
    }

    #[Route('/{id}/edit', name: 'territoire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Territoire $territoire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerritoireType::class, $territoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('territoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('territoire/edit.html.twig', [
            'territoire' => $territoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'territoire_delete', methods: ['POST'])]
    public function delete(Request $request, Territoire $territoire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$territoire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($territoire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('territoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
