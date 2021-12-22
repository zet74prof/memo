<?php

namespace App\Controller;

use App\Entity\QPV;
use App\Form\QPVType;
use App\Repository\QPVRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/qpv')]
class QPVController extends AbstractController
{
    #[Route('/', name: 'q_p_v_index', methods: ['GET'])]
    public function index(QPVRepository $qPVRepository): Response
    {
        return $this->render('qpv/index.html.twig', [
            'q_p_vs' => $qPVRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'q_p_v_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $qPV = new QPV();
        $form = $this->createForm(QPVType::class, $qPV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($qPV);
            $entityManager->flush();

            return $this->redirectToRoute('q_p_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('qpv/new.html.twig', [
            'q_p_v' => $qPV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'q_p_v_show', methods: ['GET'])]
    public function show(QPV $qPV): Response
    {
        return $this->render('qpv/show.html.twig', [
            'q_p_v' => $qPV,
        ]);
    }

    #[Route('/{id}/edit', name: 'q_p_v_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, QPV $qPV, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QPVType::class, $qPV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('q_p_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('qpv/edit.html.twig', [
            'q_p_v' => $qPV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'q_p_v_delete', methods: ['POST'])]
    public function delete(Request $request, QPV $qPV, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qPV->getId(), $request->request->get('_token'))) {
            $entityManager->remove($qPV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('q_p_v_index', [], Response::HTTP_SEE_OTHER);
    }
}
